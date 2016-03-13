<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;


/**
 * Class ExceptionLog
 * @package Trinity\FrameworkBundle\Entity
 */


class ExceptionLog
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $readable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $serverData;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ip;


    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }


    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get log.
     *
     * @return string
     */
    public function getLog()
    {
        return $this->log;
    }


    /**
     * Set log.
     *
     * @param string $log
     *
     * @return BaseSystemLog
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getReadable()
    {
        return $this->readable;
    }


    /**
     * @param mixed $readable
     */
    public function setReadable($readable)
    {
        $this->readable = $readable;
    }


    /**
     * Get serverData.
     *
     * @return string
     */
    public function getServerData()
    {
        return $this->serverData;
    }


    /**
     * Set serverData.
     *
     * @param string $serverData
     *
     * @return BaseSystemLog
     */
    public function setServerData($serverData)
    {
        $this->serverData = $serverData;

        return $this;
    }


    /**
     * Get level.
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }


    /**
     * Set level.
     *
     * @param string $level
     *
     * @return BaseSystemLog
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }


    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return BaseSystemLog
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }


    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @var User
     */
    private $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return (string)$this->id;
    }
}
