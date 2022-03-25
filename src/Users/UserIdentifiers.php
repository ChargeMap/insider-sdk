<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\InsiderApiClientException;
use JsonSerializable;

class UserIdentifiers implements JsonSerializable
{
    private ?string $uuid;
    private ?string $email;
    private ?string $phoneNumber;
    private ?array $customIdentifiers;

    /**
     * @throws InsiderApiClientException if no parameter is provided
     */
    public function __construct(
        ?string $uuid = null,
        ?string $email = null,
        ?string $phoneNumber = null,
        ?array  $customIdentifiers = null
    )
    {
        if ($uuid === null && $email === null && $phoneNumber === null && empty($customIdentifiers)) {
            throw new InsiderApiClientException('One of the identifiers must be set');
        }
        $this->uuid = $uuid;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->customIdentifiers = $customIdentifiers;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getCustomIdentifiers(): ?array
    {
        return $this->customIdentifiers;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        if ($this->uuid !== null) {
            $return['uuid'] = $this->uuid;
        }
        if ($this->email !== null) {
            $return['email'] = $this->email;
        }
        if ($this->phoneNumber !== null) {
            $return['phone_number'] = $this->phoneNumber;
        }
        if ($this->customIdentifiers !== null) {
            $return['custom'] = $this->customIdentifiers;
        }
        return $return;
    }
}
