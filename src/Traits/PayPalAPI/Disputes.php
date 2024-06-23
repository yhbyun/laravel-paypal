<?php

namespace Srmklive\PayPal\Traits\PayPalAPI;

use Psr\Http\Message\StreamInterface;
use Throwable;

trait Disputes
{
    /**
     * List disputes.
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/customer-disputes/v1/#disputes_list
     */
    public function listDisputes(): StreamInterface|array|string
    {
        $this->apiEndPoint = "v1/customer/disputes?page_size={$this->page_size}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }

    /**
     * Update a dispute.
     *
     * @param string $dispute_id
     * @param array  $data
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/customer-disputes/v1/#disputes_patch
     */
    public function updateDispute(string $dispute_id, array $data): StreamInterface|array|string
    {
        $this->apiEndPoint = "v1/customer/disputes/{$dispute_id}";

        $this->options['json'] = $data;

        $this->verb = 'patch';

        return $this->doPayPalRequest(false);
    }

    /**
     * Get dispute details.
     *
     * @param string $dispute_id
     *
     * @throws Throwable
     *
     * @return array|StreamInterface|string
     *
     * @see https://developer.paypal.com/docs/api/customer-disputes/v1/#disputes_get
     */
    public function showDisputeDetails(string $dispute_id): StreamInterface|array|string
    {
        $this->apiEndPoint = "v1/customer/disputes/{$dispute_id}";

        $this->verb = 'get';

        return $this->doPayPalRequest();
    }
}
