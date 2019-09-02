<?php

namespace Modules\Core\Events\Handlers;

use Log;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Core\Entities\User;
use Modules\Core\Entities\EmailAlert;

class LogSentMessage
{

    public function __construct()
    {
        //
    }


    public function handle($message)
    {

        $to = $message->message->getTo();

        if($to)
        {
            $email['to'] = json_encode($to);
            reset($to);
            $to_email = key($to);
            $user = User::findByEmail($to_email);
            if($user)
            {
                $email['core_user_id'] = $user->id;
            }
        }

        $email['from'] = json_encode($message->message->getFrom());
        $email['subject'] = $message->message->getSubject();
        $email['message'] = $message->message->getBody();
        $email['status'] = 'sent';
        $email['sent_at'] = \Carbon::now();

        EmailAlert::create($email);
        Log::info('MESSAGE ID: ' . $message->message->getId());
    }
}
