<?php

namespace Srmklive\PayPal\Traits\PayPalAPI\BillingPlans;

use Psr\Http\Message\StreamInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

trait PricingSchemes
{
    protected array $pricing_schemes = [];

    /**
     * Add pricing scheme for the billing plan.
     *
     * @param string $interval_unit
     * @param int    $interval_count
     * @param float  $price
     * @param bool   $trial
     *
     * @throws Throwable
     *
     * @return PayPalClient
     */
    public function addPricingScheme(string $interval_unit, int $interval_count, float $price, bool $trial = false): PayPalClient
    {
        $this->pricing_schemes[] = $this->addPlanBillingCycle($interval_unit, $interval_count, $price, $trial);

        return $this;
    }

    /**
     * Process pricing updates for an existing billing plan.
     *
     * @throws \Throwable
     *
     * @return array|StreamInterface|string
     */
    public function processBillingPlanPricingUpdates(): StreamInterface|array|string
    {
        return $this->updatePlanPricing($this->billing_plan['id'], $this->pricing_schemes);
    }
}
