<?php

// BONUS - MAIL SCORE
// swift mailer : https://swiftmailer.symfony.com/docs/introduction.html

namespace App\Utils;


use \Swift_Mailer;
use \Swift_SmtpTransport;
use \Swift_Message;

class Mailer {

    private $mailer;

    private $subject;

    private $to;

    private $body;

    public function __construct()
    {
        // helper env() : permet de recuperer la valeur des constantes définies dans .env
        $smtp = env('MAILER_SMTP');
        $port = env('MAILER_PORT');
        $encryption = env('MAILER_ENCRYPTION');
        $username = env('MAILER_USERNAME');
        $password = env('MAILER_PASSWORD');


        // Create the Transport
        $transport = new Swift_SmtpTransport($smtp, $port);

        $transport->setUsername($username);//commenter aux besoin du smtp
        $transport->setPassword($password);//commenter aux besoin du smtp
        $transport->setEncryption($encryption);//commenter aux besoin du smtp

        // Create the Mailer using your created Transport
        $this->mailer = new Swift_Mailer($transport);

    }

    public function sendMail() {

        // Create a message
        $message = new Swift_Message($this->subject);

        $message->setFrom([env('APP_ADMIN_MAIL')]);
        $message->setTo([$this->to]);
        $message->setBody($this->body);

        // Send the message
        $result = $this->mailer->send($message, $failures);

        if ($result){

            echo 'Message successfully sent!';

        } else {

            echo "There was an error:\n";

            //dump($message);
            //dump($failures);
        }

        return $result;
    }

    /**
     * Get the value of subject
     */ 
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */ 
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of from
     */ 
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set the value of from
     *
     * @return  self
     */ 
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get the value of to
     */ 
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the value of to
     *
     * @return  self
     */ 
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Get the value of body
     */ 
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */ 
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}

?>