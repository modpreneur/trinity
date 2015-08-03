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
    private $sess_id;

    /**
     * @ORM\Column(type="binary")
     */
    private $sess_data;

    /**
     * @ORM\Column(type="integer")
     */
    private $sess_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $sess_lifetime;
}
