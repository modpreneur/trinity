<?php
/**
 * Created by PhpStorm.
 * User: ufambula
 * Date: 18.5.16
 * Time: 14:22
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface DoctrineEntityInterface
 * @package Trinity\FrameworkBundle\Entity
 */
interface DoctrineEntityInterface extends EntityInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId() : int;

    /**
     * @return string
     */
    public function __toString() : string;
}
