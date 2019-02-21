<?php

namespace Modules\Blockui\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    public $data;

    function __construct(Request $request)
    {
        $this->data = new \stdClass();
        $this->data->view = "blockui::frontend.pages.";
    }

    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    public function index(Request $request)
    {
        return view($this->data->view . "welcome")
            ->with("data", $this->data);
    }

    //-----------------------------------------------------------------------------
    public function getBlocks(Request $request)
    {
        $list = \Storage::directories('/public/blocks/');


        $response['status'] = 'success';
        $response['data'] = $list;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------
    public function blockCreate(Request $request)
    {



        return view($this->data->view . "pages.block-create")
            ->with("data", $this->data);
    }
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
}
