<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk;

use Exception;
use Throwable;

class InsiderApiException extends Exception
{
    private InsiderApiErrorCode $internalErrorCode;

    public function __construct(InsiderApiErrorCode $internalErrorCode, string $message, int $code = 0, Throwable $previous = null)
    {
        $this->internalErrorCode = $internalErrorCode;
        parent::__construct($message, $code, $previous);
    }

    public function getInternalErrorCode(): InsiderApiErrorCode
    {
        return $this->internalErrorCode;
    }
}
