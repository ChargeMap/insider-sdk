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

        return new PushNotification(
            $this->userIdentifiers,
            $this->campaignId,
            $this->campaignName,
            $this->title,
            $this->message,
            $this->imageUrl,
            $this->deepLink,
            $this->badgeCount
        );
    }
}
