<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Event;

use Symfony\Component\EventDispatcher\Event;



/**
 * Class StatusBundleEvent.
 */
class StatusBundleEvent extends Event
{
    /** @var  string */
    protected $state;

    /** @var  string */
    protected $name;



    public function __construct($state, $name)
    {
        $this->state = $state;
        $this->name = $name;
    }



    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }



    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
