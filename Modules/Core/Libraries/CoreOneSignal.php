<?php
namespace  Modules\Core\Libraries;

use Modules\Core\Entities\Notifications;

class CoreOneSignal {

    //------------------------------------------------\

    //------------------------------------------------
    function __construct() {

    }
    //------------------------------------------------
    public static function sendNotificationUsers($user_ids, $heading, $message, $url)
    {

        if($message == "")
        {
            return false;
        }

        $input_arr = [
            'user_ids' => $user_ids,
            'heading' => $heading,
            'message' => $message,
            'url' => $url,
        ];

        if($user_ids)
        {
            $i = 0;
            foreach ($user_ids as $id)
            {
                $condition = [array("key" => env('APP_SHORT_NAME')."-user-id",
                    "relation" => "=", "value" => $id)];

                $data = array(
                    "user_id" => $id
                );

                $input_arr['condition'] = $condition;
                $input_arr['data'] = $data;

                /*echo "<pre>";
                print_r($input_arr);
                echo "</pre>";*/

                $response = \OneSignal::sendNotificationUsingTags($heading, $message, $condition, $url, $data, $buttons=null, $schedule = null);

                $i++;
            }

        }

        return true;
    }
    //------------------------------------------------
    public static function sendNotificationUsingTag($inputs)
    {

        $rules = array(
            'tag_name' => 'required',
            'tag_value' => 'required',
            'message' => 'required',
            'url' => 'required',
        );

        $validator = \Validator::make( $inputs, $rules);
        if ( $validator->fails() ) {

            $errors             = errorsToArray($validator->errors());
            $response['status'] = 'failed';
            $response['errors'] = $errors;
            return $response;
        }

        $condition[] = array("key" => "team-user-id", "relation" => "!=", "value" => \Auth::user()->id);
        \OneSignal::sendNotificationUsingTags($inputs['message'], $condition, $inputs['url'], $data=null, $buttons=null, $schedule = null);
        $response['status'] = 'success';
        return $response;

    }
    //------------------------------------------------


    //------------------------------------------------

}// end of class
