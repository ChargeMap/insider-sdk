<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\UpdateIdentifiers;

use Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersRequest;
use Chargemap\InsiderSdk\Users\UserIdentifiers;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @covers \Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersRequest
 */
class UpdateUserIdentifiersRequestTest extends TestCase
{
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;

    protected function setUp(): void
    {
        $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }

    public function testConstructorAndGetters(): void
    {
        $oldIdentifier = $this->createMock(UserIdentifiers::class);
        $newIdentifier = $this->createMock(UserIdentifiers::class);
        $request = new UpdateUserIdentifiersRequest($oldIdentifier, $newIdentifier);

        $this->assertSame($oldIdentifier, $request->getOldIdentifiers());
        $this->assertSame($newIdentifier, $request->getNewIdentifiers());
    }

    public function testGetRequestInterface(): void
    {
        $oldIdentifier = $this->createMock(UserIdentifiers::class);
        $newIdentifier = $this->createMock(UserIdentifiers::class);
        $request = new UpdateUserIdentifiersRequest($oldIdentifier, $newIdentifier);

        $requestInterface = $request->getRequestInterface($this->requestFactory, $this->streamFactory);
        $this->assertSame('PATCH', $requestInterface->getMethod());
        $this->assertSame('application/json', $requestInterface->getHeaderLine('Content-type'));
        $this->assertSame(json_encode([
            'old_identifier' => $oldIdentifier,
            'new_identifier' => $newIdentifier
        ]), $requestInterface->getBody()->__toString());
    }
}
