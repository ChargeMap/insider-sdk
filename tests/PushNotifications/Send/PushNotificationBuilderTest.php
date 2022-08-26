<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotification;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationAdvancedItem;
use Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationBuilder;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\PushNotifications\Send\PushNotificationBuilder
 */
class PushNotificationBuilderTest extends TestCase
{
    /**
     * @throws InsiderApiClientException
     */
    public function testBuild(): void
    {
        /**
         * @var array $data
         * @var PushNotification $notification
         */
        list($data) = PushNotificationTest::getStub();

        $notification = PushNotificationBuilder::builder()
            ->withUserIdentifiers(
                new UserIdentifiers(
                    $data['identifiers']['uuid'],
                    $data['identifiers']['email'],
                    $data['identifiers']['phone_number'],
                    $data['identifiers']['custom']
                )
            )
            ->withCampaignId($data['camp_id'])
            ->withCampaignName($data['camp_name'])
            ->withTitle($data['title'])
            ->withMessage($data['message'])
            ->withImageUrl($data['image_url'])
            ->withDeepLink($data['deep_link'])
            ->withBadgeCount($data['badge_count'])
            ->withAdvancedItems(
                $data['advanced_type'],
                [
                    new PushNotificationAdvancedItem(
                        $data['advanced_items'][0]['id'],
                        $data['advanced_items'][0]['headline'],
                        $data['advanced_items'][0]['description'],
                        $data['advanced_items'][0]['image_url'],
                        $data['advanced_items'][0]['deep_link_data']
                    ),
                ]
            )
            ->build();

        TestCase::assertSame($data['identifiers']['uuid'], $notification->getUserIdentifiers()->getUuid());
        TestCase::assertSame($data['identifiers']['email'], $notification->getUserIdentifiers()->getEmail());
        TestCase::assertSame($data['identifiers']['phone_number'], $notification->getUserIdentifiers()->getPhoneNumber());
        TestCase::assertSame($data['identifiers']['custom'], $notification->getUserIdentifiers()->getCustomIdentifiers());
        TestCase::assertSame($data['camp_id'], $notification->getCampaignId());
        TestCase::assertSame($data['camp_name'], $notification->getCampaignName());
        TestCase::assertSame($data['title'], $notification->getTitle());
        TestCase::assertSame($data['message'], $notification->getMessage());
        TestCase::assertSame($data['image_url'], $notification->getImageUrl());
        TestCase::assertSame($data['deep_link'], $notification->getDeepLink());
        TestCase::assertSame($data['badge_count'], $notification->getBadgeCount());
        TestCase::assertSame($data['advanced_type'], $notification->getAdvancedType());
        TestCase::assertSame($data['advanced_items'][0]['id'], $notification->getAdvancedItems()[0]->getId());
        TestCase::assertSame($data['advanced_items'][0]['headline'], $notification->getAdvancedItems()[0]->getHeadline());
        TestCase::assertSame($data['advanced_items'][0]['image_url'], $notification->getAdvancedItems()[0]->getImageUrl());
        TestCase::assertSame($data['advanced_items'][0]['deep_link_data'], $notification->getAdvancedItems()[0]->getDeepLinkData());
    }

    public function testBuildShouldThrowMissingRequiredProperties(): void
    {
        // Missing 'userIdentifiers'.
        $builder = PushNotificationBuilder::builder();
        $this->expectExceptionObject(new InvalidArgumentException("Missing required property 'userIdentifiers'"));
        $builder->build();

        // Missing 'campaignId'.
        $builder = $builder->withUserIdentifiers(new UserIdentifiers('uuid'));
        $this->expectExceptionObject(new InvalidArgumentException("Missing required property 'campaignId'"));
        $builder->build();

        // Missing 'campaignName'.
        $builder = $builder->withCampaignId(1);
        $this->expectExceptionObject(new InvalidArgumentException("Missing required property 'campaignName'"));
        $builder->build();

        // Missing 'title'.
        $builder = $builder->withCampaignName('name');
        $this->expectExceptionObject(new InvalidArgumentException("Missing required property 'title'"));
        $builder->build();

        // Missing 'message'.
        $builder = $builder->withTitle('title');
        $this->expectExceptionObject(new InvalidArgumentException("Missing required property 'message'"));
        $builder->build();

        // Required properties are present.
        $builder = $builder->withMessage('message');
        $builder->build();
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testBuildShouldThrowMissingAdvancedItemsProperties(): void
    {
        /**
         * @var array $data
         * @var PushNotification $notification
         */
        list($data) = PushNotificationTest::getStub();

        $builder = PushNotificationBuilder::builder()
            ->withUserIdentifiers(
                new UserIdentifiers(
                    $data['identifiers']['uuid'],
                    $data['identifiers']['email'],
                    $data['identifiers']['phone_number'],
                    $data['identifiers']['custom']
                )
            )
            ->withCampaignId($data['camp_id'])
            ->withCampaignName($data['camp_name'])
            ->withTitle($data['title'])
            ->withMessage($data['message'])
            ->withAdvancedItems($data['advanced_type'], []);

        $this->expectExceptionObject(new InvalidArgumentException("Properties 'advancedType' and 'advancedItems' are simultaneously required"));
        $builder->build();
    }
}
