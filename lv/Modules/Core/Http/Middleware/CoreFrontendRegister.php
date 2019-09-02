<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;

class CoreFrontendRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

    	//check admin role & user exist
	    $role = new Role();
	    $user = new User();
	    $role = $role->slug('admin')->first();
	    $admins = $user->countAdmins();
	    if($role['status'] == 'success' && $admins > 0)
	    {
		    return redirect()->route('core.frontend.login');
	    }

        return $next($request);
    }
}
