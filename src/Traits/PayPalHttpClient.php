<?php

namespace Srmklive\PayPal\Traits;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use GuzzleHttp\Utils;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Srmklive\PayPal\Services\Str;

trait PayPalHttpClient
{
    /**
     * Http Client class object.
     *
     * @var HttpClient
     */
    private HttpClient $client;

    /**
     * Http Client configuration.
     *
     * @var array
     */
    private array $httpClientConfig;

    /**
     * PayPal API Endpoint.
     *
     * @var string
     */
    private string $apiUrl;

    /**
     * PayPal API Endpoint.
     *
     * @var string
     */
    private string $apiEndPoint;

    /**
     * IPN notification url for PayPal.
     *
     * @var string
     */
    private string $notifyUrl;

    /**
     * Http Client request body parameter name.
     *
     * @var string
     */
    private string $httpBodyParam;

    /**
     * Default payment action for PayPal.
     *
     * @var string
     */
    private string $paymentAction;

    /**
     * Default locale for PayPal.
     *
     * @var string
     */
    private string $locale;

    /**
     * Validate SSL details when creating HTTP client.
     *
     * @var bool
     */
    private bool $validateSSL;

    /**
     * Request type.
     *
     * @var string
     */
    protected string $verb = 'post';

    /**
     * Set curl constants if not defined.
     *
     * @return void
     */
    protected function setCurlConstants(): void
    {
        $constants = [
            'CURLOPT_SSLVERSION'        => 32,
            'CURL_SSLVERSION_TLSv1_2'   => 6,
            'CURLOPT_SSL_VERIFYPEER'    => 64,
            'CURLOPT_SSLCERT'           => 10025,
        ];

        foreach ($constants as $key => $item) {
            $this->defineCurlConstant($key, $item);
        }
    }

    /**
     * Declare a curl constant.
     *
     * @param string $key
     * @param string $value
     *
     * @return bool|string
     */
    protected function defineCurlConstant(string $key, string $value): bool|string
    {
        return defined($key) ? true : define($key, $value);
    }

    /**
     * Function to initialize/override Http Client.
     *
     * @param \GuzzleHttp\Client|null $client
     *
     * @return void
     */
    public function setClient(HttpClient $client = null): void
    {
        if ($client instanceof HttpClient) {
            $this->client = $client;

            return;
        }

        $this->client = new HttpClient([
            'curl' => $this->httpClientConfig,
        ]);
    }

    /**
     * Function to set Http Client configuration.
     *
     * @return void
     */
    protected function setHttpClientConfiguration(): void
    {
        $this->setCurlConstants();

        $this->httpClientConfig = [
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYPEER => $this->validateSSL,
        ];

        // Initialize Http Client
        $this->setClient();

        // Set default values.
        $this->setDefaultValues();

        // Set PayPal IPN Notification URL
        $this->notifyUrl = $this->config['notify_url'];
    }

    /**
     * Set default values for configuration.
     *
     * @return void
     */
    private function setDefaultValues(): void
    {
        $paymentAction = empty($this->paymentAction) ? 'Sale' : $this->paymentAction;
        $this->paymentAction = $paymentAction;

        $locale = empty($this->locale) ? 'en_US' : $this->locale;
        $this->locale = $locale;

        $validateSSL = empty($this->validateSSL) ? true : $this->validateSSL;
        $this->validateSSL = $validateSSL;

        $this->showTotals(true);
    }

    /**
     * Perform PayPal API request & return response.
     *
     * @throws \Throwable
     *
     * @return StreamInterface
     */
    private function makeHttpRequest(): StreamInterface
    {
        try {
            return $this->client->{$this->verb}(
                $this->apiUrl,
                $this->options
            )->getBody();
        } catch (HttpClientException $e) {
            throw new RuntimeException($e->getResponse()->getBody());
        }
    }

    /**
     * Function To Perform PayPal API Request.
     *
     * @param bool $decode
     *
     * @throws \Throwable
     *
     * @return array|StreamInterface|string
     */
    private function doPayPalRequest(bool $decode = true): StreamInterface|array|string
    {
        try {
            $this->apiUrl = collect([$this->config['api_url'], $this->apiEndPoint])->implode('/');

            // Perform PayPal HTTP API request.
            $response = $this->makeHttpRequest();

            return ($decode === false) ? $response->getContents() : Utils::jsonDecode($response, true);
        } catch (RuntimeException $t) {
            $error = ($decode === false) || (Str::isJson($t->getMessage()) === false) ? $t->getMessage() : Utils::jsonDecode($t->getMessage(), true);

            return ['error' => $error];
        }
    }
}
