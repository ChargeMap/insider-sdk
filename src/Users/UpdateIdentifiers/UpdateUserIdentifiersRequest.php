<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\UpdateIdentifiers;

use Chargemap\InsiderSdk\InsiderApiHostType;
use Chargemap\InsiderSdk\InsiderApiRequest;
use Chargemap\InsiderSdk\Users\UserIdentifiers;
use JsonSerializable;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class UpdateUserIdentifiersRequest implements InsiderApiRequest, JsonSerializable
{
    private UserIdentifiers $oldIdentifiers;
    private UserIdentifiers $newIdentifiers;

    public function __construct(UserIdentifiers $oldIdentifier, UserIdentifiers $newIdentifier)
    {
        $this->oldIdentifiers = $oldIdentifier;
        $this->newIdentifiers = $newIdentifier;
    }

    public function getOldIdentifiers(): UserIdentifiers
    {
        return $this->oldIdentifiers;
    }

    public function getNewIdentifiers(): UserIdentifiers
    {
        return $this->newIdentifiers;
    }

    public function getRequestInterface(RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory): RequestInterface
    {
        return $requestFactory->createRequest('PATCH', '/api/user/v1/identity')
            ->withHeader('Content-type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this)));
    }

    public function jsonSerialize(): array
    {
        return [
            'old_identifier' => $this->oldIdentifiers,
            'new_identifier' => $this->newIdentifiers,
        ];
    }

    public function getHostType(): InsiderApiHostType
    {
        return InsiderApiHostType::UNIFICATION();
    }
}
