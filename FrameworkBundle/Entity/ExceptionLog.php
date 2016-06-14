<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Trinity\Bundle\LoggerBundle\Entity\BaseElasticLog;

/**
 * Class ExceptionLog
 * @package Trinity\FrameworkBundle\Entity
 */
class ExceptionLog extends BaseElasticLog implements EntityInterface
{

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
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $ip;

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
     * @return ExceptionLog
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }


    /**
     * @return string
     */
    public function getReadable()
    {
        return $this->readable;
    }


    /**
     * @param string $readable
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
     * @return ExceptionLog
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
     * @return ExceptionLog
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }


    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }


    /**
     * @param string $ip
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
    public function __toString() : string
    {
        return (string)$this->id;
    }
}
