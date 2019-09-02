<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;


use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\Module;
use Validator;


class DashboardController extends Controller
{
	public $data;

	function __construct()
	{
		$this->data = new \stdClass();
	}
	//--------------------------------------------------------
	public function index(Request $request )
	{
		$this->data->body_class = "dashboard";
		$this->data->title = "Dashboard";



		return view( 'core::backend.dashboard' )->with( 'data', $this->data );
	}
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------
	//--------------------------------------------------------

}
