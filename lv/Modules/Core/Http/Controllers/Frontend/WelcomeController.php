<?php

namespace Modules\Core\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


class WelcomeController extends Controller
{

    public $data;

    function __construct( Request $request ) {
        $this->data                      = new \stdClass();
    }
    //--------------------------------------------------------
    public function index(Request $request)
    {


        $this->data->session = session()->all();
        $this->data->body_class = "animsition page-login-v3 layout-full site-menubar-fold";
        $this->data->email = null;
        $email = \Cookie::get('email');

        if($email)
        {
            $this->data->email = $email;
        }

        return view('core::frontend.login')->with('data', $this->data);


    }

    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------
    //--------------------------------------------------------

}
