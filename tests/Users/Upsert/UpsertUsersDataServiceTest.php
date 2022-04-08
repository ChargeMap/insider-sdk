<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiConfiguration;
use Chargemap\InsiderSdk\InsiderApiException;
use Chargemap\InsiderSdk\InsiderApiHost;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataRequest;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponseFactory;
use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataService;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @covers \Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataService
 */
class UpsertUsersDataServiceTest extends TestCase
{
    private InsiderApiConfiguration $configuration;
    private UpsertUsersDataService $service;

    protected function setUp(): void
    {
        $this->configuration = InsiderApiConfiguration::builder($this->createMock(InsiderApiHost::class))
            ->build();
        $this->service = $this->getMockBuilder(UpsertUsersDataService::class)
            ->setConstructorArgs([$this->configuration])
            ->onlyMethods(['sendRequest'])
            ->getMock();
    }

    /**
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testHandle(): void
    {
        $request = $this->createMock(UpsertUsersDataRequest::class);
        $expectedRequestInterface = $this->createMock(RequestInterface::class);
        $request->expects(self::once())
            ->method('getRequestInterface')
            ->with($this->configuration->getRequestFactory(), $this->configuration->getStreamFactory())
            ->willReturn($expectedRequestInterface);
        $payload = file_get_contents(__DIR__ . '/payloads/response.json');
        $responseInterface = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
        $this->service->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequestInterface)
            ->willReturn($responseInterface);

        $response = $this->service->handle($request);
        $this->assertEquals($response, UpsertUsersDataResponseFactory::fromJson(json_decode($payload)));
    }
}
