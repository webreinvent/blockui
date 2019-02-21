<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {


        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapFrontendRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/api.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFrontendRoutes()
    {



        $base_url = \URL::to("/");

        if(isset($_SERVER['HTTP_HOST']))
        {
            $host = $_SERVER['HTTP_HOST'];
        }

        $ip_arr = [];
        $ip = null;

        if(isset($_SERVER['REMOTE_ADDR']))
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }




        $frontend_routes_path = null;


        //------------load on localhost
        if(!isset($host) || $host == 'localhost' )
        {
            $frontend_routes_path = __DIR__ . '/../../Blockui/Routes/frontend.php';

        }

        //------------load assignable
        if( isset($host) && $host == 'blockui.io'
        )
        {
            $frontend_routes_path = __DIR__ . '/../../Blockui/Routes/frontend.php';

        }



        Route::middleware('web')
            ->group($frontend_routes_path);
    }


}
