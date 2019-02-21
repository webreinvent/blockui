<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Events\InformErrorAdmin;
use Modules\Core\Libraries\CoreOneSignal;
use Modules\Core\Libraries\Extractor;
use Modules\Core\Notifications\SendEmailNotifications;

class Notifications extends Model
{
    //-------------------------------------------------
    protected $table = 'core_notifications';
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at', 'sent_at', 'read_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------

    protected $fillable = [
        'type', 'label', 'core_user_id', 'title', 'details',
        'table_name', 'table_id',
        'link', 'meta', 'sent_at', 'read_at',
    ];

    //-------------------------------------------------
    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = $value;
    }
    //-------------------------------------------------
    public function getMetaAttribute($value) {
        $json = json_decode($value);
        return $json;
    }
    //-------------------------------------------------
    public function scopeCreatedBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', array($from, $to));
    }
    //-------------------------------------------------
    public function scopeUpdatedBetween($query, $from, $to)
    {
        return $query->whereBetween('updated_at', array($from, $to));
    }
    //-------------------------------------------------
    public function send()
    {
        //store in database

        //attempt to deliver the email else mark status to queued

    }
    //-------------------------------------------------
    //$meta = json_encode(array('user_ids'=>$user_ids));
    public static function setNotification($type, $title, $details, $table_name, $table_id, $meta = null)
    {
        $noti = new Notifications();
        $noti->type = $type;
        $noti->title = $title;
        $noti->details = $details;
        $noti->table_name = $table_name;
        $noti->table_id = $table_id;
        if($meta)
        {
            $noti->meta = $meta;
        }

        if(\Auth::user())
        {
            $noti->core_user_id = \Auth::user()->id;
        }
        $noti->save();
    }
    //-------------------------------------------------
    public static function setQuickNotification($type, $title, $details, $table_name, $table_id, $meta = null)
    {
        $noti = new Notifications();
        $noti->type = $type;
        $noti->title = $title;
        $noti->details = Notifications::splitString($details);
        $noti->table_name = $table_name;
        $noti->table_id = $table_id;
        if($meta)
        {
            $noti->meta = $meta;
        }

        if(\Auth::user())
        {
            $noti->core_user_id = \Auth::user()->id;
        }
        $noti->save();
    }
    //-------------------------------------------------
    public static function splitString($str)
    {
        $result = strip_tags($str);
        if(strlen($str) > 100)
        {
            $result = substr($str, 0, 100)."...";
        }

        return $result;
    }
    //-------------------------------------------------
    public static function setOneSignalPushNotifications($title, $message, $link, $user_ids, $table_name, $table_id)
    {

        $noti = new Notifications();
        $noti->type = 'push_onesignal';
        $noti->title = $title;
        $noti->details = Notifications::splitString(trim(strip_tags($message)));
        $noti->link = $link;
        $noti->meta = json_encode(array('user_ids'=>$user_ids));
        $noti->table_name = $table_name;
        $noti->table_id = $table_id;
        if(\Auth::user())
        {
            $noti->core_user_id = \Auth::user()->id;
        }


        $noti->save();

    }
    //-------------------------------------------------
    public static function sendEmailNotifications()
    {
        $list = Notifications::whereNull('sent_at')
            ->where('type', 'email')
            ->get();


        foreach ($list as $item)
        {


            $send_to = [];

            if(isset($item->meta) && isset($item->meta->user_ids)
                && (is_array($item->meta->user_ids) || $item->meta->user_ids instanceof Countable))
            {
                if( count($item->meta->user_ids) > 0)
                {

                    foreach ($item->meta->user_ids as $id)
                    {
                        $user = User::find($id);
                        try{
                            Notification::send($user, new SendEmailNotifications($item));
                        }catch(\Swift_TransportException $e)
                        {
                            $event['type'] = "smtp";
                            $event['label'] = "smtp failure";
                            $event['details'] = "Mail delivery failed via smtp during syncing with care";
                            $event['error'] = $e->getMessage();
                            event(new InformErrorAdmin($event));
                        }
                    }
                }
            }


            $item->sent_at = \Carbon::now();
            $item->save();
        }

    }
    //-------------------------------------------------
    public static function sendOneSignalPushNotifications()
    {
        $list = Notifications::whereNull('sent_at')
            ->where('type', 'push_onesignal')
            ->get();

        if(!$list)
        {
            $response['status'] = 'failed';
            $response['errors'][]= "No notification to send";
            return $response;
        }

        $result = [];



        foreach ($list as $item)
        {

            $send_to = [];

            if(is_array($item->meta->user_ids) || $item->meta->user_ids instanceof Countable)
            {
                if(count($item->meta->user_ids) > 0)
                {
                    foreach ($item->meta->user_ids as $id)
                    {

                        if($id != $item->core_user_id)
                        {
                            $send_to[] = $id;
                        }
                    }
                }
            }


            $result[] = $item->title." SENT TO --> ".json_encode($send_to);


            CoreOneSignal::sendNotificationUsers($send_to, $item->title, strip_tags($item->details), $item->link);
            $item->sent_at = \Carbon::now();
            $item->save();

        }

        $response['status'] = 'success';
        $response['data'] = $result;
        return $response;

    }
    //-------------------------------------------------
    public static function sendPushNotificationToUser($title, $message, $link, $user_id, $table_name, $table_id)
    {
        Notifications::setOneSignalPushNotifications($title, $message, $link, [$user_id], $table_name, $table_id);
    }
    //-------------------------------------------------
    public static function sendPushNotificationToUsers($title, $message, $link, $user_ids, $table_name, $table_id)
    {
        Notifications::setOneSignalPushNotifications($title, $message, $link, $user_ids, $table_name, $table_id);
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
