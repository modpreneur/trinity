<?php
/**
 * Created by PhpStorm.
 * User: IVO
 * Date: 3.8.2015
 * Time: 14:49
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Trinity\FrameworkBundle\Entity\CronTaskRepository")
 */
class CronTask  {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $Id;

    /**
     * @ORM\Column(type="array")
     */
    private $Command;


    /**
     * @ORM\Column(type="datetime")
     */
    private $CreationTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ProcessingTime;

    /**
     * @return mixed
     */
    public function getProcessingTime()
    {
        return $this->ProcessingTime;
    }

    /**
     * @param mixed $ProcessingTime
     */
    public function setProcessingTime($ProcessingTime)
    {
        $this->ProcessingTime = $ProcessingTime;
    }


    public function getId()
    {
        return $this->Id;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        return $this->Command;
    }

    /**
     * @param mixed $Command
     */
    public function setCommand($Command)
    {
        $this->Command = $Command;
    }
    /**
     * @return mixed
     */
    public function getCreationTime()
    {
        return $this->CreationTime;
    }

    /**
     * @param mixed $CreationTime
     */
    public function setCreationTime($CreationTime)
    {
        $this->CreationTime = $CreationTime;
    }


}