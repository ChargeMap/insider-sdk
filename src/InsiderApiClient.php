<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use Chargemap\InsiderSdk\PushNotifications\PushNotificationFeatures;
use Chargemap\InsiderSdk\Users\UsersFeatures;

class InsiderApiClient
{
    private InsiderApiConfiguration $configuration;
    private ?UsersFeatures $usersFeatures = null;
    private ?PushNotificationFeatures $pushNotificationFeatures = null;

    public function __construct(InsiderApiConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function users(): UsersFeatures
    {
        if ($this->usersFeatures === null) {
            $this->usersFeatures = new UsersFeatures($this->configuration);
        }

        return $this->usersFeatures;
    }

    public function pushNotifications(): PushNotificationFeatures
    {
        if ($this->pushNotificationFeatures === null) {
            $this->pushNotificationFeatures = new PushNotificationFeatures($this->configuration);
        }

        return $this->pushNotificationFeatures;
    }
}
