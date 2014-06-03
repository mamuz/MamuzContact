<?php

namespace MamuzContact\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @ORM\Table(name="MamuzContact")
 * @Annotation\Name("contact")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Exclude()
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"EmailAddress"})
     * @Annotation\Options({"label":"From"})
     * @Annotation\Attributes({"required":"required", "type":"email", "placeholder":"Enter your email"})
     * @Annotation\Required()
     * @var string
     */
    private $fromEmail;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Filter({"name":"StripNewlines"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"3", "max":"255"}})
     * @Annotation\Options({"label":"Subject"})
     * @Annotation\Attributes({"required":"required", "placeholder":"Enter subject"})
     * @Annotation\Required()
     * @var string
     */
    private $subject;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"3", "max":"65535"}})
     * @Annotation\Options({"label":"Message"})
     * @Annotation\Attributes({"required":"required", "placeholder":"Enter message"})
     * @Annotation\Required()
     * @var string
     */
    private $message;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Annotation\Exclude()
     * @var bool
     */
    private $replied = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var \DateTime
     */
    private $createdAt;

    /**
     * init datetime object
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * destroy identity and init datetime object
     */
    public function __clone()
    {
        $this->id = null;
        $this->init();
    }

    /**
     * set createdAt to now
     */
    private function init()
    {
        $this->createdAt = new \DateTime;
    }

    /**
     * @param \DateTime $createdAt
     * @return Contact
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param string $fromEmail
     * @return Contact
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param int $id
     * @return Contact
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $message
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param boolean $replied
     * @return Contact
     */
    public function setReplied($replied)
    {
        $this->replied = $replied;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isReplied()
    {
        return $this->replied;
    }

    /**
     * @param string $subject
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'From'    => $this->getFromEmail(),
            'Subject' => $this->getSubject(),
            'Message' => $this->getMessage(),
        );
    }
}
