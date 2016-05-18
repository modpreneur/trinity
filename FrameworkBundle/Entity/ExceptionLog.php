<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Class ExceptionLog
 * @package Trinity\FrameworkBundle\Entity
 */


class ExceptionLog implements ElasticSearchEntityInterface
{
    /**
     * @var string
     *
     */
    private $id;

    /**
     * @var string
     * Analyzed by elasticSearch
     */
    private $log;

    /**
     * @var string
     * Analyzed by elasticSearch
     */
    private $readable;

    /**
     * @var string
     * Analyzed by elasticSearch
     */
    private $serverData;

    /**
     * @var int
     * This is MONOLOG exception level, not http response!
     */
    private $level;

    /**
     * @var int timestamp
     */
    private $createdAt;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $ip;


    /**
     * ExceptionLog constructor.
     * @param string $id
     */
    public function __construct($id = '')
    {
        $this->id = $id;
    }


    /**
     * Get id.
     *
     * @return string
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
     * @todo @GabrielBordovsky what is BaseSystemLog?
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
     * @todo @GabrielBordovsky what is BaseSystemLog?
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
     * @todo @GabrielBordovsky what is BaseSystemLog?
     * @return BaseSystemLog
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }


    /**
     * Get createdAt.
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /**
     * Set createdAt timestamp.
     *
     * @param int $createdAt
     *
     * @todo @GabrielBordovsky what is BaseSystemLog?
     * @return BaseSystemLog
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

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
     * @var BaseUser
     */
    private $user;

    /**
     * @return BaseUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param BaseUser $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->id;
    }
}
