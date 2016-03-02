<?php

namespace Trinity\FrameworkBundle\Services;


use Trinity\Bundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\Intl\NumberFormatter\NumberFormatter;


class PriceStringGenerator
{
    /** @var  SettingsManager */
    protected $settingsManager;

    /** @var  locale */
    protected $locale;

    /**
     * @param SettingsManager $settingsManager
     * @param locale
     */
    public function __construct($settingsManager,$locale) {
        $this->settingsManager = $settingsManager;
        $this->locale=$locale;
    }

    public function generateFullPriceStr($billingPlan){
        if(!$billingPlan->getProduct()){
            return $billingPlan->getId();
        }

       return $this->generateFullPrice($billingPlan->getInitialPrice(),$billingPlan->getType(),
           $billingPlan->getRebillPrice(),$billingPlan->getRebillTimes(),$billingPlan->getFrequency());
    }

    /**
     * @param $initialPrice
     * @param $type
     * @param $rebillPrice
     * @param $rebillTimes
     * @param $frequency
     * @return string
     */
    public function generateFullPrice($initialPrice, $type='standard', $rebillPrice=0, $rebillTimes=0,$frequency=0)
    {
        $currency = $this->settingsManager->get('currency');

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);

        if($type==='standard')
            return $formatter->formatCurrency($initialPrice, $currency);
        else {
            switch ($frequency) {
                case 7:
                    $str = "weekly";
                    break;
                case 14:
                    $str = "bi-weekly";
                    break;
                case 30:
                    $str = "monthly";
                    break;
                case 91:
                    $str = "quartaly";
                    break;
                default:
                    $str = "";
            };
            if ($rebillTimes == 999) {
                return ($formatter->formatCurrency($initialPrice + 0, $currency)).' and '
                .$formatter->formatCurrency($rebillPrice + 0, $currency).' '.$str;
            }

            return ($formatter->formatCurrency($initialPrice+0, $currency)).' and '
            .$rebillTimes.' times '.$formatter->formatCurrency($rebillPrice+0,
                $currency).' '.$str;
        }

    }
}
