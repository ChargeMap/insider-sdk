<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotification;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\Send\PushNotification
 */
class PushNotificationTest extends TestCase
{
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

        $this->assertSame($userUuid, $notification->getUserIdentifiers()->getUuid());
        $this->assertSame($userEmail, $notification->getUserIdentifiers()->getEmail());
        $this->assertSame($userPhoneNumber, $notification->getUserIdentifiers()->getPhoneNumber());
        $this->assertSame($userCustom, $notification->getUserIdentifiers()->getCustomIdentifiers());
        $this->assertSame($campaignId, $notification->getCampaignId());
        $this->assertSame($campaignName, $notification->getCampaignName());
        $this->assertSame($title, $notification->getTitle());
        $this->assertSame($message, $notification->getMessage());
        $this->assertSame($imageUrl, $notification->getImageUrl());
        $this->assertSame($deepLink, $notification->getDeepLink());
        $this->assertSame($badgeCount, $notification->getBadgeCount());
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

        $this->assertSame(
            json_encode([
                'identifiers' => [
                    'INSIDER.uuid' => $userUuid,
                    'INSIDER.email' => $userEmail,
                    'INSIDER.phone_number' => $userPhoneNumber,
                    'INSIDER.custom' => $userCustom
                ],
                'camp_id' => $campaignId,
                'camp_name' => $campaignName,
                'title' => $title,
                'message' => $message,
                'send_single_user' => false,
                'ttl' => 1,
                'android' => [
                    'sound' => 'sound_check',
                    'deep_link' => [
                        'deep_android' => $deepLink
                    ]
                ],
                'ios' => [
                    'sound' => 'sound_check',
                    'badge' => $badgeCount,
                    'deep_link' => [
                        'deep_ios' => $deepLink
                    ],
                ],
                'image_url' => $imageUrl
            ]),
            json_encode($notification)
        );
    }
}
