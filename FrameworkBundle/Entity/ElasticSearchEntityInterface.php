<?php
/**
 * Created by PhpStorm.
 * User: ufambula
 * Date: 18.5.16
 * Time: 14:22
 */

namespace Trinity\FrameworkBundle\Entity;

/**
 * Interface ElasticSearchEntityInterface
 * @package Trinity\FrameworkBundle\Entity
 */
interface ElasticSearchEntityInterface extends EntityInterface
{
    /**
     * Get id.
     *
     * @return string
     */
    public function getId() : string;

    /**
     * @return string
     */
    public function __toString() : string;
}
