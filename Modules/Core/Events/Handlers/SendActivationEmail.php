<?php

namespace Modules\Core\Events\Handlers;

use Modules\Core\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Core\Entities\Activity;


class sendActivationEmail
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

        if(isset($event->data['send_activation_email']))
        {
            $activity = new Activity();
            $activity->type = 'user-activation-email';
            $activity->label = 'activation email';
            $activity->title = $event->data['user']->name." / ".$event->data['user']->email.' - Activation Email Sent';
            $activity->table_name = 'core_users';
            $activity->table_id = $event->data['user']->id;
            $activity->save();
        }

    }
}
