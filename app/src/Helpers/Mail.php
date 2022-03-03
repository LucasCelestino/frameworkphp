<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{

    private $mail;
    
    private $subject;
    private $body;
    private $altBody;

    public function __construct(String $subject, String $body, String $altBody)
    {

        $this->subject = $subject;
        $this->body = $body;
        $this->altBody = $altBody;

        $this->email = new PHPMailer(true); 

        $this->setConfiguration();
    }

    private function setConfiguration()
    {
        $this->email->isSMTP();
        $this->email->SMTPAuth = true;

        $this->email->Username   = MAIL_USERNAME;
        $this->email->Password   = MAIL_PASSWORD;

        $this->email->SMTPSecure = MAIL_SMTPSECURE;

        $this->email->Host = MAIL_HOST;
        $this->email->Port = MAIL_PORT;
    }

    public function setFrom(String $senderEmail, String $senderName)
    {
        $this->email->setFrom($senderEmail, $senderName);
    }

    public function addAddress(String $receiverEmail, String $receiverName)
    {
        $this->email->addAddress($receiverEmail, $receiverName);
    }

    public function sender(bool $isHTML = true): bool
    {
        $this->email->isHTML($isHTML);

       if(!empty($this->subject) && !empty($this->body) && !empty($this->altBody))
       {
            $this->email->Subject = $this->subject;

            $this->email->Body    = $this->body;

            $this->email->AltBody = $this->altBody;
            
            if(!$this->email->sender())
            {
                return false;
            }
            
            return true;
       }
    }

}