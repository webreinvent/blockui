<?php
namespace  Modules\Core\Libraries;

class CoreImapHelper
{

    public $hostname;
    public $email;
    public $password;
    public $upload_path;
    //-----------------------------------------------------
    function __construct($hostname, $email, $password, $upload_path="files/")
    {
        $this->hostname = $hostname;
        $this->email = $email;
        $this->password = $password;
        $this->upload_path = $upload_path;
    }
    //-----------------------------------------------------
    public function isConnected()
    {
        $connect = @imap_open($this->hostname, $this->email, $this->password);
        if(!$connect)
        {
            $response['status'] = "failed";
            $response['errors'][] = "Error opening mailbox: ".imap_last_error();
        } else
        {
            $response['status'] = "success";
            $response['messages'][] = "Successfully connect to imap host: ".$this->hostname;
            imap_close($connect);
        }

        return $response;
    }
    //-----------------------------------------------------
    public function moveSpamEmailsToInbox()
    {
        if (strpos($this->hostname,'imap.gmail.com') !== false)
        {
            //$spam = @imap_open('{imap.gmail.com:993/ssl}[Gmail]/Spam',$username, $password);
            $spam = @imap_open('{imap.gmail.com:993/imap/ssl/novalidate-cert}[Gmail]/Spam', $this->email, $this->password);
        } else if (strpos($this->hostname,':143/notls}') !== false)
        {
            $spam_box = str_replace("INBOX", 'Spam', $this->hostname);
            $spam = @imap_open($spam_box, $this->email, $this->password);
        }

        $msg_spam =@imap_search($spam, 'UNSEEN', SE_UID);
        if(!empty($msg_spam))
        {
            //Move spam mails to inbox
            foreach($msg_spam as $email_number):

                if (@imap_mail_move($spam, $email_number, 'Inbox', CP_UID))
                {
                } else {
                }

                imap_expunge($spam);

            endforeach;
        }

    }
    //-----------------------------------------------------
    public function fetchMails($last_sync=null)
    {

        $mailbox = new \PhpImap\Mailbox($this->hostname, $this->email,
                                        $this->password, $this->upload_path);

        if(!$last_sync)
        {
            $sync_from = date('d F Y');
            //$sync_from = Date::dateformat($date, false, "d F Y") ;
        } else
        {
            $sync_from = \Carbon::parse($last_sync)->format("d F Y") ;
        }

        //$unread = $mailbox->searchMailBox('UNSEEN', SE_UID);
        $lastSync = $mailbox->searchMailBox('SINCE "'.$sync_from.'"', SE_UID);
        //$mailUIDs = array_merge($unread, $lastSync);
        //$mailUIDs = array_unique($mailUIDs);
        $mailUIDs = array_unique($lastSync);

        if(count($mailUIDs) < 1)
        {
            $response['status'] = 'failed';
            $response['messages'][]= 'No email found';
            return $response;
        }

        $result = [];
        $i = 0;
        foreach ($mailUIDs as $uid)
        {
            $result[$i]['uid'] = $uid;
            $result[$i]['mail'] = $mailbox->getMail($uid);

            if(isset($result[$i]['mail']->headers->from)) {
                $result[$i]['from'] = $this->mailboxToContacts($result[$i]['mail']->headers->from, 'from');
            }
            if(isset($result[$i]['mail']->headers->to)) {
                $result[$i]['to'] = $this->mailboxToContacts($result[$i]['mail']->headers->to, 'to');
            }
            if(isset($result[$i]['mail']->headers->cc)) {
                $result[$i]['cc'] = $this->mailboxToContacts($result[$i]['mail']->headers->cc, 'cc');
            }

            if(!isset($result[$i]['mail']->subject) || $result[$i]['mail']->subject == "")
            {
                $result[$i]['mail']->subject = "Subject was not define, change the subject.";
            }

            $result[$i]['mail']->subject = \Purify::clean($result[$i]['mail']->subject);

            $message = $this->parseMessage($result[$i]['mail']->textHtml);

            $result[$i]['mail']->textHtml = \Purify::clean($message);
            $result[$i]['mail']->textPlain = \Purify::clean($result[$i]['mail']->textPlain);



            $i++;
        }

        $response['status'] = 'success';
        $response['data']= $result;
        return $response;

    }
    //-----------------------------------------------------
    public function mailboxToContacts($arr, $type)
    {

        if(count($arr) < 1 || empty($arr))
        {
            return array();
        }

        $i = 0;
        $result = array();
        foreach ($arr as $item)
        {

            if(!isset($item->host) || $item->mailbox == 'undisclosed-recipients')
            {
                continue;
            }

            $result[$i]['type'] = $type;
            if(isset($item->personal) && $item->personal != "")
            {
                $result[$i]['name'] = $item->personal;
            }
            $result[$i]['email'] = $item->mailbox."@".$item->host;

            $i++;
        }

        return $result;
    }
    //-----------------------------------------------------
    public function parseMessage($message)
    {

        $message = explode("---Please Reply Above This Line---", $message);
        $message = $message[0];
        $message = str_replace('<p style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding-left:24px;padding-right:24px">', '', $message);

        $message = str_replace('<div style="margin:0;padding:0" bgcolor="#F0F0F0" marginwidth="0" marginheight="0">', '', $message);

        //only for gmail
        if( strpos( $message, '<div class="gmail_quote">' ) !== false )
        {
            $message = explode('<div class="gmail_quote">', $message);
            $message = $message[0];
        }

        return $message;

    }
    //-----------------------------------------------------
    public static function parseID($subject, $start, $end)
    {


        if (strpos($subject, $start) !== false) {
            $identifier = Extractor::extract_unit($subject, $start, $end);
            return $identifier;
        } else
        {
            return false;
        }

    }
    //-----------------------------------------------------

}//end of class