<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

use Psr\Http\Message\StreamInterface;
use Throwable;

trait WebHooksVerification
{
    /**
     * Verify a web hook from PayPal.
     *
     * @param array $data
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post
     */
    public function verifyWebHook(array $data): StreamInterface|array|string
    {
        $this->apiEndPoint = 'v1/notifications/verify-webhook-signature';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }
}
