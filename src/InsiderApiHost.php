<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

class InsiderApiHost
{
    private string $scheme;
    private string $host;
    private string $path;
    private string $token;
    private ?string $partnerName;

    public function __construct(
        string $scheme,
        string $host,
        string $path,
        string $token,
        ?string $partnerName = null
    )
    {
        $this->scheme = $scheme;
        $this->host = $host;
        $this->path = $path;
        $this->token = $token;
        $this->partnerName = $partnerName;
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getPartnerName(): ?string
    {
        return $this->partnerName;
    }
}
