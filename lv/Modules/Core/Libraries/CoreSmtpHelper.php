<?php
namespace  Modules\Core\Libraries;
use Modules\Core\Entities\User;
use \Swift_Mailer;
use Swift_Message;
use \Swift_SmtpTransport as SmtpTransport;
use Swift_SmtpTransport;

class CoreSmtpHelper
{

    public $hostname;
    public $username;
    public $password;
    public $port;
    public $encryption;

    //-----------------------------------------------------
    function __construct($hostname, $username, $password, $port, $encryption = "")
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
        $this->encryption = $encryption;
    }
    //-----------------------------------------------------
    public function sendTestEmails($to)
    {
        try{

            /*$transport = SmtpTransport::newInstance($this->hostname, $this->port, $this->encryption)
                ->setUsername($this->username)
                ->setPassword($this->password);*/


            $transport = (new Swift_SmtpTransport($this->hostname, $this->port, $this->encryption))
                ->setUsername($this->username)
                ->setPassword($this->password)
            ;


            //$mailer = Swift_Mailer::newInstance($transport);
            $mailer = new Swift_Mailer($transport);

            $message = "
            Following SMTP Details Seems working:<br/>
            ----------------------------------------<br/>
            Hostname: ".$this->hostname." <br/>
            Username: ".$this->username." <br/><br/>
            
            Sent from CoreSmtpHelper Library.
            ";


            $message = (new Swift_Message('SMTP Test Emails'))
                ->setFrom(array('noreply@webreinvent.com' => 'WebReinvent - Core'))
                ->setTo(array($to))
                ->setBody($message, 'text/html');

            $result = $mailer->send($message);
            $response['status'] = 'success';
            $response['messages'][]= 'Email has been sent';

        } catch(\Swift_TransportException $e)
        {

            $error = $e->getMessage();
            if (strpos($error, 'Connection refused') !== false) {
                $response['errors'][] = "Make sure port ".$this->port." is open on your server";
            }

            $response['status'] = 'failed';
            $response['errors'][]= $e->getMessage();

            $current_page = url()->full();
            $message = $error.'<hr/>'.$current_page;

            //User::notifyAdmins("Error STMP on ".$current_page, $message);

        }

        return $response;
    }
    //-----------------------------------------------------
    /*
     * $from = array('email@email.com' => 'from name');
     * $to_array = array('receiver@domain.org', 'other@domain.org' => 'A name');
     */
    public function send($from, $to_array, $subject, $message, $attachments=null, $cc_array=null, $bcc_array=null )
    {
        try{

            /*$transport = SmtpTransport::newInstance($this->hostname, $this->port, $this->encryption)
                ->setUsername($this->username)
                ->setPassword($this->password);*/

            $transport = (new Swift_SmtpTransport($this->hostname, $this->port, $this->encryption))
                ->setUsername($this->username)
                ->setPassword($this->password)
            ;


            //$mailer = Swift_Mailer::newInstance($transport);

            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message($subject))
                ->setFrom($from)
                ->setTo($to_array)
                //->setBcc(['webreinvent@gmail.com'])
                ->setReturnPath('bounce@mustopen.com')
                ->setBody($message, 'text/html');

            if(!is_array($attachments))
            {
                $attachments = (array)$attachments;
            }


            if(count($attachments) > 1)
            {


                foreach ($attachments as $attachment)
                {
                    $message->attach(
                        \Swift_Attachment::fromPath($attachment)->setDisposition('inline')
                    );
                }
            }

            $result = $mailer->send($message);
            $response['status'] = 'success';
            $response['messages'][]= 'Email has been sent';

        } catch(\Swift_TransportException $e)
        {

            $error = $e->getMessage();
            if (strpos($error, 'Connection refused') !== false) {
                $response['errors'][] = "Make sure port ".$this->port." is open on your server";
            }

            $response['status'] = 'failed';
            $response['errors'][]= $e->getMessage();

            $current_page = url()->full();
            $message = $error.'<hr/>'.$current_page;

            //User::notifyAdmins("Error STMP on ".$current_page, $message);

        }

        return $response;



    }
    //-----------------------------------------------------
    //-----------------------------------------------------
    //-----------------------------------------------------
    //-----------------------------------------------------
    //-----------------------------------------------------

}//end of class
