<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @method ClientInterface|null getHttpClient()
 * @method RequestFactoryInterface|null getRequestFactory()
 * @method StreamFactoryInterface|null getStreamFactory()
 * @method UriFactoryInterface|null getUriFactory()
 * @method InsiderApiHost[] getHosts()
 */
class InsiderApiConfiguration
{
    /** @var InsiderApiHost[]  */
    private array $hosts = [];
    protected ClientInterface $httpClient;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;
    protected UriFactoryInterface $uriFactory;
    protected bool $built = false;

    public static function builder(): self
    {
        return new self();
    }

    public function build(): self
    {
        $this->requestFactory = $this->requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $this->streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
        $this->uriFactory = $this->uriFactory ?? Psr17FactoryDiscovery::findUriFactory();
        $this->httpClient = $this->httpClient ?? Psr18ClientDiscovery::find();

        $this->built = true;
        return $this;
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws InsiderApiClientException
     */
    public function __call($name, $arguments)
    {
        if (!$this->built) {
            throw new InsiderApiClientException("Cannot use client before building it");
        }

        $methodName = '_' . $name;
        if (!method_exists($this, $methodName)) {
            throw new InsiderApiClientException("Method does not exists");
        }

        return call_user_func_array(array($this, $methodName), $arguments);
    }

    /**
     * @return InsiderApiHost[]
     */
    protected function _getHosts(): array
    {
        return $this->hosts;
    }

    protected function _getHttpClient(): ?ClientInterface
    {
        return $this->httpClient;
    }

    protected function _getRequestFactory(): ?RequestFactoryInterface
    {
        return $this->requestFactory;
    }

    protected function _getStreamFactory(): ?StreamFactoryInterface
    {
        return $this->streamFactory;
    }

    protected function _getUriFactory(): ?UriFactoryInterface
    {
        return $this->uriFactory;
    }

    public function withUnificationHost(InsiderApiHost $unificationHost): self
    {
        $return = clone $this;
        $return->hosts[InsiderApiHostType::UNIFICATION] = $unificationHost;
        return $return;
    }

    public function withMobileHost(InsiderApiHost $mobileHost): self
    {
        $return = clone $this;
        $return->hosts[InsiderApiHostType::MOBILE] = $mobileHost;
        return $return;
    }

    public function withHttpClient(ClientInterface $httpClient): self
    {
        $return = clone $this;
        $return->httpClient = $httpClient;
        return $return;
    }

    public function withRequestFactory(RequestFactoryInterface $requestFactory): self
    {
        $return = clone $this;
        $return->requestFactory = $requestFactory;
        return $return;
    }

    public function withStreamFactory(StreamFactoryInterface $streamFactory): self
    {
        $return = clone $this;
        $return->streamFactory = $streamFactory;
        return $return;
    }

    public function withUriFactory(UriFactoryInterface $uriFactory): self
    {
        $return = clone $this;
        $return->uriFactory = $uriFactory;
        return $return;
    }
}
