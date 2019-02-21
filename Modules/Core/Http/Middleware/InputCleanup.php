<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputCleanup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->input();

        foreach ($input as $key => $value)
        {
            if(empty($value) || $value == "")
            {
                unset($input[$key]);
            }

        }

        $request->replace($input);

        return $next($request);
    }
}
