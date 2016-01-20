<?php
/**
 * Created by PhpStorm.
 * User: Jakub Fajkus
 * Date: 20.01.16
 * Time: 16:13
 */

namespace Trinity\FrameworkBundle\Services;


class PriceStringGenerator
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
     * @param $initialPrice
     * @param $type
     * @param $rebillPrice
     * @param $rebillTimes
     * @return string
     */
    public function generateFullPrice($initialPrice, $type, $rebillPrice, $rebillTimes)
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
}
