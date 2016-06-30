<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Trinity\Component\Core\Interfaces\EntityInterface;

/**
 * @ORM\Table(name="cron_task")
 * @ORM\Entity(repositoryClass="Trinity\FrameworkBundle\Entity\CronTaskRepository")
 */
class CronTask implements EntityInterface
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
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;


    /**
     * @return mixed
     */
    public function getProcessingTime()
    {
        return $this->processingTime;
    }


    /**
     * @param mixed $processingTime
     */
    public function setProcessingTime($processingTime)
    {
        $this->processingTime = $processingTime;
    }


    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->command;
    }


    /**
     * @param mixed $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }


    /**
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }


    /**
     * @param \DateTime $creationTime
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;
    }


    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }


    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }


    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->command;
    }
}
