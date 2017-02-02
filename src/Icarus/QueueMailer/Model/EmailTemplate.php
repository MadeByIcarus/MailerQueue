<?php
/**
 * Created by PhpStorm.
 * User: pavelgajdos
 * Date: 31.01.17
 * Time: 8:56
 */

namespace Icarus\QueueMailer\Model;


use Doctrine\ORM\Mapping as ORM;
use Icarus\Doctrine\Entities\Attributes\Identifier;


/**
 * @ORM\Entity
 */
class EmailTemplate
{

    use Identifier;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $language;

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
    private $from;





    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }



    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }



    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }
}