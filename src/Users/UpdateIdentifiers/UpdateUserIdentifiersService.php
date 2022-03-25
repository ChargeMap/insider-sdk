<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\UpdateIdentifiers;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;

class UpdateUserIdentifiersService extends InsiderAbstractFeatures
{
    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function handle(UpdateUserIdentifiersRequest $request): void
    {
        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->sendRequest($requestInterface);
    }
}
