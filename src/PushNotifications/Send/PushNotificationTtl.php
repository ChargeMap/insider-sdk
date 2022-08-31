<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\PushNotifications\Send;

use MyCLabs\Enum\Enum;

/**
 * Expiration time of the push notification in seconds.
 *
 * @method static self ONE_DAY()
 * @method static self ONE_AND_A_HALF_DAY()
 * @method static self TWO_DAYS()
 */
class PushNotificationTtl extends Enum
{
    public const ONE_DAY = 86400;
    public const ONE_AND_A_HALF_DAY = 129600;
    public const TWO_DAYS = 172800;
}
