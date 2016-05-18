<?php

namespace Trinity\FrameworkBundle\Traits;

use JMS\Serializer\Annotation\PreSerialize;

/**
 * Exclude updatedBy and CreatedBy before serialization due to secure reason
 *
 * Class ExcludeBlameableTrait
 * @package Necktie\AppBundle\Traits
 */
trait ExcludeBlameableTrait
{
    /**
     * @PreSerialize
     */
    public function preSerialize()
    {
        $this->setUpdatedBy(null);
        $this->setCreatedBy(null);
    }
}
