<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use MyCLabs\Enum\Enum;

/**
 * @method static self PARSE_API_RESPONSE_ERROR()
 * @method static self API_CALL_FAILED()
 * @method static self INVALID_ARGUMENT_RECEIVED()
 * @method static self UNKNOWN_TOKEN()
 * @method static self BAD_REQUEST()
 * @method static self NOT_FOUND()
 * @method static self CONFLICT()
 */
class InsiderApiErrorCode extends Enum
{
    public const PARSE_API_RESPONSE_ERROR = 'PARSE_API_RESPONSE_ERROR';
    public const API_CALL_FAILED = 'API_CALL_FAILED';
    public const INVALID_ARGUMENT_RECEIVED = 'INVALID_ARGUMENT_RECEIVED';
    public const UNKNOWN_TOKEN = 'UNKNOWN_TOKEN';
    public const BAD_REQUEST = 'BAD_REQUEST';
    public const NOT_FOUND = 'NOT_FOUND';
    public const CONFLICT = 'CONFLICT';
}
