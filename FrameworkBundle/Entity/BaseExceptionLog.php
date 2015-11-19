<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class BaseExceptionLog
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $log;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $serverData;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $level;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $ip;



    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue ()
    {
        $this->created = new \DateTime();
    }



    /**
     * Get id.
     *
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }



    /**
     * Set log.
     *
     * @param string $log
     *
     * @return BaseSystemLog
     */
    public function setLog ($log)
    {
        $this->log = $log;

        return $this;
    }



    /**
     * Get log.
     *
     * @return string
     */
    public function getLog ()
    {
        return $this->log;
    }



    /**
     * Set serverData.
     *
     * @param string $serverData
     *
     * @return BaseSystemLog
     */
    public function setServerData ($serverData)
    {
        $this->serverData = $serverData;

        return $this;
    }



    /**
     * Get serverData.
     *
     * @return string
     */
    public function getServerData ()
    {
        return $this->serverData;
    }



    /**
     * Set level.
     *
     * @param string $level
     *
     * @return BaseSystemLog
     */
    public function setLevel ($level)
    {
        $this->level = $level;

        return $this;
    }



    /**
     * Get level.
     *
     * @return string
     */
    public function getLevel ()
    {
        return $this->level;
    }



    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return BaseSystemLog
     */
    public function setCreated ($created)
    {
        $this->created = $created;

        return $this;
    }



    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated ()
    {
        return $this->created;
    }



    /**
     * @return mixed
     */
    public function getUrl ()
    {
        return $this->url;
    }



    /**
     * @param mixed $url
     */
    public function setUrl ($url)
    {
        $this->url = $url;
    }



    /**
     * @return mixed
     */
    public function getIp ()
    {
        return $this->ip;
    }



    /**
     * @param mixed $ip
     */
    public function setIp ($ip)
    {
        $this->ip = $ip;
    }
}
