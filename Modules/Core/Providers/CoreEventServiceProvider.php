<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Core\Entities\Activity;
use Modules\Core\Entities\Permission;
use Modules\Core\Observers\PermissionObserver;
use Modules\Core\Observers\RoleObserver;
use Modules\Core\Observers\UserObserver;
use Modules\Core\Observers\ActivityObserver;
use Modules\Core\Entities\User;
use Modules\Core\Entities\Role;

class CoreEventServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

	//---------------------------------------------

	protected $listen = [
		'Modules\Core\Events\UserLoggedIn' => [
			'Modules\Core\Events\Handlers\OnUserLoggedIn',
		],
        'Modules\Core\Events\UserCreated' => [
            'Modules\Core\Events\Handlers\SendActivationEmail',
            'Modules\Core\Events\Handlers\SendWelcomeEmail',
        ],

        'Modules\Core\Events\InformErrorAdmin' => [
            'Modules\Core\Events\Handlers\FailureMailErrorAdmin',
        ],

        'Illuminate\Mail\Events\MessageSending' => [
            'Modules\Core\Events\Handlers\LogSentMessage',
        ],



	];

	//---------------------------------------------

	public function boot()
	{
		parent::boot();
		User::observe(UserObserver::class);
		Role::observe(RoleObserver::class);
		Permission::observe(PermissionObserver::class);
		Activity::observe(ActivityObserver::class);
	}

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
