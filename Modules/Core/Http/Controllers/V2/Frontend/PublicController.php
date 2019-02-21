<?php
namespace Modules\Core\Http\Controllers\V2\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller {
    //--------------------------------------------------------------------------
    public $data;

    function __construct( Request $request ) {
        $this->data                      = new \stdClass();
        $this->data->view = "core::themes.theme-v2.frontend.";
    }

    //--------------------------------------------------------------------------
    public function ui(Request $request) {
        $this->data->title = "UI Elements";

        $this->data->element = "";
        if($request->has('element'))
        {
            $this->data->element = view( $this->data->view."ui.elements.".$request->element )
                ->render();
        }


        return view( $this->data->view."ui.ui" )
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
