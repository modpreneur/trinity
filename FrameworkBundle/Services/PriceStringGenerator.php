<?php

namespace Trinity\FrameworkBundle\Services;

use Symfony\Component\Intl\NumberFormatter\NumberFormatter;
use Trinity\Bundle\SettingsBundle\Manager\SettingsManager;

/**
 * Class PriceStringGenerator
 * @package Trinity\FrameworkBundle\Services
 */
class PriceStringGenerator
{
    /** @var  SettingsManager */
    protected $settingsManager;

    /** @var string */
    protected $locale;


    /**
     * @param SettingsManager $settingsManager
     * @param string $locale
     */
    public function __construct(SettingsManager $settingsManager, string $locale)
    {
        $this->settingsManager = $settingsManager;
        $this->locale=$locale;
    }


    /**
     * @todo @GabrielBordovsky @TomasJancar @JakubFajkus we have problem here, we don't know Billing plan here.
     * So add BillingPlan to trinity (@JakubFajkus) you are using bp in Venice?
     * Or move this to necktie?
     *
     * @param $billingPlan
     * @return string
     */
    public function generateFullPriceStr($billingPlan){
        if(!$billingPlan->getProduct()){
            return $billingPlan->getId();
        }

       return $this->generateFullPrice($billingPlan->getInitialPrice(),$billingPlan->getType(),
           $billingPlan->getRebillPrice(),$billingPlan->getRebillTimes(),$billingPlan->getFrequency());
    }

    /**
     * @param $billingPlan
     * @return string
     */
    public function genProductNameAndFullPriceStr($billingPlan){
        if(!$billingPlan->getProduct()){
            return $billingPlan->getId();
        }

        return $billingPlan->getProduct()->getName().' : '.$this->generateFullPrice($billingPlan->getInitialPrice(),$billingPlan->getType(),
            $billingPlan->getRebillPrice(),$billingPlan->getRebillTimes(),$billingPlan->getFrequency());
    }


    /**
     * @param int $initialPrice
     * @param string $type
     * @param int $rebillPrice
     * @param int $rebillTimes
     * @param int $frequency
     *
     * @return string
     *
     * @throws \Symfony\Component\Intl\Exception\MethodArgumentValueNotImplementedException
     * @throws \Symfony\Component\Intl\Exception\MethodArgumentNotImplementedException
     * @throws \Trinity\Bundle\SettingsBundle\Exception\PropertyNotExistsException
     */
    public function generateFullPrice(
        int $initialPrice,
        string $type = 'standard',
        $rebillPrice = 0,
        $rebillTimes = 0,
        $frequency = 0
    ):string {
        $currency = $this->settingsManager->get('currency');

        $formatter = new NumberFormatter($this->locale, NumberFormatter::CURRENCY);

        if ($type==='standard') {
            return $formatter->formatCurrency($initialPrice, $currency);
        } else {
            switch ($frequency) {
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
            if ($rebillTimes === 999) {
                return $formatter->formatCurrency($initialPrice + 0, $currency).' and '
                .$formatter->formatCurrency($rebillPrice + 0, $currency).' '.$str;
            }

            return $formatter->formatCurrency($initialPrice+0, $currency).' and '
            .$rebillTimes.' times '.$formatter->formatCurrency($rebillPrice+0, $currency).' '.$str;
        }

    }
}
