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
        $userUuid = '12345';
        $userEmail = 'example@example.com';
        $userPhoneNumber = '+3312345678';
        $userCustom = ['key' => 'value'];
        $campaignId = 1;
        $campaignName = 'campaign-name';
        $title = 'notification-title';
        $message = 'notification-message';
        $imageUrl = 'https://www.chargemap.com/image.jpg';
        $deepLink = 'notification-deek-link';
        $badgeCount = 2;

        $notification = new PushNotification(
            new UserIdentifiers($userUuid, $userEmail, $userPhoneNumber, $userCustom),
            $campaignId,
            $campaignName,
            $title,
            $message,
            $imageUrl,
            $deepLink,
            $badgeCount
        );

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
