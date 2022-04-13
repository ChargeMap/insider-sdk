<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponse
 */
class UpsertUsersDataResponseTest extends TestCase
{
    public function testGetConstructorAndGetters(): void
    {
        $successfulCount = 123;
        $failCount = 321;
        $errors = ['key' => ['value1', 'value2']];
        $response = new UpsertUsersDataResponse($successfulCount, $failCount, $errors);
        $this->assertSame($successfulCount, $response->getSuccessfulCount());
        $this->assertSame($failCount, $response->getFailCount());
        $this->assertSame($errors, $response->getErrors());
    }
}
