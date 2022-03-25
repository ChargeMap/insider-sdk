<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\UpdateIdentifiers;

use Chargemap\InsiderSdk\InsiderApiConfiguration;
use Chargemap\InsiderSdk\InsiderApiHost;
use Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersRequest;
use Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersService;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @covers \Chargemap\InsiderSdk\Users\UpdateIdentifiers\UpdateUserIdentifiersService
 */
class UpdateUserIdentifiersServiceTest extends TestCase
{
    private InsiderApiConfiguration $configuration;
    private UpdateUserIdentifiersService $service;

    protected function setUp(): void
    {
        $this->configuration = InsiderApiConfiguration::builder($this->createMock(InsiderApiHost::class))
            ->build();
        $this->service = $this->getMockBuilder(UpdateUserIdentifiersService::class)
            ->setConstructorArgs([$this->configuration])
            ->onlyMethods(['sendRequest'])
            ->getMock();
    }

    public function testHandle(): void
    {
        $request = $this->createMock(UpdateUserIdentifiersRequest::class);
        $expectedRequestInterface = $this->createMock(RequestInterface::class);
        $request->expects(self::once())
            ->method('getRequestInterface')
            ->with($this->configuration->getRequestFactory(), $this->configuration->getStreamFactory())
            ->willReturn($expectedRequestInterface);
        $this->service->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequestInterface);

        $this->service->handle($request);
    }
}
