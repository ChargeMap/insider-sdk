<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use JsonSerializable;
use stdClass;

class PushNotification implements JsonSerializable
{
    private UserIdentifiers $userIdentifiers;
    private int $campaignId;
    private string $campaignName;
    private string $title;
    private string $message;
    private ?PushNotificationTtl $ttl;
    private ?string $imageUrl;
    private ?string $deepLink;
    private ?int $badgeCount;
    private ?PushNotificationAdvancedType $advancedType;

    /** @var PushNotificationAdvancedItem[]|null  */
    private ?array $advancedItems;

    public function __construct(
        UserIdentifiers $userIdentifiers,
        int $campaignId,
        string $campaignName,
        string $title,
        string $message,
        ?PushNotificationTtl $ttl,
        ?string $imageUrl,
        ?string $deepLink,
        ?int $badgeCount,
        ?PushNotificationAdvancedType $advancedType,
        ?array $advancedItems
    )
    {
        $this->userIdentifiers = $userIdentifiers;
        $this->campaignId = $campaignId;
        $this->campaignName = $campaignName;
        $this->title = $title;
        $this->message = $message;
        $this->ttl = $ttl;
        $this->imageUrl = $imageUrl;
        $this->deepLink = $deepLink;
        $this->badgeCount = $badgeCount;
        $this->advancedType = $advancedType;
        $this->advancedItems = $advancedItems;
    }

    public function getUserIdentifiers(): UserIdentifiers
    {
        return $this->userIdentifiers;
    }

    public function getCampaignId(): int
    {
        return $this->campaignId;
    }

    public function getCampaignName(): string
    {
        return $this->campaignName;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTtl(): ?PushNotificationTtl
    {
        return $this->ttl;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }


    public function getDeepLink(): ?string
    {
        return $this->deepLink;
    }

    public function getBadgeCount(): ?int
    {
        return $this->badgeCount;
    }

    public function getAdvancedType(): ?PushNotificationAdvancedType
    {
        return $this->advancedType;
    }

    /**
     * @return PushNotificationAdvancedItem[]|null
     */
    public function getAdvancedItems(): ?array
    {
        return $this->advancedItems;
    }

    public function jsonSerialize(): stdClass
    {
        $identifiers = [];

        foreach ($this->userIdentifiers->jsonSerialize() as $key => $value) {
            $identifiers["INSIDER.$key"] = $value;
        }

        $return = [
            'identifiers' => $identifiers,
            'camp_id' => $this->campaignId, // ID of the campaign that can be used to retrieve the statistics
            'camp_name' => $this->campaignName, // Name of the push notification
            'title' => $this->title,
            'message' => $this->message,
            'send_single_user' => false, // Send push notification to multiple devices of the user
            'ttl' => ($this->ttl ?? PushNotificationTtl::ONE_DAY())->getValue(), // Expiration time of the push notification in seconds
            'check_optin' => true, // Check if the user has opted in for the push notification
            'android' => [
                'thread-id' => 1,
                'sound' => 'sound_check', // Sound to play when the notification is received
            ],
            'ios' => [
                'thread-id' => 1,
                'delivery_silently' => false, // If true, the notification does not show up (can be used to execute background tasks remotely).
                'sound' => 'sound_check', // Sound to play when the notification is received
                'badge' => $this->badgeCount ?? 1, // Badge count to display on the app icon
            ],
        ];

        if ($this->imageUrl !== null) {
            $return['image_url'] = $this->imageUrl;
        }

        if ($this->deepLink !== null) {
            $return['android']['deep_link']['deep_android'] = $this->deepLink;
            $return['ios']['deep_link']['deep_ios'] = $this->deepLink;
        }

        if($this->advancedType !== null && $this->advancedItems !== null) {
            $return['advanced_push_payload'] = [
                'advanced_push_type' => strtolower($this->advancedType->getValue()),
                'advanced_push_items' => $this->advancedItems,
            ];
        }

        return (object)$return;
    }
}
