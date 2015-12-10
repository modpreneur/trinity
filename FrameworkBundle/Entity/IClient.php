<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface IClient.
 */
interface IClient
{
    /** @return string */
    public function getNotificationUri();
}
