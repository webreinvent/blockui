<?php
namespace  Modules\Core\Libraries;

class CorePushCrew {

    //------------------------------------------------\
    public $base_url;
    public $api_token;
    //------------------------------------------------
    function __construct() {
        $this->api_token = env("PUSHCREW_API_KEY");

        if(!$this->api_token)
        {
            return false;
            die();
        }

        $this->base_url = "https://pushcrew.com/api/v1";
    }
    //------------------------------------------------
    public function addSegment($name)
    {
        $response = \Curl::to('https://pushcrew.com/api/v1/segments')
            ->withHeaders( array( 'Authorization: key='.$this->api_token ) )
            ->withData( array( 'name' => $name ) )
            ->asJson( true )
            ->post();
        return $response;
    }
    //------------------------------------------------
    public function addUserToSegment($name)
    {
        $response = \Curl::to('https://pushcrew.com/api/v1/segments')
            ->withHeaders( array( 'Authorization: key='.$this->api_token ) )
            ->withData( array( 'name' => $name ) )
            ->asJson( true )
            ->post();
        return $response;
    }
    //------------------------------------------------
    public function send($data_array)
    {
        $url = $this->base_url."/send/all";
        $response = \Curl::to($url)
            ->withHeaders(array("Authorization: $this->api_token"))
            ->withData( $data_array )
            ->returnResponseObject()
            ->post();

        return $response;
    }
    //------------------------------------------------
    public function sendToAll($title, $message, $url)
    {
        $response = $this->send(
            [
                'title'     => $title,
                'message'     => $message,
                'url'     => $url,
            ]);

        return $response;
    }

    //------------------------------------------------

}// end of class