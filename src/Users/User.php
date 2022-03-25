<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use JsonSerializable;

class User implements JsonSerializable
{
    private UserIdentifiers $identifiers;
    private ?Attributes $attributes;

    public function __construct(UserIdentifiers $identifiers, ?Attributes $attributes = null)
    {
        $this->identifiers = $identifiers;
        $this->attributes = $attributes;
    }

    public function getIdentifiers(): UserIdentifiers
    {
        return $this->identifiers;
    }

    public function getAttributes(): ?Attributes
    {
        return $this->attributes;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'identifiers' => $this->identifiers,
        ];
        if ($this->attributes !== null) {
            $return['attributes'] = $this->attributes;
        }
        return $return;
    }
}
