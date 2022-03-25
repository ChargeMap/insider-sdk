<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use Chargemap\InsiderSdk\Users\UsersFeatures;

class InsiderApiClient
{
    private InsiderApiConfiguration $configuration;

    public function __construct(InsiderApiConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    private ?UsersFeatures $usersFeatures = null;

    public function users(): UsersFeatures
    {
        if ($this->usersFeatures === null) {
            $this->usersFeatures = new UsersFeatures($this->configuration);
        }

        return $this->usersFeatures;
    }
}
