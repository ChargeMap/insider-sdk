<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use JsonSerializable;
use stdClass;

class PushNotificationAdvancedItem implements JsonSerializable
{
    private int $id;
    private string $headline;
    private string $description;
    private ?string $imageUrl;
    private ?array $deepLinkData;

    public function __construct(
        int $id,
        string $headline,
        string $description,
        ?string $imageUrl,
        ?array $deepLinkData
    )
    {
        $this->id = $id;
        $this->headline = $headline;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->deepLinkData = $deepLinkData;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function getDeepLinkData(): ?array
    {
        return $this->deepLinkData;
    }

    public function jsonSerialize(): stdClass
    {
        $return = [
            'id' => $this->id,
            'headline' => $this->headline,
            'description' => $this->description,
        ];

        if ($this->imageUrl !== null) {
            $return['image_url'] = $this->imageUrl;
        }

        if ($this->deepLinkData !== null) {
            $return['deep_links'] = $this->deepLinkData;
        }

        return (object)$return;
    }
}
