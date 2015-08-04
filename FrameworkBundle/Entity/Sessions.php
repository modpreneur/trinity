<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Sessions.
 *
 * @ORM\Entity()
 * @ORM\Table(name="sessions")
 */
class Sessions
{
    /**
     * @var int
     *
     * @ORM\Column(type="string", nullable=false)
     * @ORM\Id
     */
    protected $sess_id;

    /**
     * @ORM\Column(type="binary")
     */
    protected $sess_data;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sess_time;

    /**
     * @ORM\Column(type="integer")
     */
    protected $sess_lifetime;

    /**
     * @return int
     */
    public function getSessId()
    {
        return $this->sess_id;
    }

    /**
     * @param int $sess_id
     */
    public function setSessId($sess_id)
    {
        $this->sess_id = $sess_id;
    }

    /**
     * @return mixed
     */
    public function getSessData()
    {
        return $this->sess_data;
    }

    /**
     * @param mixed $sess_data
     */
    public function setSessData($sess_data)
    {
        $this->sess_data = $sess_data;
    }

    /**
     * @return mixed
     */
    public function getSessTime()
    {
        return $this->sess_time;
    }

    /**
     * @param mixed $sess_time
     */
    public function setSessTime($sess_time)
    {
        $this->sess_time = $sess_time;
    }

    /**
     * @return mixed
     */
    public function getSessLifetime()
    {
        return $this->sess_lifetime;
    }

    /**
     * @param mixed $sess_lifetime
     */
    public function setSessLifetime($sess_lifetime)
    {
        $this->sess_lifetime = $sess_lifetime;
    }
}
