<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller {
    //--------------------------------------------------------------------------
	public $data;

	function __construct( Request $request ) {
		$this->data                      = new \stdClass();
        $this->data->view = "core::themes.theme-v1.frontend.";
	}

	//--------------------------------------------------------------------------
    public function ui() {
        $this->data->title = "UI Elements";
        return view( $this->data->view."ui" )
            ->with( "data", $this->data );
    }
	//--------------------------------------------------------------------------
	public function login() {


		$this->data->title = "Core Login";

		return view( $this->data->view."login" )
			->with( "data", $this->data );
	}
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
    //--------------------------------------------------------------------------
}
