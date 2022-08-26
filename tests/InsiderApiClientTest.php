<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk;

use Chargemap\InsiderSdk\InsiderApiClient;
use Chargemap\InsiderSdk\InsiderApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\InsiderApiClient
 */
class InsiderApiClientTest extends TestCase
{
    private InsiderApiConfiguration $configuration;
    private InsiderApiClient $client;

    protected function setUp(): void
    {
        $this->client = new InsiderApiClient(
            $this->configuration = $this->createMock(InsiderApiConfiguration::class),
        );
    }
    
    public function testReturnsUsersFeaturesWithLazyLoading(): void
    {
        $usersFeatures = $this->client->users();
        $pushNotificationsFeatures = $this->client->pushNotifications();

        $this->assertSame($this->configuration, $usersFeatures->getConfiguration());
        $this->assertSame($this->configuration, $pushNotificationsFeatures->getConfiguration());

        $this->assertSame($usersFeatures, $this->client->users());
        $this->assertSame($pushNotificationsFeatures, $this->client->pushNotifications());
    }
}
