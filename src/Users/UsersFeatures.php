<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiException;
use Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersRequest;
use Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersService;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataRequest;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponse;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataService;

class UsersFeatures extends InsiderAbstractFeatures
{
    private ?UpsertUsersDataService $upsertUsersDataService = null;

    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function upsert(UpsertUsersDataRequest $request): UpsertUsersDataResponse
    {
        if ($this->upsertUsersDataService === null) {
            $this->upsertUsersDataService = new UpsertUsersDataService($this->configuration);
        }

        return $this->upsertUsersDataService->handle($request);
    }

    private ?UpdateUserIdentifiersService $updateUserIdentifiersService = null;

    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function updateIdentifiers(UpdateUserIdentifiersRequest $request): void
    {
        if ($this->updateUserIdentifiersService === null) {
            $this->updateUserIdentifiersService = new UpdateUserIdentifiersService($this->configuration);
        }

        $this->updateUserIdentifiersService->handle($request);
    }
}
