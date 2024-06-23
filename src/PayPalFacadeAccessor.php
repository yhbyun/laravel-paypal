<?php

namespace Srmklive\PayPal;

use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalFacadeAccessor
{
    /**
     * PayPal API provider object.
     *
     * @var PayPalClient
     */
    public static PayPalClient $provider;

    /**
     * Get specific PayPal API provider object to use.
     *
     * @throws Exception
     *
     * @return PayPalClient
     */
    public static function getProvider(): PayPalClient
    {
        return self::$provider;
    }

    /**
     * Set PayPal API Client to use.
     *
     * @throws \Exception
     *
     * @return PayPalClient
     */
    public static function setProvider(): PayPalClient
    {
        // Set default provider. Defaults to ExpressCheckout
        self::$provider = new PayPalClient();

        return self::getProvider();
    }
}
