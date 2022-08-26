<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Common;

use Chargemap\InsiderSdk\Common\UserIdentifiers;
use Chargemap\InsiderSdk\InsiderApiClientException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Common\UserIdentifiers
 */
class UserIdentifiersTest extends TestCase
{
    public function testConstructThrowsWhenAllParametersAreNull(): void
    {
        $this->expectException(InsiderApiClientException::class);
        new UserIdentifiers(null, null, null, null);
    }

    public function testConstructThrowsWhenNoParametersPassed(): void
    {
        $this->expectException(InsiderApiClientException::class);
        new UserIdentifiers();
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testConstructorAndGetters(): void
    {
        $uuid = '12345';
        $email = 'example@example.com';
        $phoneNumber = '+3312345678';
        $custom = [
            'key' => 'value'
        ];
        $identifiers = new UserIdentifiers($uuid, $email, $phoneNumber, $custom);
        $this->assertSame($uuid, $identifiers->getUuid());
        $this->assertSame($email, $identifiers->getEmail());
        $this->assertSame($phoneNumber, $identifiers->getPhoneNumber());
        $this->assertSame($custom, $identifiers->getCustomIdentifiers());
    }

    public function testJsonSerializeWithAllParameters(): void
    {
        $uuid = '12345';
        $email = 'example@example.com';
        $phoneNumber = '+3312345678';
        $custom = [
            'key' => 'value'
        ];
        $identifiers = new UserIdentifiers($uuid, $email, $phoneNumber, $custom);

        $this->assertSame(json_encode([
            'uuid' => $uuid,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'custom' => $custom
        ]), json_encode($identifiers));
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testPartialJsonSerialize(): void
    {
        $uuid = '12345';
        $custom = [
            'key' => 'value'
        ];
        $identifiers = new UserIdentifiers($uuid, null, null, $custom);

        $this->assertSame(json_encode([
            'uuid' => $uuid,
            'custom' => $custom
        ]), json_encode($identifiers));
    }
}
