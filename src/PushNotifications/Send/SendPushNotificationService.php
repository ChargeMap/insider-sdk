<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;

class SendPushNotificationService extends InsiderAbstractFeatures
{
    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function handle(SendPushNotificationRequest $request): void
    {
        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->sendRequest($requestInterface, $request->getHostType());
    }
}
