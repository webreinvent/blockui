<?php

namespace Modules\Core\NotificationChannels\TextLocalSMS;

use Illuminate\Support\Arr;

class TextLocalSMSMessage
{
    public $to;
    public $message;
    public $sender_id = "PHRCHR";
    public $username;
    public $hash;


    public function __construct($sender_id=null)
    {

        if(!$sender_id)
        {
            $this->sender_id = $sender_id;
        }

        $this->username = env('SMS_TEXTLOCAL_USERNAME');
        $this->hash = env('SMS_TEXTLOCAL_HASH');

    }
    //-------------------------------------------------------------------
    public function to($to)
    {
        $this->to = $to;
        return $this;
    }
    //-------------------------------------------------------------------
    public function message($message)
    {
        $this->message = $message;


        return $this;
    }
    //-------------------------------------------------------------------
    public function sender_id($sender_id)
    {
        $this->sender_id = $sender_id;
        return $this;
    }
    //-------------------------------------------------------------------
    public function username($sender_id)
    {
        $this->sender_id = $sender_id;
        return $this;
    }
    //-------------------------------------------------------------------
    public function hash($sender_id)
    {
        $this->sender_id = $sender_id;
        return $this;
    }
    //-------------------------------------------------------------------
    public function toArray()
    {
        return [
            'to' => $this->to,
            'message' => $this->message,
            'sender_id' => $this->sender_id,
        ];
    }
    //-------------------------------------------------------------------
    //-------------------------------------------------------------------

}
