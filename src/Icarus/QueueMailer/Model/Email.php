<?php

namespace Icarus\QueueMailer\Model;


use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Mail\Message;


/**
 * @ORM\Entity
 */
class Email
{

    use Identifier;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sent;

    /**
     * @ORM\Column(type="string")
     */
    private $sender;

    /**
     * @ORM\Column(type="string")
     */
    private $recipient;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cc;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $bcc;

    /**
     * @ORM\Column(type="string")
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $error;



    /**
     * @return $this
     */
    public function setSentToNow()
    {
        $this->sent = new \DateTime();
        $this->error = null;
        return $this;
    }



    /**
     * @return Message
     */
    public function getMessage()
    {
        $message = new Message();

        $message->setFrom($this->sender);
        $message->addTo($this->recipient);

        if ($this->cc) {
            $message->addCc($this->cc);
        }

        if ($this->bcc) {
            $message->addBcc($this->bcc);
        }

        $message->setSubject($this->subject);
        $message->setHtmlBody($this->body);

        return $message;
    }



    /**
     * @param mixed $sender
     * @return Email
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
        return $this;
    }



    /**
     * @param mixed $recipient
     * @return Email
     */
    public function setTo($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }



    /**
     * @param mixed $cc
     * @return Email
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }



    /**
     * @param mixed $bcc
     * @return Email
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }



    /**
     * @param mixed $subject
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }



    /**
     * @param mixed $body
     * @return Email
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }



    /**
     * @param mixed $error
     * @return Email
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

}