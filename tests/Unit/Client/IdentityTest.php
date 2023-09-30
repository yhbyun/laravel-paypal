<?php

namespace Srmklive\PayPal\Tests\Unit\Client;

use GuzzleHttp\Utils;
use PHPUnit\Framework\TestCase;
use Srmklive\PayPal\Tests\MockClientClasses;
use Srmklive\PayPal\Tests\MockRequestPayloads;
use Srmklive\PayPal\Tests\MockResponsePayloads;

class IdentityTest extends TestCase
{
    use MockClientClasses;
    use MockRequestPayloads;
    use MockResponsePayloads;

    /** @test */
    public function it_can_user_profile_details()
    {
        $expectedResponse = $this->mockShowProfileInfoResponse();

        $expectedEndpoint = 'https://api-m.sandbox.paypal.com/v1/identity/oauth2/userinfo?schema=paypalv1.1';
        $expectedParams = [
            'headers' => [
                'Accept'            => 'application/json',
                'Accept-Language'   => 'en_US',
                'Authorization'     => 'Bearer some-token',
            ],
        ];

        $mockHttpClient = $this->mock_http_request(Utils::jsonEncode($expectedResponse), $expectedEndpoint, $expectedParams, 'get');

        $this->assertEquals($expectedResponse, $this->jsonDecodeFunction()($mockHttpClient->get($expectedEndpoint, $expectedParams)->getBody(), true));
    }
}
