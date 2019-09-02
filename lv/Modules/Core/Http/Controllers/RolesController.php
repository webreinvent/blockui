<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;

class RolesController extends Controller {
	//------------------------------------------------------
	public $data;

	function __construct( Request $request ) {
		$this->data                      = new \stdClass();
		$this->data->view                = "core::backend.roles.";
		$this->data->route               = "core.backend.roles";
		$this->data->permission          = new \stdClass();
		$this->data->permission->prefix  = "core";
		$this->data->permission->pretext = "backend-admin-role-";
		$this->data->input               = $request->all();
	}

	//------------------------------------------------------
	public function index() {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			return redirect()->route('core.backend.dashboard')
				->withErrors([getConstant( 'permission.denied' )]);
		}

		$this->data->title = "Roles";

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

		$list = Role::withCount( [ 'users', 'permissions' ] );

		if ( $request->has( "s" ) ) {
			$list->where( "name", "like", "%" . $request->get( 's' ) . "%" );
			$list->withTrashed();
		} elseif ( $request->has( "trashed" ) && $request->get( "trashed" ) == 1 ) {
			$list->withTrashed();
			$list->orderBy( "deleted_at", "desc" );
		}

        $list->orderBy( "created_at", 'desc' );

		$config             = \Config::get( "core" );
		$data['list']       = $list->paginate( $config['settings']->records_per_page );
		$data['trashCount'] = Role::onlyTrashed()->count();
        $data['html'] = view( $this->data->view . "list" )
            ->with( "data", $data )->render();

		return response()->json( $data );
	}

	//------------------------------------------------------
	public function toggle( Request $request ) {
		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}
		$rules     = array(
			'id' => 'required',
		);
		$validator = \Validator::make( (array) $this->data->input, $rules );
		if ( $validator->fails() ) {
			$errors             = $validator->errors();
			$response['status'] = 'failed';
			$response['errors'] = $errors;

			return response()->json( $response );
		}
		$input = $request->all();
		try {
			$item = Role::withTrashed()->findOrFail( $input['id'] );
			if ( $request->has( "enable" ) ) {
				$item->enable = $request->get( "enable" );
			} else {
				if ( $item->enable == 1 ) {
					$item->enable = 0;
				} else {
					$item->enable     = 1;
					$item->deleted_at = null;
				}
			}
			$item->save();
			$response['status'] = 'success';
			$response['data']   = $item;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------

	//------------------------------------------------------
	public function store( Request $request )
	{

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$rules     = array(
			'name' => 'required|max:50',
		);
		$validator = \Validator::make( (array) $this->data->input, $rules );
		if ( $validator->fails() ) {
			$errors             = $validator->errors();
			$response['status'] = 'failed';
			$response['errors'] = $errors;

			return response()->json( $response );
		}
		$item       = new Role();
		$item->name = $request->get( 'name' );
		if ( $request->has( 'details' ) ) {
			$item->details = $request->get( 'name' );
		}
		if ( $request->has( 'enable' ) ) {
			$item->enable = $request->get( 'enable' );
		}
		try {
			$item->save();
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function read( Request $request, $id ) {
		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			return redirect()->route( $this->data->route )
			                 ->withErrors( [ getConstant( 'permission.denied' ) ] );
		}
		$this->data->item  = Role::withTrashed()->with( [
			'createdBy',
			'updatedBy',
			'deletedBy'
		] )->findOrFail( $id );
		$this->data->title = $this->data->item->name;

		return view( $this->data->view . "item" )
			->with( "data", $this->data );
	}

	//------------------------------------------------------

	//------------------------------------------------------
	public function update( Request $request ) {


		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			return redirect()->route( $this->data->route )
			                 ->withErrors( [ getConstant( 'permission.denied' ) ] );
		}
		$rules = array(
			'id'   => 'required',
			'slug' => 'required|unique:core_roles,slug,' . $this->data->input['id'],
		);
		$validator = \Validator::make( $this->data->input, $rules );
		if ( $validator->fails() ) {
			$errors             = $validator->errors();
			$response['status'] = 'failed';
			$response['errors'] = $errors;

			return response()->json( $response );
		}
		$item = Role::withTrashed()->findOrFail( $this->data->input['id'] );
		try {

			$item->fill( $request->all() );
			$item->save();
			$response['status'] = 'success';
			$response['inputs'] = $request->all();
			$response['data'] = $item;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function delete( Request $request) {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "delete" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}
		$rules = array(
		    'id' => 'required',
		);

		$validator = \Validator::make( $request->all(), $rules);
		if ( $validator->fails() ) {

		    $errors             = errorsToArray($validator->errors());
		    $response['status'] = 'failed';
		    $response['errors'] = $errors;

		    if ($request->ajax()) {
		        return response()->json($response);
		    } else {
		        return redirect()->back()->withInput()->withErrors($errors);
		    }
		}


		$item = Role::withTrashed()->findOrFail( $request->get('id') );
		try {
			$item->delete();
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function restore( Request $request) {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

        $rules = array(
            'id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

		$item = Role::withTrashed()->findOrFail( $request->get('id') );
		try {
			$item->restore();
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function deletePermanent( Request $request ) {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

        $rules = array(
            'id' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;

            if ($request->ajax()) {
                return response()->json($response);
            } else {
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

		$item = Role::withTrashed()->findOrFail( $request->get('id') );
		try {
			$item->permissions()->detach();
			$item->users()->detach();
			$item->forceDelete();
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function readDetails( $id ) {

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$this->data->item = Role::withTrashed()->findOrFail( $id );
		try {
			$data               = view( $this->data->view . "partials.item-table" )
				->with( "data", $this->data )->render();
			$response['status'] = 'success';
			$response['data']   = $data;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function stats( $id )
	{
		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$this->data->item = Role::withTrashed()->withCount( [ 'users', 'permissions' ] )->findOrFail( $id );
		try {
			$data               = view( $this->data->view . "partials.item-stats" )
				->with( "data", $this->data )->render();
			$response['status'] = 'success';
			$response['data']   = $data;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function permissions( Request $request, $id )
	{

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "read" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$this->data->item                 = Role::withTrashed()->findOrFail( $id );
        $this->data->item->permission_ids = $this->data->item->permissions()->get()->pluck('id')->toArray();
		$permissions                      = Permission::enabled();
		if ( $request->has( 's' ) ) {
			$permissions->where( "name", "like", "%" . $request->get( 's' ) . "%" );
		}
		$this->data->permissions = $permissions->get();
		try {
			$data = view( $this->data->view . "partials.item-permissions" )
				->with( "data", $this->data )->render();
			$response['status'] = 'success';
			$response['data']   = $data;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}

	//------------------------------------------------------
	public function permissionsToggle( Request $request, $id, $permission_id )
	{

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext . "update" )
		) {
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		$item = Role::withTrashed()->findOrFail( $id );
		$exist = $item->permissions->contains( $permission_id );
		try {
			if ( $exist ) {
				$item->permissions()->detach( $permission_id );
			} else {
				$item->permissions()->attach( $permission_id );
			}
			$response['status'] = 'success';
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}
	//------------------------------------------------------
	//------------------------------------------------------
	//------------------------------------------------------
}
