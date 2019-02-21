<?php

namespace Modules\Core\Events\Handlers;

use Modules\Core\Events\UserLoggedIn;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Core\Entities\Activity;

class OnUserLoggedIn
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \Modules\Core\Events\UserLoggedIn $event
     * @return void
     */
    public function handle(\Modules\Core\Events\UserLoggedIn $event)
    {
	    $activity = new Activity();
	    $activity->type = 'login';
	    $activity->label = 'logged in';
        $activity->table_name = 'core_users';

        if($event->user)
        {
            $activity->title = $event->user->name.' is logged in';
            $activity->table_id = $event->user->id;
        }

	    $activity->save();
    }
}
