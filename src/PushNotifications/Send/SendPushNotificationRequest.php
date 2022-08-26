<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use Chargemap\InsiderSdk\InsiderApiHostType;
use Chargemap\InsiderSdk\InsiderApiRequest;
use JsonSerializable;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

class SendPushNotificationRequest implements InsiderApiRequest, JsonSerializable
{
    private PushNotification $notification;

    public function __construct(PushNotification $notification)
    {
        $this->notification = $notification;
    }

    public function getNotification(): PushNotification
    {
        return $this->notification;
    }

    public function getRequestInterface(RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory): RequestInterface
    {
        return $requestFactory->createRequest('POST', '/api/v2/notification/user')
            ->withHeader('Content-type', 'application/json')
            ->withBody($streamFactory->createStream(json_encode($this))
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'notifications' => [
                $this->notification
            ],
        ];
    }

    public function getHostType(): InsiderApiHostType
    {
        return InsiderApiHostType::MOBILE();
    }
}
