<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface ClientInterface
 * @package Trinity\FrameworkBundle\Entity
 */
interface ClientInterface
{
    /** @return string */
    public function getNotificationUri();


    /** @return  boolean */
    public function isNotificationEnabled();


    /** @return string */
    public function getSecret();
}
