<?php

namespace Modules\Core\Events\Handlers;

use Modules\Core\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Modules\Core\Entities\Activity;


class FailureMailErrorAdmin
{

    public function __construct()
    {
        //
    }


    public function handle(\Modules\Core\Events\InformErrorAdmin $event)
    {
        $activity = new Activity();
        if(isset($event->data['type']))
        {
            $activity->type = $event->data['type'];
        }

        if(isset($event->data['label'])){

            $activity->label = $event->data['label'];
        }

        if(isset($event->data['details']))
        {
            $activity->title = $event->data['details'];
        }
        $activity->meta = json_encode($event);
        $activity->save();

        //send error to admin using php mail function
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . env('ERROR_ADMIN_FROM_EMAIL');
        $headers .= "\r\n";
        $send_to = env('ERROR_ADMIN_TO_EMAIL');
        $subject = $event->data['details'];
        $message = "Results: " . print_r( $event, true );
        mail($send_to, $subject, $message, $headers);
    }
}
