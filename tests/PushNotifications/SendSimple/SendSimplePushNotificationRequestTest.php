<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\SendSimple;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\SendSimple\SendSimplePushNotificationRequest;
use Chargemap\InsiderSdk\PushNotifications\SendSimple\SimplePushNotification;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\SendSimple\SendSimplePushNotificationRequest
 */
class SendSimplePushNotificationRequestTest extends TestCase
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
        $notificationTitle = 'notification-title';
        $notificationMessage = 'notification-message';

        $notification = new SimplePushNotification(
            new UserIdentifiers($userUuid, $userEmail, $userPhoneNumber, $userCustom),
            $campaignId,
            $campaignName,
            $notificationTitle,
            $notificationMessage,
        );

        $request = new SendSimplePushNotificationRequest($notification);

        $this->assertSame($notification, $request->getNotification());
    }

    public function testGetRequestInterface(): void
    {
        $notification = $this->createMock(SimplePushNotification::class);
        $request = new SendSimplePushNotificationRequest($notification);

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
