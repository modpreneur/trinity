<?php
/**
 * Created by PhpStorm.
 * User: ufambula
 * Date: 18.5.16
 * Time: 14:22
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface EntityInterface
 * @package Trinity\FrameworkBundle\Entity
 */
interface EntityInterface
{
    /**
     * Get id.
     *
     */
    public function getId();

    /**
     * @return string
     */
    public function __toString();
}
