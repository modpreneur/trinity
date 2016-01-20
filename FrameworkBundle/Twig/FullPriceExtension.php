<?php
/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Twig;



use Trinity\FrameworkBundle\Services\PriceStringGenerator;

class FullPriceExtension extends \Twig_Extension
{
    /** @var PriceStringGenerator */
    protected $generator;

    /**
     * @param $generator
     */
    public function __construct($generator) {
        $this->generator = $generator;
    }


    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('fullPrice', array($this, 'fullPrice')),
        );
    }

    /**
     * @param $initialPrice
     * @param $type
     * @param $rebillPrice
     * @param $rebillTimes
     * @return mixed|string
     */
    public function fullPrice($initialPrice, $type, $rebillPrice, $rebillTimes)
    {
        return $this->generator->generateFullPrice($initialPrice, $type, $rebillPrice, $rebillTimes);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'trinity_admin_full_price_extension';
    }
}
