<?php

namespace Srmklive\PayPal\Services;

use Exception;
use Srmklive\PayPal\Traits\PayPalRequest as PayPalAPIRequest;
use Srmklive\PayPal\Traits\PayPalVerifyIPN;

class PayPal
{
    use PayPalAPIRequest;
    use PayPalVerifyIPN;

    /**
     * PayPal constructor.
     *
     * @param array $config
     *
     * @throws Exception
     */
    public function __construct(array $config = [])
    {
        // Setting PayPal API Credentials
        $this->setConfig($config);

        $this->httpBodyParam = 'form_params';

        $this->options = [];

        $this->setRequestHeader('Accept', 'application/json');
    }

    /**
     * Set ExpressCheckout API endpoints & options.
     *
     * @param array $credentials
     */
    protected function setOptions(array $credentials): void
    {
        // Setting API Endpoints
        $sandbox = ($this->mode === 'sandbox') ? '.sandbox' : '';
        $this->config['api_url'] = "https://api-m{$sandbox}.paypal.com";

        $this->config['gateway_url'] = "https://www{$sandbox}.paypal.com";
        $this->config['ipn_url'] = "https://ipnpb{$sandbox}.paypal.com/cgi-bin/webscr";

        // Adding params outside sandbox / live array
        $this->config['payment_action'] = $credentials['payment_action'];
        $this->config['notify_url'] = $credentials['notify_url'];
        $this->config['locale'] = $credentials['locale'];
    }
}
