<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Entities\SmsAlert;
use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;
use Modules\Core\Emails\AdminWelcomeEmail;

use Modules\Core\Events\UserCreated;
use Modules\Core\Notifications\UserDisabled;
use Validator;


class UsersController extends Controller {
	//------------------------------------------------------
	public $data;

	function __construct( Request $request ) {
		$this->data                      = new \stdClass();
		$this->data->view                = "core::backend.users.";
		$this->data->route               = "core.backend.users";

		$this->data->input               = $request->all();

		//permissions
		$this->data->permission          = new \stdClass();
		$this->data->permission->prefix  = "core"; // Module Name
		$this->data->permission->pretext = "backend-admin-user-"; // permissions pre-fix
	}

	//------------------------------------------------------
	public function index() {



		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			return redirect()->route('core.backend.dashboard')
			                 ->withErrors([getConstant( 'permission.denied' )]);
		}

		$this->data->body_class = "page-user";

		$this->data->title = "Users List";
		$this->data->roles = Role::enabled()->get();



		return view( $this->data->view . "index" )
			->with( "data", $this->data );
	}

	//------------------------------------------------------
	public function getList( Request $request ) {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$list = User::withCount( ['roles'] );



        //------------shorted by
        if ( $request->has( "shorted-by" ) && $request->get( "shorted-by" ) != "All" ) {
            switch ($request->get( "shorted-by" ))
            {
                case 'Disabled':
                    $list->disabled();
                    break;
                //----------------------
                case 'Enabled':
                    $list->enabled();
                    break;
                //----------------------
                case 'Trashed':
                    $list->onlyTrashed();
                    break;
                //----------------------
                case 'Created Date':
                    $list->orderBy('created_at', 'DESC');
                    break;
                //----------------------
                case 'Recently Logged':
                    $list->orderBy('last_login', 'DESC');
                    break;
                //----------------------
                case 'Never Logged':
                    $list->whereNull('last_login');
                    break;
                //----------------------

            }
        } else
        {
            $list->orderBy('created_at', 'DESC');
        }
        //------------end of shorted by

        //------------search
		if ( $request->has( "s" ) ) {

            $search_text = $request->get( "s" );
            if( strpos( $search_text, ":" ) !== false )
            {
                $search_d =explode(":", $search_text); //name: pradeep email: pradeep@gmail.com mobile:9911889057

                switch($search_d[0])
                {
                    case 'name':
                        $list->where( "name", "like", "%" . $search_d[1] . "%" );
                        break;
                    //------------------------------
                    case 'mobile':
                        $list->where( "mobile", "like", "%" . $search_d[1] . "%" );
                        break;
                    //------------------------------
                    case 'email':
                        $list->where( "email", "like", "%" . $search_d[1] . "%" );
                        break;
                    //------------------------------
                    case 'role':
                        $list->whereHas('roles', function ($r) use($search_d) {
                            $r->where("name", "like", "%" . trim($search_d[1]) . "%" );
                        });
                        break;
                    //------------------------------
                }

            } else
            {
                $list->where( "name", "like", "%" . $search_text . "%" );
            }

			$list->withTrashed();
		}
        //------------end of search

		$config             = \Config::get( "core" );

		$data['list']       = $list->paginate( $config['settings']->records_per_page );



		$data['html']       = view( $this->data->view . "partials.index-items" )
            ->with( "data", $data )->render();



		$data['trashCount'] = Role::onlyTrashed()->count();

		return response()->json( $data );
	}
	//--------------------------------------------------------
	public function store( Request $request )
	{


		//verify the permission
		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "create" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		\Validator::extend('without_spaces', function($attr, $value){
			return preg_match('/^\S*$/u', $value);
		});


		//data validation
		$rules     = array(
			'name' => 'required|max:50',
			'email' => 'required|email|unique:core_users|max:255',
			'username' => 'without_spaces|unique:core_users|max:20',
			'password' => 'required|min:8'
		);

		$messages = array(
			'username.without_spaces' => "Username should not contain any space"
		);

		$validator = \Validator::make( (array) $this->data->input, $rules, $messages );
		if ( $validator->fails() ) {
			$errors             = $validator->errors();
			$response['status'] = 'failed';
			$response['errors'] = $errors;

			return response()->json( $response );
		}

		$except = ['_token', 'send_activation_email', 'send_welcome_email'];

        if(!isValidateDate($request->get('birth_date')))
        {
            $except[] = 'birth_date';
        }

		$fillable = $request->except($except);

        if(isset($fillable['password']))
        {
            $fillable['password'] = Hash::make( $fillable['password'] );
        }

        if(isset($fillable['mobile']))
        {
            $value = trim(str_replace("-", "", $fillable['mobile']));
            if(!$value)
            {
                $fillable['mobile'] = null;
            }
        }


        try {
			$user = User::create($fillable);

            //fire the event
            $event['user'] = $user;
            $event['send_activation_email'] = $request->get('send_activation_email', 0);
            $event['send_welcome_email'] = $request->get('send_welcome_email', 0);

            if($request->has('roles'))
            {
                $user->roles()->sync($request->get('roles'));
            }

            event(new UserCreated($event));



            $response['data'] = $user;
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );

	}
	//--------------------------------------------------------
    public function edit( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "update" )
        ) {
            return redirect()->route('core.backend.dashboard')
                ->withErrors([getConstant( 'permission.denied' )]);
        }

        $this->data->roles = Role::enabled()->get();
        $this->data->item = User::withTrashed()->findOrFail( $id );
        $this->data->itemRoles = $this->data->item->roles->pluck('id')->toArray();

        $this->data->title = "Edit - ".$this->data->item->name;


        return view( $this->data->view . "index-edit-form" )
            ->with( "data", $this->data );
    }
	//--------------------------------------------------------
    public function update( Request $request, $id ) {

        //verify the permission
        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "update" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        \Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });


        //data validation
        $rules     = array(
            'name' => 'required|max:50',
            'email' => 'required|email|max:255|unique:core_users,email,'.$id,
            'username' => 'without_spaces|max:20|unique:core_users,username,'.$id,
            'mobile' => 'required|unique:core_users,mobile,'.$id,
            'password' => 'min:8',
        );

        $messages = array(
            'username.without_spaces' => "Username should not contain any space"
        );

        $validator = \Validator::make( (array) $this->data->input, $rules, $messages );
        if ( $validator->fails() ) {
            $errors             = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            return response()->json( $response );
        }

        $except = ['_token', 'send_activation_email', 'send_welcome_email', 'roles'];

        if(!isValidateDate($request->get('birth_date')))
        {
            $except[] = 'birth_date';
        }


        $fillable = $request->except($except);

        if(isset($fillable['password']))
        {
            $fillable['password'] = Hash::make( $fillable['password'] );
        }

        if(isset($fillable['mobile']))
        {
            $value = trim(str_replace("-", "", $fillable['mobile']));
            if(!$value)
            {
                $fillable['mobile'] = null;
            }
        }


        try {
            $user = User::where('id', $id)->withTrashed()->update($fillable);
            $user = User::find($id);
            //fire the event
            $event['user'] = $user;
            $event['send_activation_email'] = $request->get('send_activation_email', 0);
            $event['send_welcome_email'] = $request->get('send_welcome_email', 0);


            if($request->has('roles'))
            {
                $user->roles()->sync($request->get('roles'));
            }

            //event(new UserCreated($event));

            $response['data'] = $user;
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function delete( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "delete" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        $user = User::withTrashed()->findOrFail( $id );
        try {
            $user->delete();
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function enable( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "update" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        $user = User::withTrashed()->findOrFail( $id );

        $user->enable = 1;

        try {
            $user->save();
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function disable( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "update" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        $user = User::withTrashed()->findOrFail( $id );

        $user->enable = 0;

        try {
            $user->save();
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function restore( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "update" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        $user = User::withTrashed()->findOrFail( $id );

        try {
            $user->restore();
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function permanentDelete( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "delete" )
        ) {
            $response['status']   = 'failed';
            $response['errors'][] = getConstant( 'permission.denied' );

            return response()->json( $response );
        }

        $user = User::withTrashed()->findOrFail( $id );


        if(count($user->roles) > 0)
        {
            $user->roles()->detach();
        }
        try {
            $user->forceDelete();
            $response['status'] = 'success';
        } catch ( Exception $e ) {
            $response['status']   = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        return response()->json( $response );
    }
	//--------------------------------------------------------
    public function view( Request $request, $id ) {

        if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
            $this->data->permission->pretext . "read" )
        ) {
            return redirect()->route('core.backend.users')
                ->withErrors([getConstant( 'permission.denied' )]);
        }

        $this->data->item = User::withTrashed()->findOrFail( $id );
        $this->data->avatar = User::avatar( $id );

        $this->data->title = $this->data->item->name;
        $this->data->body_class = "page-profile";


        return view( $this->data->view . "users-item" )
            ->with( "data", $this->data );
    }
	//--------------------------------------------------------
}
