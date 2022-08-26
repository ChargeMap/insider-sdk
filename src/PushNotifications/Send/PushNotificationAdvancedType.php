<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use MyCLabs\Enum\Enum;

/**
 * @method static self CAROUSEL()
 * @method static self SLIDER()
 */
class PushNotificationAdvancedType extends Enum
{
    public const CAROUSEL = 'CAROUSEL';
    public const SLIDER = 'SLIDER';
}
