<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use MyCLabs\Enum\Enum;

/**
 * @method static self UNIFICATION()
 * @method static self MOBILE()
 */
class InsiderApiHostType extends Enum
{
    public const UNIFICATION = 'UNIFICATION';
    public const MOBILE = 'MOBILE';
}
