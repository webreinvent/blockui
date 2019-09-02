<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Core\Entities\Permission;


class PermissionsController extends Controller {
	public $data;

	function __construct( Request $request ) {
		$this->data        = new \stdClass();
		$this->data->view  = "core::backend.permissions.";
		$this->data->permission  = new \stdClass();
		$this->data->permission->prefix = "core";
		$this->data->permission->pretext = "backend-admin-permission-";
		$this->data->input = $request->all();
	}

	//------------------------------------------------------
	public function index() {
		$this->data->title = "Permissions";

		return view( $this->data->view . "index" )
			->with( "data", $this->data );
	}

	//------------------------------------------------------
	public function getList( Request $request ) {
		$list = Permission::withCount( [ 'roles' ] );
		if ( $request->has( "s" ) )
		{
			$list->where( "name", "like", "%" . $request->get( 's' ) . "%" )
			     ->orWhere( "prefix", "like", "%" . $request->get( 's' ) . "%" );
		}
		$config = \Config::get("core");
		$list->orderBy("created_at", 'desc');
		$data['list'] = $list->paginate( $config['settings']->records_per_page );

        $data['html'] = view( $this->data->view . "list" )
            ->with( "data", $data )->render();

		return response()->json( $data );
	}

	//------------------------------------------------------
	public function toggle( Request $request ) {
		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext."update" ) )
		{
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}
		$input = $request->all();
		try {
			$permission = Permission::findOrFail( $input['id'] );
			if ( $request->has( "enable" ) ) {
				$permission->enable = $request->get( "enable" );
			} else {
				if ( $permission->enable == 1 ) {
					$permission->enable = 0;
				} else {
					$permission->enable = 1;
				}
			}
			$permission->save();
			$response['status'] = 'success';
			$response['data']   = $permission;
		} catch ( Exception $e ) {
			$response['status']   = 'failed';
			$response['errors'][] = $e->getMessage();
		}

		return response()->json( $response );
	}
	//------------------------------------------------------
	public function read(Request $request, $id)
	{

		if ( ! \Auth::user()->hasPermission( $this->data->permission->prefix,
			$this->data->permission->pretext."read" ) )
		{
			$response['status']   = 'failed';
			$response['errors'][] = getConstant( 'permission.denied' );

			return response()->json( $response );
		}

		try{
			$this->data->item = Permission::with(['roles', 'createdBy',
				'updatedBy', 'deletedBy'])->findOrFail($id);

            $response['status'] = 'success';
            $response['html'] = view( $this->data->view . "item" )
                ->with( "data", $this->data )->render();

            return response()->json($response);
		}catch(Exception $e)
		{
		    $response['status'] = 'failed';
		    $response['errors'][] = $e->getMessage();
		    return response()->json($response);
		}
	}
	//------------------------------------------------------
}
