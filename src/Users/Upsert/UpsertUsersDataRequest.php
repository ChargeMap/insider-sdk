<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\InsiderApiHostType;
use Chargemap\InsiderSdk\InsiderApiRequest;
use Chargemap\InsiderSdk\Users\User;
use JsonSerializable;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class UpsertUsersDataRequest implements InsiderApiRequest, JsonSerializable
{
    /** @var User[] */
    private array $users = [];

    private function __construct()
    {
    }

    public function withUser(User $user): self
    {
        $this->users[] = $user;
        return $this;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public static function builder(): self
    {
        return new self();
    }

    public function getRequestInterface(RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory): RequestInterface
    {
        return $requestFactory->createRequest('POST', '/api/user/v1/upsert')
            ->withHeader('Content-type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this)));
    }

    public function jsonSerialize(): array
    {
        return [
            'users' => $this->users
        ];
    }

    public function getHostType(): InsiderApiHostType
    {
        return InsiderApiHostType::UNIFICATION();
    }
}
