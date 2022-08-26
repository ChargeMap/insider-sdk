<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use InvalidArgumentException;

class PushNotificationBuilder
{
    private ?UserIdentifiers $userIdentifiers = null;
    private ?int $campaignId = null;
    private ?string $campaignName = null;
    private ?string $title = null;
    private ?string $message = null;
    private ?string $imageUrl = null;
    private ?string $deepLink = null;
    private ?int $badgeCount = null;
    private ?PushNotificationAdvancedType $advancedType = null;

    /** @var PushNotificationAdvancedItem[]|null */
    private ?array $advancedItems = null;

    public static function builder(): self
    {
        return new self();
    }

    public function withUserIdentifiers(?UserIdentifiers $userIdentifiers): self
    {
        $return = clone $this;
        $return->userIdentifiers = $userIdentifiers;
        return $return;
    }

    public function withCampaignId(?int $campaignId): self
    {
        $return = clone $this;
        $return->campaignId = $campaignId;
        return $return;
    }

    public function withCampaignName(?string $campaignName): self
    {
        $return = clone $this;
        $return->campaignName = $campaignName;
        return $return;
    }

    public function withTitle(?string $title): self
    {
        $return = clone $this;
        $return->title = $title;
        return $return;
    }

    public function withMessage(?string $message): self
    {
        $return = clone $this;
        $return->message = $message;
        return $return;
    }

    public function withImageUrl(?string $imageUrl): self
    {
        $return = clone $this;
        $return->imageUrl = $imageUrl;
        return $return;
    }

    public function withDeepLink(?string $deepLink): self
    {
        $return = clone $this;
        $return->deepLink = $deepLink;
        return $return;
    }

    public function withBadgeCount(?int $badgeCount): self
    {
        $return = clone $this;
        $return->badgeCount = $badgeCount;
        return $return;
    }

    public function withAdvancedItems(PushNotificationAdvancedType $advancedType, array $advancedItems): self
    {
        $return = clone $this;
        $return->advancedType = $advancedType;
        $return->advancedItems = $advancedItems;
        return $return;
    }

    public function build(): PushNotification
    {
        $requiredProperties = [
            'userIdentifiers',
            'campaignId',
            'campaignName',
            'title',
            'message',
        ];

        foreach ($requiredProperties as $property) {
            if ($this->$property === null) {
                throw new InvalidArgumentException("Missing required property '$property'");
            }
        }

        if (($this->advancedType === null) !== (empty($this->advancedItems))) {
            throw new InvalidArgumentException("Properties 'advancedType' and 'advancedItems' are simultaneously required");
        }

        return new PushNotification(
            $this->userIdentifiers,
            $this->campaignId,
            $this->campaignName,
            $this->title,
            $this->message,
            $this->imageUrl,
            $this->deepLink,
            $this->badgeCount,
            $this->advancedType,
            $this->advancedItems
        );
    }
}
