<?php

namespace Modules\Blockui\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Blockui\Entities\BuiFramework;
use Modules\Blockui\Entities\BuiTheme;


class BlockuiController extends Controller
{
    public $data;

    function __construct(Request $request)
    {
        $this->data = new \stdClass();
        $this->data->view = "blockui::backend.pages.";
    }
    //-----------------------------------------------------------------------------
    public function manage(Request $request)
    {


        return view($this->data->view . "manage")
            ->with("data", $this->data);
    }
    //-----------------------------------------------------------------------------
    public function store(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'type' => 'required',
        );

        $validator = \Validator::make( $request->all(), $rules);
        if ( $validator->fails() ) {

            $errors             = $validator->errors();
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return response()->json($response);
        }


        switch ($request->type)
        {
            case 'Framework':

                $item = BuiFramework::where('slug', str_slug($request->name))->first();
                if(!$item)
                {
                    $item = new BuiFramework();
                }
                break;

            //---------------------
            case 'Theme':
                $item = BuiTheme::where('slug', str_slug($request->name))->first();
                if(!$item)
                {
                    $item = new BuiTheme();
                }
                break;
            //---------------------
            //---------------------
            //---------------------

        }

        $data = [];

        if($item)
        {
            $item->fill($request->all());
            $item->slug = str_slug($request->name);
            $item->save();

            $data['item'] = $item;
        }



        $response['status'] = 'success';
        $response['messages'][] = 'Saved';
        $response['data'] = $data;

        return response()->json($response);

    }
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------
    //-----------------------------------------------------------------------------

}
