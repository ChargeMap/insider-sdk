<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users\Upsert;

use Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponseFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\Upsert\UpsertUsersDataResponseFactory
 */
class UpsertUsersDataResponseFactoryTest extends TestCase
{
    public function testFromJson(): void
    {
        $json = json_decode(file_get_contents(__DIR__ . '/payloads/response.json'));
        $response = UpsertUsersDataResponseFactory::fromJson($json);
        $this->assertSame(123, $response->getSuccessfulCount());
        $this->assertSame(1, $response->getFailCount());
        $this->assertSame([
            'users.0.identifiers.value[*].regexp(^\+[1-9]\d{5,15}$)' => ['invalid phone number: 11111111']
        ], $response->getErrors());
    }
}
