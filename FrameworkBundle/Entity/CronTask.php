<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Trinity\FrameworkBundle\Entity\CronTaskRepository")
 */
class CronTask
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string Command Cron Task
     * @ORM\Column(type="string")
     */
    private $command;

    /**
     * @var \DateTime Creation time of Cron Task
     * @ORM\Column(type="datetime")
     */
    private $creationTime;

    /**
     * @var \DateTime Processing time of Cron Task
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $processingTime;

    /**
     * @var int Priority of Cron task
     * @ORM\Column(type="integer",name = "priority")
     */
    private $priority = 0;


    /**
     * @return mixed
     */
    public function getProcessingTime ()
    {
        return $this->processingTime;
    }


    /**
     * @param mixed $processingTime
     */
    public function setProcessingTime ($processingTime)
    {
        $this->processingTime = $processingTime;
    }


    public function getId ()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getCommand ()
    {
        return $this->command;
    }


    /**
     * @param mixed $Command
     */
    public function setCommand ($command)
    {
        $this->command = $command;
    }


    /**
     * @return mixed
     */
    public function getCreationTime ()
    {
        return $this->creationTime;
    }


    /**
     * @param mixed $creationTime
     */
    public function setCreationTime ($creationTime)
    {
        $this->creationTime = $creationTime;
    }


    /**
     * @return int
     */
    public function getPriority ()
    {
        return $this->priority;
    }


    /**
     * @param int $priority
     */
    public function setPriority ($priority)
    {
        $this->priority = $priority;
    }
}
