<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\SendSimple;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\SendSimple\SimplePushNotification;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\SendSimple\SimplePushNotification
 */
class SimplePushNotificationTest extends TestCase
{
    public function testConstructThrowsWhenNoParametersPassed(): void
    {
        $this->expectException(InsiderApiClientException::class);
        new UserIdentifiers();
    }

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

        $this->assertSame($userUuid, $notification->getUserIdentifiers()->getUuid());
        $this->assertSame($userEmail, $notification->getUserIdentifiers()->getEmail());
        $this->assertSame($userPhoneNumber, $notification->getUserIdentifiers()->getPhoneNumber());
        $this->assertSame($userCustom, $notification->getUserIdentifiers()->getCustomIdentifiers());
        $this->assertSame($campaignId, $notification->getCampaignId());
        $this->assertSame($campaignName, $notification->getCampaignName());
        $this->assertSame($notificationTitle, $notification->getTitle());
        $this->assertSame($notificationMessage, $notification->getMessage());
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testJsonSerialize(): void
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

        $this->assertSame(json_encode([
            'identifiers' => [
                'uuid' => $userUuid,
                'email' => $userEmail,
                'phone_number' => $userPhoneNumber,
                'custom' => $userCustom
            ],
            'camp_id' => $campaignId,
            'camp_name' => $campaignName,
            'title' => $notificationTitle,
            'message' => $notificationMessage,
            'send_single_user' => false,
        ]), json_encode($notification));
    }
}
