<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\SendSimple;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use JsonSerializable;
use stdClass;

class SimplePushNotification implements JsonSerializable
{
    private UserIdentifiers $userIdentifiers;
    private int $campaignId;
    private string $campaignName;
    private string $title;
    private string $message;

    public function __construct(UserIdentifiers $userIdentifiers, int $campaignId, string $campaignName, string $title, string $message)
    {
        $this->userIdentifiers = $userIdentifiers;
        $this->campaignId = $campaignId;
        $this->campaignName = $campaignName;
        $this->title = $title;
        $this->message = $message;
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

    public function jsonSerialize(): stdClass
    {
        $identifiers = [];

        foreach($this->userIdentifiers->jsonSerialize() as $key => $value) {
            $identifiers["INSIDER.$key"] = $value;
        }

        return (object)[
            'identifiers' => $identifiers,
            'camp_id' => $this->campaignId, // ID of the campaign that can be used to retrieve the statistics
            'camp_name' => $this->campaignName, // Name of the push notification
            'title' => $this->title,
            'message' => $this->message,
            'send_single_user' => false, // Send push notification to multiple devices of the user
        ];
    }
}
