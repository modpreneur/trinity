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
    private $Id;

    /**
     * @var string Command Cron Task
     * @ORM\Column(type="array")
     */
    private $Command;

    /**
     * @var \DateTime Creation time of Cron Task
     * @ORM\Column(type="datetime")
     */
    private $CreationTime;

    /**
     * @var \DateTime Processing time of Cron Task
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $ProcessingTime;

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
        return $this->ProcessingTime;
    }


    /**
     * @param mixed $ProcessingTime
     */
    public function setProcessingTime ($ProcessingTime)
    {
        $this->ProcessingTime = $ProcessingTime;
    }


    public function getId ()
    {
        return $this->Id;
    }


    /**
     * @return mixed
     */
    public function getCommand ()
    {
        return $this->Command;
    }


    /**
     * @param mixed $Command
     */
    public function setCommand ($Command)
    {
        $this->Command = $Command;
    }


    /**
     *
     * @param string $command Parse the Input string (from form) into an array needed for run in console.
     */
    public function setCommandWithParse ($command)
    {
        $array = preg_split('/ /', $command);

        if (count($array) === 1) {
            $this->Command = array(
                'command' => $array[0]);
        } else {
            $arrayKeys[] = 'command';
            $arrayValues[] = $array[0];
            for ($i = 1; $i < count($array); $i++) {
                if ((substr($array[$i], 0, 1) === "-") || (substr($array[$i], 0, 2) === "--")) {
                    $arrayKeys[] = $array[$i];
                    if ((substr($array[$i + 1], 0, 1) === "-") || (substr($array[$i + 1], 0, 2) === "--")) {
                        $arrayValues[] = null;
                    }
                } else {
                    $arrayValues[] = $array[$i];
                }
            }
            $this->Command = array_combine($arrayKeys, $arrayValues);
        }
    }


    /**
     * @return mixed
     */
    public function getCreationTime ()
    {
        return $this->CreationTime;
    }


    /**
     * @param mixed $CreationTime
     */
    public function setCreationTime ($CreationTime)
    {
        $this->CreationTime = $CreationTime;
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
