<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users;

use DateTimeInterface;
use JsonSerializable;

class Event implements JsonSerializable
{
    private string $name;
    private DateTimeInterface $timestamp;
    private ?EventParams $params;

    public function __construct(string $eventName, DateTimeInterface $timestamp, ?EventParams $params = null)
    {
        $this->name = $eventName;
        $this->timestamp = $timestamp;
        $this->params = $params;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTimestamp(): DateTimeInterface
    {
        return $this->timestamp;
    }

    public function getParams(): ?EventParams
    {
        return $this->params;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'event_name' => $this->name,
            'timestamp' => $this->timestamp->format('Y-m-d\TH:i:s\Z'),
        ];
        if ($this->params !== null) {
            $return['event_params'] = $this->params;
        }
        return $return;
    }
}
