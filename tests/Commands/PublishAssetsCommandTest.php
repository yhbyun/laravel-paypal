<?php

namespace Srmklive\PayPal\Tests\Commands;

use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;

class PublishAssetsCommandTest extends TestCase
{
    use withWorkbench;

    #[Test]
    public function it_can_run_artisan_command(): void
    {
        Artisan::call('paypal:install');
        $output = Artisan::output();

        $this->assertStringContainsString('Installing the PayPal JS SDK through npm', $output);
        $this->assertStringContainsString('Installed the PayPal JS SDK.', $output);
    }
}
