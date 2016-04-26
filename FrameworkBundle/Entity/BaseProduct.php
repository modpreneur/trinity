<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Class BaseProduct.
 *
 * @UniqueEntity(fields="name")
 */
class BaseProduct
{
    use ORMBehaviors\Timestampable\Timestampable;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string Name of the product
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string Description of the product
     * @ORM\Column(type="string", nullable = true)
     */
    protected $description;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set name.
     *
     * @param string $name
     *
     * @return BaseProduct
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set description.
     *
     * @param string $description
     *
     * @return BaseProduct
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }


    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getName();
    }
}
