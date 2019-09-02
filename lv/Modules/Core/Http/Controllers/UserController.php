<?php
namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;
use Validator;

class UserController extends Controller
{
    public $data;

    function __construct()
    {
        $this->data = new \stdClass();
    }

    //--------------------------------------------------------
    public function login(Request $request)
    {



        $domain = getDomain();

        if($domain == 'assignable.io')
        {
            return response('Unauthorized.', 401);
        }

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
    public function register()
    {
        $this->data->body_class = "animsition page-login-v3 layout-full";
        return view('core::frontend.register')->with('data', $this->data);
    }

    //--------------------------------------------------------
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), User::rulesAdminCreate());
        if ($validator->fails()) {
            if ($request->ajax()) {
                $errors = $validator->errors();
                $response['status'] = 'failed';
                $response['errors'] = $errors;
                return response()->json($response);
            } else {
                return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        //check if admin role exist
        if (!Role::where('slug', 'admin')->exists())
        {
            $role = new Role();
            $role->name = 'Admin';
            $role->slug = str_slug($role->name);
            $role->enable = 1;
            $role->save();
        }
        $role = Role::where('slug', '=', 'admin')->first();
        try {

            if (!User::where('email', $request->get('email'))->exists())
            {
                $user = new User();
                $user->name = request('name', $default = null);
                $user->email = request('email', $default = null);
                $user->mobile = request('mobile', $default = null);
                $user->username = request('username', $default = null);
                $user->password = Hash::make(request('password', $default = null));
                $user->enable = 1;
                $user->api_token = md5(uniqid(rand(), true));
                $user->save();
            }
            $user = User::where('email', $request->get('email'))->first();
            $user->roles()->attach($role->id);

            //Enable All the modules
            $modules = \NwidartModule::all();
            $modules = (array)json_decode(json_encode($modules));
            foreach ($modules as $module=>$values)
            {
                $module = \NwidartModule::find(strtolower($module));
                $module->enable();
            }


            $response['status'] = 'success';
            $response['redirect'] = \URL::route('core.frontend.login');
            $response['data'] = $user;

        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }

        if ($request->ajax()) {
            return response()->json($response);
        } else {
            return \Redirect::route('core.frontend.login');
        }
    }

    //--------------------------------------------------------
    public function index()
    {
        if (!\Auth::user()->hasPermission($this->data->permission->prefix,
                                          $this->data->permission->pretext . "read")
        ) {
            return redirect()->route('core.backend.dashboard')
                ->withErrors([getConstant('permission.denied')]);
        }
        $this->data->title = "Roles";
        return view($this->data->view . "index")
            ->with("data", $this->data);
    }
    //--------------------------------------------------------



    //--------------------------------------------------------
    //--------------------------------------------------------
}
