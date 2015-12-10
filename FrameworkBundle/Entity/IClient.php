<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface IClient
 * @package Trinity\FrameworkBundle\Entity
 */
interface IClient
{
    /** @return string */
    public function getNotificationUri();

    /** @return  boolean */
    public function isNotificationEnabled();

    /** @return string */
    public function getSecret();
}
