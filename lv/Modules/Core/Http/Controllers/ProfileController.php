<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Entities\Activity;
use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;

use Validator;


class ProfileController extends Controller {
	//------------------------------------------------------
	public $data;

	function __construct( Request $request ) {
	    $this->data                      = new \stdClass();
		$this->data->view                = "core::backend.";
	}

	//------------------------------------------------------
	public function index(Request $request, $id = NULL)
    {
	    if($id != NULL && $id != \Auth::user()->id)
        {
            if (!\Auth::user()->hasPermission( 'core', 'core-can-see-others-profile'))
            {
                return redirect()->route('core.backend.dashboard')
                    ->with('flash_error', trans( 'core::messages.permission-denied' ));
            }
        }

		$this->data->body_class = "page-profile";
		$this->data->title = "Profile";
		return view( $this->data->view . "profile" )
			->with( "data", $this->data );
	}

	//--------------------------------------------------------
    public function getProfileData(Request $request, $id = NULL)
    {
        if($id != NULL && $id != \Auth::user()->id)
        {
            if (!\Auth::user()->hasPermission( 'core', 'core-can-see-others-profile'))
            {
                $response['status'] = 'failed';
                $response['errors'][]= trans( 'core::messages.permission-denied' );
                if ($request->ajax()) {
                    return response()->json($response);
                } else {
                    return redirect()->back()->withInput()->withErrors($response['errors']);
                }
            }
        } else
        {
            $id = \Auth::user()->id;
        }
        $user = User::where('id', $id)->with(['roles'])->first();
        if(!$user)
        {
            $response['status'] = 'failed';
            $response['errors'][]= trans( 'core::messages.not-exist' );;
            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->route('core.backend.dashboard')->withErrors($response['errors']);
            }
        }

        $response['status'] = 'success';
        $response['data']= $user;
        return response()->json($response);
    }
	//--------------------------------------------------------
    public function updateProfile(Request $request)
    {
        $rules = array(
            'id' => 'required',
            'email' => 'email',
            'birth_date' => 'date',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            return response()->json($response);
        }


        if($request->get('id') != NULL && $request->get('id') != \Auth::user()->id)
        {
            if (!\Auth::user()->hasPermission( 'core', 'core-can-update-others-profile'))
            {
                $response['status'] = 'failed';
                $response['errors'][] = trans( 'core::messages.not-exist' );
                return response()->json($response);
            }
        }


        $user = User::find($request->get('id'));
        if($request->exists('name'))
        {
            $user->name = $request->get('name');
        }

        if($request->exists('email'))
        {
            $user->email = $request->get('email');
        }

        if($request->exists('mobile'))
        {
            $user->mobile = $request->get('mobile');
        }

        if($request->exists('country_calling_code'))
        {
            $user->country_calling_code = $request->get('country_calling_code');
        }

        if($request->exists('gender'))
        {
            $user->gender = $request->get('gender');
        }

        if($request->exists('birth_date'))
        {
            $user->birth_date = $request->get('birth_date');
        }

        if($request->exists('password'))
        {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        $user = User::where('id', $user->id)->with(['roles'])->first();
        $response['status'] = 'success';
        $response['data']= $user;
        return response()->json($response);
    }
	//--------------------------------------------------------
    public function profileActivities(Request $request)
    {
        $rules = array(
            'id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {
            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $user = User::findOrFail($request->id);
        $response['status'] = 'success';
        $response['data']= $user->activities()->with(['createdBy'])->orderBy('created_at', 'DESC')->paginate(1);

        return response()->json($response);
    }
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------
}
