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
        $this->data->view = "blockui::frontend.theme-v1.pages.";
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
    public function getCategories(Request $request)
    {
        $list = \Storage::directories('/public/blocks');

        $result = [];

        foreach($list as $item)
        {
            $item = str_replace("public/blocks/", "", $item);
            $result[] = $item;
        }

        $response['status'] = 'success';
        $response['data'] = $result;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------
    public function getBlocks(Request $request)
    {
        $rules = array(
            'category' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();


        $data = [];

        $path = "public/blocks/".$inputs['category'];

        $list = \Storage::directories($path);

        $result = [];

        $i = 0;
        foreach($list as $block_path)
        {
            $json_path = \Storage::disk('local')->get($block_path."/config.json");
            $result[$i] = json_decode($json_path, true);

            if(isset($result[$i]['thumbnail']))
            {
                $thumbnail = url("/").\Storage::disk('local')->url("app/".$block_path."/".$result[$i]['thumbnail']);
                $result[$i]['thumbnail'] = $thumbnail;
            }

            $i++;
        }

        $response['status'] = 'success';
        $response['data'] = $result;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------

    //-----------------------------------------------------------------------------
    public function getBlock(Request $request)
    {
        $rules = array(
            'category' => 'required',
            'name' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }

        $inputs = $request->all();


        $block_path = 'public/blocks/'.$inputs['category']."/".$inputs['name'];
        $json_path = \Storage::disk('local')->get($block_path."/config.json");
        $data['config'] = json_decode($json_path, true);

        $path = $block_path."/index.html";
        $source = \Storage::disk('local')->get($path);

        $extractor = new Extractor();
        $data['html'] = $extractor->extractUnit($source, "<!--#blockui-html#-->", "<!--/#blockui-html#-->");
        $data['css'] = strip_tags($extractor->extractUnit($source, "<!--#blockui-css#-->", "<!--/#blockui-css#-->"));
        $data['js'] = strip_tags($extractor->extractUnit($source, "<!--#blockui-js#-->", "<!--/#blockui-js#-->"));
        $data['iframe'] = url("/").\Storage::disk('local')->url("app/public/blocks/".$inputs['category']."/".$inputs['name']."/index.html");

        $response['status'] = 'success';
        $response['data'] = $data;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------

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
