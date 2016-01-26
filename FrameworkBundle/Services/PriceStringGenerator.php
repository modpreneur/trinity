<?php

namespace Trinity\FrameworkBundle\Services;


use Trinity\Bundle\SettingsBundle\Manager\SettingsManager;

class PriceStringGenerator
{
    /** @var  SettingsManager */
    protected $settingsManager;

    /**
     * @param SettingsManager $settingsManager
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
            if ($rebillTimes != 999)
                $fullPrice = $fullPrice.($rebillTimes-1).' times ';

            $fullPrice = $fullPrice.twig_localized_currency_filter($rebillPrice, $currency);
            if($rebillTimes == 999) {
                $fullPrice = $fullPrice.' lifetime';
            }
        }

        return $fullPrice;
    }
}
