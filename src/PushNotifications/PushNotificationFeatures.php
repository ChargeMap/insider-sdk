<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;
use Chargemap\InsiderSdk\PushNotifications\Send\SendPushNotificationRequest;
use Chargemap\InsiderSdk\PushNotifications\Send\SendPushNotificationService;

class PushNotificationFeatures extends InsiderAbstractFeatures
{
    private ?SendPushNotificationService $sendPushNotificationService = null;

    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function send(SendPushNotificationRequest $request): void
    {
        if ($this->sendPushNotificationService === null) {
            $this->sendPushNotificationService = new SendPushNotificationService($this->configuration);
        }

        $this->sendPushNotificationService->handle($request);
    }
}
