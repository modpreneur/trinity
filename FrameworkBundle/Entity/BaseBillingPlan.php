<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Necktie\AppBundle\Traits\ExcludeBlameableTrait;

/**
 * BillingPlan.
 *
 */
class BaseBillingPlan implements DoctrineEntityInterface
{
    use ORMBehaviors\Timestampable\Timestampable,
        ORMBehaviors\Blameable\Blameable,
        ExcludeBlameableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \Trinity\FrameworkBundle\Entity\BaseProduct product
     *
     * @ORM\ManyToOne(targetEntity="Trinity\FrameworkBundle\Entity\BaseProduct")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     *
     * @Assert\NotBlank()
     * @exclude
     */
    protected $product;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"standard", "recurring"}, message = "Choose a valid type.")
     */
    protected $type;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=2)
     *
     * @Assert\LessThan(value=100000)
     * @Assert\NotBlank()
     */
    protected $initialPrice;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=2, nullable=true)
     *
     * @Assert\LessThan(value=100000)
     */
    protected $rebillPrice;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $frequency;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $rebillTimes;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $trial;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @param int $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @return float
     */
    public function getInitialPrice()
    {
        return $this->initialPrice;
    }

    /**
     * @param float $initialPrice
     */
    public function setInitialPrice($initialPrice)
    {
        $this->initialPrice = $initialPrice;
    }

    /**
     * @return \Trinity\FrameworkBundle\Entity\BaseProduct
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \Trinity\FrameworkBundle\Entity\BaseProduct $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return float
     */
    public function getRebillPrice()
    {
        return $this->rebillPrice;
    }

    /**
     * @param float $rebillPrice
     */
    public function setRebillPrice($rebillPrice)
    {
        $this->rebillPrice = $rebillPrice;
    }

    /**
     * @return int
     */
    public function getRebillTimes()
    {
        return $this->rebillTimes;
    }

    /**
     * @param int $rebillTimes
     */
    public function setRebillTimes($rebillTimes)
    {
        $this->rebillTimes = $rebillTimes;
    }

    /**
     * @return int
     */
    public function getTrial()
    {
        return $this->trial;
    }

    /**
     * @param int $trial
     */
    public function setTrial($trial)
    {
        $this->trial = $trial;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @return string
     */
    public function __toString() : string
    {

        if ($this->type === 'standard') {
            return $this->type . ' ' . $this->initialPrice;
        } else {
            switch ($this->frequency) {
                case 7:
                    $str = 'weekly';
                    break;
                case 14:
                    $str = 'bi-weekly';
                    break;
                case 30:
                    $str = 'monthly';
                    break;
                case 91:
                    $str = 'quartaly';
                    break;
                default:
                    $str = '';
            }
            return ($this->initialPrice + 0).' and '.$this->rebillTimes. ' times '.($this->rebillPrice + 0). ' ' .$str;
        }
    }
}
