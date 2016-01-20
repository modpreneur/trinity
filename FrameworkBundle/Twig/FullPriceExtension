<?php
/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Twig;


class FullPriceExtension extends \Twig_Extension
{
    /** @var  SettingsManager */
    protected $settingsManager;

    /**
     * @param $settingsManager
     */
    public function __construct($settingsManager) {
        $this->settingsManager = $settingsManager;
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
        $currency = $this->settingsManager->get('currency');

        $fullPrice = twig_localized_currency_filter($initialPrice, $currency);

        if ($type === 'recurring'){
            $fullPrice = $fullPrice.' and ';
            if ($rebillTimes !== '999')
                $fullPrice = $fullPrice.($rebillTimes-1).' times ';

            $fullPrice = $fullPrice.twig_localized_currency_filter($rebillPrice, $currency);
            if($rebillTimes === '999') {
                $fullPrice = $fullPrice.'lifetime';
            }
        }

        return $fullPrice;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'trinity_admin_full_price_extension';
    }
}
