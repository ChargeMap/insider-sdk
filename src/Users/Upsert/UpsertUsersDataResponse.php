<?php

declare(strict_types=1);

namespace Chargemap\InsiderSdk\Users\Upsert;

class UpsertUsersDataResponse
{
    private int $successfulCount;
    private int $failCount;
    private array $errors;

    public function __construct(int $successfulCount, int $failCount, array $errors)
    {
        $this->successfulCount = $successfulCount;
        $this->failCount = $failCount;
        $this->errors = $errors;
    }

    public function getSuccessfulCount(): int
    {
        return $this->successfulCount;
    }

    public function getFailCount(): int
    {
        return $this->failCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
