<?php

namespace Modules\Blockui\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Blockui\Libraries\Extractor;

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
        $list = \Storage::directories('/public/blocks/nav');

        $response['status'] = 'success';
        $response['data'] = $list;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------
    public function getBlock(Request $request)
    {

        $inputs = $request->all();

        $extractor = new Extractor();

        $data = [];

        $data['path'] = $inputs['path']."/index.html";

        $source = \Storage::disk('local')->get($data['path']);
        $data['html'] = $extractor->extractUnit($source, "<!--#blockui-html#-->", "<!--/#blockui-html#-->");
        $data['css'] = strip_tags($extractor->extractUnit($source, "<!--#blockui-css#-->", "<!--/#blockui-css#-->"));
        $data['js'] = strip_tags($extractor->extractUnit($source, "<!--#blockui-js#-->", "<!--/#blockui-js#-->"));

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
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
