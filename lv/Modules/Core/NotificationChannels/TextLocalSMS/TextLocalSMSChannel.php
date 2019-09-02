<?php

namespace Modules\Core\NotificationChannels\TextLocalSMS;

use Modules\Core\Entities\User;
use Illuminate\Notifications\Notification;

class TextLocalSMSChannel
{

    public function __construct()
    {

    }


    public function send($notifiable, Notification $notification)
    {

        $sms_data = $notification->toTextLocalSMS($notifiable);

        $data = array(
            'username' => $sms_data->username,
            'hash' => $sms_data->hash,
            'message' => urlencode($sms_data->message),
            'sender' => $sms_data->sender_id,
            'numbers' => $sms_data->to
        );
        $textloca = \Curl::to('http://api.textlocal.in/send')
            ->withData($data)
            ->post();

        $textloca = json_decode($textloca);


        if ( isset($textloca->status) && $textloca->status == "success")
        {
            $response['status'] = 'success';
        } else{
            $response['status'] = 'failed';
            $response['data'] = $textloca;
            $response['location'] = "TextLocalSMSChannel.php -> send -> API Call is failed";
            User::notifyAdmins("SMS Delivery Failed", json_encode($response));
        }

    }
}
