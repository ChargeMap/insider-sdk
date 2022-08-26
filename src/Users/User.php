<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use JsonSerializable;

class User implements JsonSerializable
{
    private UserIdentifiers $identifiers;
    private ?Attributes $attributes;
    /** @var Event[]|null */
    private ?array $events = null;

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

    public function withEvent(Event $event): self
    {
        if (empty($this->events)) {
            $this->events = [];
        }
        $this->events[] = $event;
        return $this;
    }

    /**
     * @return Event[]|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'identifiers' => $this->identifiers,
        ];
        if ($this->attributes !== null) {
            $return['attributes'] = $this->attributes;
        }
        if (!empty($this->events)) {
            $return['events'] = $this->events;
        }
        return $return;
    }
}
