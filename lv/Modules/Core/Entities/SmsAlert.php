<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Curl;

class SmsAlert extends Model
{
    //-------------------------------------------------
    protected $table = 'core_sms_alerts';
    //-------------------------------------------------
    //-------------------------------------------------
    protected $dates = [
        'created_at', 'updated_at'
    ];
    //-------------------------------------------------
    protected $dateFormat = 'Y-m-d H:i:s';
    //-------------------------------------------------
    protected $fillable = [
        'type', 'label', 'core_user_id', 'to',
        'message', 'meta',
    ];
    //-------------------------------------------------
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
    //-------------------------------------------------
    //$user_id, $to, $message, $type=NULL, $label=NULL, $meta
    public static function send($to, $message, $type = NULL, $label = NULL, $meta = NULL)
    {
        try {
            //store in database
            $sms = new SmsAlert();
            $user = User::findByMobile($to);
            if ($user) {
                $sms->core_user_id = $user->id;
            }
            $sms->to = $to;
            $sms->message = $message;
            $sms->type = $type;
            $sms->label = $label;
            $sms->meta = $meta;
            $sms->save();
            $response = SmsAlert::deliver($sms->id);
        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();
        }
        return $response;
    }

    //-------------------------------------------------
    public static function deliver($id)
    {
        try {
            $username = env('SMS_TEXTLOCAL_USERNAME');
            $hash = env('SMS_TEXTLOCAL_HASH');
            $sms = SmsAlert::findOrFail($id);
            $test = "0";
            //$sender = "PHRCHR";
            $sender = "TXTLCL";
            $data = array(
                'username' => $username,
                'hash' => $hash,
                'message' => urlencode($sms->message),
                'sender' => $sender,
                'numbers' => $sms->to,
                'test' => $test,
            );
            $textloca = Curl::to('http://api.textlocal.in/send')
                ->withData($data)
                ->post();
            $textloca = json_decode($textloca);
            if ( isset($textloca->status) && $textloca->status == "success") {
                $sms->status = 'sent';
                $sms->sent_at = \Carbon::now();
                $sms->save();


                $response['status'] = 'success';
                $response['data'] = $sms;


            } else{
                $response['status'] = 'error';
                $response['data'] = $textloca;

            }

        } catch (Exception $e) {
            $response['status'] = 'failed';
            $response['errors'][] = $e->getMessage();

        }

        return $response;
    }
    //-------------------------------------------------
    //-------------------------------------------------
    //-------------------------------------------------
}
