<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blockui\Libraries\Extractor;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $extractor = new Extractor();

        //$list = \Storage::directories('/public/blocks/nav');

        $test = \Storage::disk('local')->get('/public/blocks/nav/cake/index.html');


        $html = $extractor->extractUnit($test, "<!--#blockui-html#-->", "<!--/#blockui-html#-->");
        $css = $extractor->extractUnit($test, "<!--#blockui-css#-->", "<!--/#blockui-css#-->");
        $js = $extractor->extractUnit($test, "<!--#blockui-js#-->", "<!--/#blockui-js#-->");
        $html = strip_tags($js);




        echo "<pre>";
        print_r($html);
        echo "</pre>";
        die("<hr/>line number=123");


        return view('welcome');
    }
}
