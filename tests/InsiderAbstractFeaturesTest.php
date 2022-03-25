<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk;

use Chargemap\InsiderSdk\InsiderAbstractFeatures;
use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\InsiderApiConfiguration;
use Chargemap\InsiderSdk\InsiderApiErrorCode;
use Chargemap\InsiderSdk\InsiderApiException;
use Chargemap\InsiderSdk\InsiderApiHost;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * @covers \Chargemap\InsiderSdk\InsiderAbstractFeatures
 */
class InsiderAbstractFeaturesTest extends TestCase
{
    private InsiderApiConfiguration $configuration;
    private InsiderApiHost $host;
    private ClientInterface $client;
    private InsiderAbstractFeatures $abstractFeatures;

    protected function setUp(): void
    {
        $this->configuration = InsiderApiConfiguration::builder(
            $this->host = $this->createConfiguredMock(InsiderApiHost::class, [
                'getScheme' => 'https',
                'getHost' => 'example.com',
                'getPath' => '/host/path',
                'getToken' => 'someToken',
                'getPartnerName' => 'partnerName',
            ])
        )->withHttpClient(
            $this->client = $this->createMock(ClientInterface::class)
        )->build();
        $this->abstractFeatures = new InsiderAbstractFeatures($this->configuration);
    }

    public function sendRequestForgesCorrectUriProvider(): iterable
    {
        yield 'correct by default' => [
            '/api/v1', '/upsert', '/api/v1/upsert'
        ];
        yield 'no leading slash in host path' => [
            'api/v1', '/upsert', '/api/v1/upsert'
        ];
        yield 'no leading slash in request path' => [
            '/api/v1', 'upsert', '/api/v1/upsert'
        ];
        yield 'no leading slash at all' => [
            'api/v1', 'upsert', '/api/v1/upsert'
        ];
        yield 'leading and trailing slashes' => [
            '/api/v1/', '/upsert/', '/api/v1/upsert/'
        ];
    }

    /**
     * @dataProvider sendRequestForgesCorrectUriProvider
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testSendRequestForgesCorrectUri(string $hostPath, string $requestPath, string $expectedPath): void
    {
        //Reconfigure insider api host for this test only
        $this->host = $this->createConfiguredMock(InsiderApiHost::class, [
            'getScheme' => 'https',
            'getHost' => 'example.com',
            'getPath' => $hostPath,
            'getToken' => 'someToken',
            'getPartnerName' => 'partnerName',
        ]);
        $this->configuration = $this->configuration->withHost($this->host);
        $this->abstractFeatures = new InsiderAbstractFeatures($this->configuration);

        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', $requestPath)
            ->withHeader('Content-type', 'application/json');

        $expectedRequest = $request
            ->withUri(
                Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com' . $expectedPath)
            )->withHeader('X-PARTNER-NAME', 'partnerName')
            ->withHeader('X-REQUEST-TOKEN', 'someToken');

        $this->client->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequest)
            ->willReturn(Psr17FactoryDiscovery::findResponseFactory()->createResponse(200));

        $this->abstractFeatures->sendRequest($request);
    }

    /**
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testSendRequestCatchesClientException(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '')
            ->withHeader('Content-type', 'application/json');

        $expectedRequest = $request
            ->withUri(Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/host/path/'))
            ->withHeader('X-PARTNER-NAME', 'partnerName')
            ->withHeader('X-REQUEST-TOKEN', 'someToken');

        $this->client->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequest)
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->expectException(InsiderApiClientException::class);

        $this->abstractFeatures->sendRequest($request);
    }

    /**
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testSendRequestHandles403(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '')
            ->withHeader('Content-type', 'application/json');

        $expectedRequest = $request
            ->withUri(Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/host/path/'))
            ->withHeader('X-PARTNER-NAME', 'partnerName')
            ->withHeader('X-REQUEST-TOKEN', 'someToken');

        $this->client->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequest)
            ->willReturn(Psr17FactoryDiscovery::findResponseFactory()->createResponse(403, 'Forbidden'));

        $this->expectExceptionObject(new InsiderApiException(InsiderApiErrorCode::UNKNOWN_TOKEN(), 'Forbidden'));

        $this->abstractFeatures->sendRequest($request);
    }

    /**
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testSendRequestHandles404(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '')
            ->withHeader('Content-type', 'application/json');

        $expectedRequest = $request
            ->withUri(Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/host/path/'))
            ->withHeader('X-PARTNER-NAME', 'partnerName')
            ->withHeader('X-REQUEST-TOKEN', 'someToken');

        $this->client->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequest)
            ->willReturn(Psr17FactoryDiscovery::findResponseFactory()->createResponse(404, 'Not Found'));

        $this->expectExceptionObject(new InsiderApiException(InsiderApiErrorCode::NOT_FOUND(), 'Not Found'));

        $this->abstractFeatures->sendRequest($request);
    }

    /**
     * @throws InsiderApiClientException
     * @throws InsiderApiException
     */
    public function testSendRequestHandlesAnyOtherError(): void
    {
        $request = Psr17FactoryDiscovery::findRequestFactory()
            ->createRequest('POST', '')
            ->withHeader('Content-type', 'application/json');

        $expectedRequest = $request
            ->withUri(Psr17FactoryDiscovery::findUriFactory()->createUri('https://example.com/host/path/'))
            ->withHeader('X-PARTNER-NAME', 'partnerName')
            ->withHeader('X-REQUEST-TOKEN', 'someToken');

        $this->client->expects(self::once())
            ->method('sendRequest')
            ->with($expectedRequest)
            ->willReturn(Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(500, 'Internal Error')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{"error": "some error"}'))
            );

        $this->expectExceptionObject(new InsiderApiException(InsiderApiErrorCode::API_CALL_FAILED(), 'Internal Error : {"error": "some error"}', 500));

        $this->abstractFeatures->sendRequest($request);
    }

    /**
     * @throws InsiderApiException
     */
    public function testAsJsonReturnsNullIf204(): void
    {
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(204);

        $this->assertNull(InsiderAbstractFeatures::asJson($response));
    }

    /**
     * @throws InsiderApiException
     */
    public function testAsJsonThrowsOnInvalidJson(): void
    {
        $payload = 'Some string';
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $this->expectExceptionObject(new InsiderApiException(InsiderApiErrorCode::PARSE_API_RESPONSE_ERROR(), 'Syntax error : Some string', JSON_ERROR_SYNTAX));

        InsiderAbstractFeatures::asJson($response);
    }

    /**
     * @throws InsiderApiException
     */
    public function testAsJsonParsesJson(): void
    {
        $payload = '{"key":"value"}';
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $json = InsiderAbstractFeatures::asJson($response);
        $this->assertSame($payload, json_encode($json));
    }
}
