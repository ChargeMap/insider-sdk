<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotification;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationAdvancedItem;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationAdvancedType;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationTtl;
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
        /**
         * @var array $data
         * @var PushNotification $notification
         */
        list($data, $notification) = self::getStub();

        TestCase::assertSame($data['identifiers']['uuid'], $notification->getUserIdentifiers()->getUuid());
        TestCase::assertSame($data['identifiers']['email'], $notification->getUserIdentifiers()->getEmail());
        TestCase::assertSame($data['identifiers']['phone_number'], $notification->getUserIdentifiers()->getPhoneNumber());
        TestCase::assertSame($data['identifiers']['custom'], $notification->getUserIdentifiers()->getCustomIdentifiers());
        TestCase::assertSame($data['camp_id'], $notification->getCampaignId());
        TestCase::assertSame($data['camp_name'], $notification->getCampaignName());
        TestCase::assertSame($data['title'], $notification->getTitle());
        TestCase::assertSame($data['message'], $notification->getMessage());
        TestCase::assertSame($data['ttl'], $notification->getTtl());
        TestCase::assertSame($data['image_url'], $notification->getImageUrl());
        TestCase::assertSame($data['deep_link'], $notification->getDeepLink());
        TestCase::assertSame($data['badge_count'], $notification->getBadgeCount());
        TestCase::assertSame($data['advanced_type'], $notification->getAdvancedType());
        TestCase::assertSame($data['advanced_items'][0]['id'], $notification->getAdvancedItems()[0]->getId());
        TestCase::assertSame($data['advanced_items'][0]['headline'], $notification->getAdvancedItems()[0]->getHeadline());
        TestCase::assertSame($data['advanced_items'][0]['image_url'], $notification->getAdvancedItems()[0]->getImageUrl());
        TestCase::assertSame($data['advanced_items'][0]['deep_link_data'], $notification->getAdvancedItems()[0]->getDeepLinkData());
        TestCase::assertSame($data['custom_deep_links'], $notification->getCustomDeepLinks());
    }

    /**
     * @throws InsiderApiClientException
     */
    public static function getStub(): array
    {
        $data = [
            'identifiers' => [
                'uuid' => '12345',
                'email' => 'example@example.com',
                'phone_number' => '+3312345678',
                'custom' => ['key' => 'value'],
            ],
            'camp_id' => 1,
            'camp_name' => 'campaign-name',
            'title' => 'title',
            'message' => 'message',
            'ttl' => PushNotificationTtl::ONE_AND_A_HALF_DAY(),
            'image_url' => 'https://www.chargemap.com/image.jpg',
            'deep_link' => 'deep-link',
            'custom_deep_links' => [
                'user_id' => 1,
                'grade' => 'advanced'
            ],
            'badge_count' => 2,
            'advanced_type' => PushNotificationAdvancedType::SLIDER(),
            'advanced_items' => [
                [
                    'id' => 1,
                    'headline' => 'title',
                    'description' => 'description',
                    'image_url' => 'https://www.chargemap.com/image.jpg',
                    'deep_link_data' => ['key' => 'value'],
                ],
            ],
        ];

        $notification = new PushNotification(
            new UserIdentifiers(
                $data['identifiers']['uuid'],
                $data['identifiers']['email'],
                $data['identifiers']['phone_number'],
                $data['identifiers']['custom']
            ),
            $data['camp_id'],
            $data['camp_name'],
            $data['title'],
            $data['message'],
            $data['ttl'],
            $data['image_url'],
            $data['deep_link'],
            $data['badge_count'],
            $data['advanced_type'],
            [
                new PushNotificationAdvancedItem(
                    $data['advanced_items'][0]['id'],
                    $data['advanced_items'][0]['headline'],
                    $data['advanced_items'][0]['description'],
                    $data['advanced_items'][0]['image_url'],
                    $data['advanced_items'][0]['deep_link_data'],
                )
            ],
            $data['custom_deep_links']
        );

        return [$data, $notification];
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testJsonSerialize(): void
    {
        /**
         * @var array $data
         * @var PushNotification $notification
         */
        list($data, $notification) = self::getStub();

        TestCase::assertSame(
            json_encode([
                'identifiers' => [
                    'INSIDER.uuid' => $data['identifiers']['uuid'],
                    'INSIDER.email' => $data['identifiers']['email'],
                    'INSIDER.phone_number' => $data['identifiers']['phone_number'],
                    'INSIDER.custom' => $data['identifiers']['custom'],
                ],
                'camp_id' => $data['camp_id'],
                'camp_name' => $data['camp_name'],
                'title' => $data['title'],
                'message' => $data['message'],
                'send_single_user' => false,
                'ttl' => $data['ttl']->getValue(),
                'check_optin' => true,
                'android' => [
                    'thread-id' => 1,
                    'sound' => 'sound_check',
                    'deep_link' => [
                        'ins_dl_url_scheme' => $data['deep_link'],
                        'user_id' => $data['custom_deep_links']['user_id'],
                        'grade' => $data['custom_deep_links']['grade'],
                    ]
                ],
                'ios' => [
                    'thread-id' => 1,
                    'delivery_silently' => false,
                    'sound' => 'sound_check',
                    'badge' => $data['badge_count'],
                    'deep_link' => [
                        'ins_dl_url_scheme' => $data['deep_link'],
                        'user_id' => $data['custom_deep_links']['user_id'],
                        'grade' => $data['custom_deep_links']['grade'],
                    ],
                ],
                'image_url' => $data['image_url'],
                'advanced_push_payload' => [
                    'advanced_push_type' => strtolower($data['advanced_type']->getValue()),
                    'advanced_push_items' => [
                        [
                            'id' => $data['advanced_items'][0]['id'],
                            'headline' => $data['advanced_items'][0]['headline'],
                            'description' => $data['advanced_items'][0]['description'],
                            'image_url' => $data['advanced_items'][0]['image_url'],
                            'deep_links' => $data['advanced_items'][0]['deep_link_data'],
                        ]
                    ]
                ]
            ]),
            json_encode($notification)
        );
    }
}
