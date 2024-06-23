<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

use Psr\Http\Message\StreamInterface;
use Throwable;

trait PaymentMethodsTokens
{
    use PaymentMethodsTokens\Helpers;

    /**
     * Create a payment method token.
     *
     * @param array $data
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#payment-tokens_create
     */
    public function createPaymentSourceToken(array $data): StreamInterface|array|string
    {
        $this->apiEndPoint = 'v3/vault/payment-tokens';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * List all the payment tokens.
     *
     * @param int  $page
     * @param int  $page_size
     * @param bool $totals
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#customer_payment-tokens_get
     */
    public function listPaymentSourceTokens(int $page = 1, int $page_size = 10, bool $totals = true): StreamInterface|array|string
    {
        $this->apiEndPoint = "v3/vault/payment-tokens?customer_id={$this->customer_source['id']}&page={$page}&page_size={$page_size}&total_required={$totals}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Show details for a payment method token.
     *
     * @param string $token
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#payment-tokens_get
     */
    public function showPaymentSourceTokenDetails(string $token): StreamInterface|array|string
    {
        $this->apiEndPoint = "v3/vault/payment-tokens/{$token}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Show details for a payment token.
     *
     * @param string $token
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#payment-tokens_delete
     */
    public function deletePaymentSourceToken(string $token): StreamInterface|array|string
    {
        $this->apiEndPoint = "v3/vault/payment-tokens/{$token}";

        $this->verb = 'delete';

        return $this->doPayPalRequest(false);
    }

    /**
     * Create a payment setup token.
     *
     * @param array $data
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#setup-tokens_create
     */
    public function createPaymentSetupToken(array $data): StreamInterface|array|string
    {
        $this->apiEndPoint = 'v3/vault/setup-tokens';

        $this->options['json'] = $data;

        $this->verb = 'post';

        return $this->doPayPalRequest();
    }

    /**
     * Show details for a payment setup token.
     *
     * @param string $token
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/payment-tokens/v3/#setup-tokens_get
     */
    public function showPaymentSetupTokenDetails(string $token): StreamInterface|array|string
    {
        $this->apiEndPoint = "v3/vault/setup-tokens/{$token}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}
