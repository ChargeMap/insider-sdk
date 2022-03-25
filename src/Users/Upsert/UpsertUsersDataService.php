<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;

class UpsertUsersDataService extends InsiderAbstractFeatures
{
    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function handle(UpsertUsersDataRequest $request): void
    {
        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->sendRequest($requestInterface);
    }
}
