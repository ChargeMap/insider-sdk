<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use stdClass;

class InsiderAbstractFeatures
{
    protected InsiderApiConfiguration $configuration;
    protected ?ClientInterface $httpClient = null;
    protected ?RequestFactoryInterface $requestFactory = null;
    protected ?StreamFactoryInterface $streamFactory = null;
    protected ?UriFactoryInterface $uriFactory = null;

    public function __construct(InsiderApiConfiguration $configuration)
    {
        $this->configuration = $configuration;
        $this->httpClient = $configuration->getHttpClient();
        $this->requestFactory = $configuration->getRequestFactory();
        $this->streamFactory = $configuration->getStreamFactory();
        $this->uriFactory = $configuration->getUriFactory();
    }

    public function getConfiguration(): InsiderApiConfiguration
    {
        return $this->configuration;
    }

    /**
     * @throws InsiderApiException
     * @throws InsiderApiClientException
     */
    public function sendRequest(RequestInterface $request, InsiderApiHostType $hostType): ResponseInterface
    {
        // Retrieve host
        $host = $this->configuration->getHosts()[$hostType->getValue()] ?? null;

        if($host === null) {
            throw new InsiderApiClientException("Missing host in configuration for type : $hostType");
        }

        // Forge URI
        $URI = $request->getUri();

        // Build path and strip duplicate slash
        $path = DIRECTORY_SEPARATOR . $host->getPath() . DIRECTORY_SEPARATOR . $URI->getPath();
        $path = preg_replace('%/+%', '/', $path);

        $URI = $URI->withPath($path)
            ->withScheme($host->getScheme())
            ->withHost($host->getHost());

        try {
            $response = $this->httpClient->sendRequest(
                $request->withUri($URI)
                    ->withHeader('X-PARTNER-NAME', $host->getPartnerName())
                    ->withHeader('X-REQUEST-TOKEN', $host->getToken())
            );
        } catch (ClientExceptionInterface $e) {
            throw new InsiderApiClientException($e->getMessage());
        }

        if ($response->getStatusCode() === 403) {
            throw new InsiderApiException(InsiderApiErrorCode::UNKNOWN_TOKEN(), $response->getReasonPhrase());
        }

        if ($response->getStatusCode() === 404) {
            throw new InsiderApiException(InsiderApiErrorCode::NOT_FOUND(), $response->getReasonPhrase());
        }

        // Not okay responses are != than 2XX
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            // All others cases
            throw new InsiderApiException(InsiderApiErrorCode::API_CALL_FAILED(), "{$response->getReasonPhrase()} : {$response->getBody()->__toString()}", $response->getStatusCode());
        }

        return $response;
    }

    /**
     * @throws InsiderApiException
     */
    public static function asJson(ResponseInterface $response): ?stdClass
    {
        if ($response->getStatusCode() === 204) {
            return null;
        }

        $body = $response->getBody()->__toString();
        $json = json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = json_last_error_msg();
            throw new InsiderApiException(InsiderApiErrorCode::PARSE_API_RESPONSE_ERROR(), "$message : $body", json_last_error());
        }

        return $json;
    }
}
