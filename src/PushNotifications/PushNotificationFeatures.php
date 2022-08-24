<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;
use Chargemap\InsiderSdk\PushNotifications\SendSimple\SendSimplePushNotificationRequest;
use Chargemap\InsiderSdk\PushNotifications\SendSimple\SendSimplePushNotificationService;

class PushNotificationFeatures extends InsiderAbstractFeatures
{
    private ?SendSimplePushNotificationService $sendSimplePushNotificationService = null;

    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function sendSimple(SendSimplePushNotificationRequest $request): void
    {
        if ($this->sendSimplePushNotificationService === null) {
            $this->sendSimplePushNotificationService = new SendSimplePushNotificationService($this->configuration);
        }

        $this->sendSimplePushNotificationService->handle($request);
    }
}
