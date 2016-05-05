<?php
/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Twig;

use Trinity\FrameworkBundle\Services\PriceStringGenerator;

/**
 * Class FullPriceExtension
 * @package Trinity\FrameworkBundle\Twig
 */
class FullPriceExtension extends \Twig_Extension
{
    /** @var PriceStringGenerator */
    protected $generator;

    /**
     * @param PriceStringGenerator $generator
     */
    public function __construct(PriceStringGenerator $generator)
    {
        $this->generator = $generator;
    }


    /**
     * @return array
     */
    public function getFunctions() : array
    {
        return [
            new \Twig_SimpleFunction('fullPrice', [$this, 'fullPrice']),
        ];
    }

    /**
     * @param int $initialPrice
     * @param string $type
     * @param int $rebillPrice
     * @param int $rebillTimes
     *
     * @return string
     *
     * @throws \Trinity\Bundle\SettingsBundle\Exception\PropertyNotExistsException
     * @throws \Symfony\Component\Intl\Exception\MethodArgumentValueNotImplementedException
     * @throws \Symfony\Component\Intl\Exception\MethodArgumentNotImplementedException
     */
    public function fullPrice($initialPrice, $type, $rebillPrice, $rebillTimes):string
    {
        return $this->generator->generateFullPrice($initialPrice, $type, $rebillPrice, $rebillTimes);
    }


    /**
     * @return string
     */
    public function getName():string
    {
        return 'trinity_admin_full_price_extension';
    }
}
