<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationAdvancedItem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationAdvancedItem
 */
class PushNotificationAdvancedItemTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        /**
         * @var array $data
         * @var PushNotificationAdvancedItem $item
         */
        list($data, $item) = self::getStub();

        TestCase::assertSame($data['id'], $item->getId());
        TestCase::assertSame($data['headline'], $item->getHeadline());
        TestCase::assertSame($data['image_url'], $item->getImageUrl());
        TestCase::assertSame($data['deep_link_data'], $item->getDeepLinkData());
    }

    public static function getStub(): array
    {
        $data = [
            'id' => 1,
            'headline' => 'title',
            'description' => 'description',
            'image_url' => 'https://www.chargemap.com/image.jpg',
            'deep_link_data' => ['key' => 'value'],
        ];

        $item = new PushNotificationAdvancedItem(
            $data['id'],
            $data['headline'],
            $data['description'],
            $data['image_url'],
            $data['deep_link_data'],
        );

        return [$data, $item];
    }

    public function testJsonSerialize(): void
    {
        /**
         * @var array $data
         * @var PushNotificationAdvancedItem $item
         */
        list($data, $item) = self::getStub();

        TestCase::assertSame(
            json_encode([
                'id' => $data['id'],
                'headline' => $data['headline'],
                'description' => $data['description'],
                'image_url' => $data['image_url'],
                'deep_links' => $data['deep_link_data'],
            ]),
            json_encode($item)
        );
    }
}
