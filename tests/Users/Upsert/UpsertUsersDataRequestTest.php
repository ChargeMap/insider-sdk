<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataRequest;
use Chargemap\InsiderSdk\Users\User;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @covers \Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataRequest
 */
class UpsertUsersDataRequestTest extends TestCase
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    protected function setUp(): void
    {
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }

    public function testBuilderAndGetter(): void
    {
        $users = [
            $this->createMock(User::class),
            $this->createMock(User::class)
        ];

        $request = UpsertUsersDataRequest::builder()
            ->withUser($users[0])
            ->withUser($users[1]);

        $this->assertSame($users, $request->getUsers());
    }

    public function testGetRequestInterface(): void
    {
        $users = [
            $this->createMock(User::class),
            $this->createMock(User::class)
        ];

        $request = UpsertUsersDataRequest::builder()
            ->withUser($users[0])
            ->withUser($users[1]);

        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->assertSame('POST', $requestInterface->getMethod());
        $this->assertSame('application/json', $requestInterface->getHeaderLine('Content-type'));
        $this->assertSame(json_encode([
            'users' => $users
        ]), $requestInterface->getBody()->__toString());
    }
}
