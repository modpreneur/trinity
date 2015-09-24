<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface IEntityNotification.
 */
interface IEntityNotification
{
    /** @return int */
    public function getId ();



    /** @return IClient|IClient[] */
    public function getClients ();
}
