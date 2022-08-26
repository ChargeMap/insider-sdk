<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\Send\SendPushNotificationRequest;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotification;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\Send\SendPushNotificationRequest
 */
class SendPushNotificationRequestTest extends TestCase
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    /**
     * @throws InsiderApiClientException
     */
    public function testConstructorAndGetters(): void
    {
        list(, $notification) = PushNotificationTest::getStub();

        $request = new SendPushNotificationRequest($notification);

        $this->assertSame($notification, $request->getNotification());
    }

    public function testGetRequestInterface(): void
    {
        $notification = $this->createMock(PushNotification::class);
        $request = new SendPushNotificationRequest($notification);

        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->assertSame('POST', $requestInterface->getMethod());
        $this->assertSame('application/json', $requestInterface->getHeaderLine('Content-type'));
        $this->assertSame(json_encode(['notifications' => [$notification]]), $requestInterface->getBody()->__toString());
    }

    protected function setUp(): void
    {
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }
}
