<?php

namespace Modules\Core\Events\Handlers;

use Modules\Core\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Core\Entities\Activity;

class sendWelcomeEmail
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
     * @param \Modules\Core\Events\UserCreated $event
     * @return void
     */
    public function handle(\Modules\Core\Events\UserCreated $event)
    {


        if(isset($event->data['send_welcome_email']))
        {
            $activity = new Activity();
            $activity->type = 'user-welcome-email';
            $activity->label = 'welcome email';
            $activity->title = $event->data['user']->name . " / " . $event->data['user']->email . ' - Welcome Email Sent';
            $activity->table_name = 'core_users';
            $activity->table_id = $event->user->id;
            $activity->save();
        }




    }
}
