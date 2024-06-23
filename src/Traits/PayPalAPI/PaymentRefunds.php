<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

use Psr\Http\Message\StreamInterface;
use Throwable;

trait PaymentRefunds
{
    /**
     * Show details for authorized payment.
     *
     * @param string $refund_id
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payments/v2/#authorizations_get
     */
    public function showRefundDetails(string $refund_id): StreamInterface|array|string
    {
        $this->apiEndPoint = "v2/payments/refunds/{$refund_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}
