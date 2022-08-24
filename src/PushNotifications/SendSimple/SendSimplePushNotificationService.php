<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\SendSimple;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;

class SendSimplePushNotificationService extends InsiderAbstractFeatures
{
    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function handle(SendSimplePushNotificationRequest $request): void
    {
        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->sendRequest($requestInterface, $request->getHostType());
    }
}
