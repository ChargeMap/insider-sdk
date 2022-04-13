<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\InsiderApiClientException;
use Chargemap\InsiderSdk\Users\Attributes;
use Chargemap\InsiderSdk\Users\Event;
use Chargemap\InsiderSdk\Users\User;
use Chargemap\InsiderSdk\Users\UserIdentifiers;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\User
 */
class UserTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $identifiers = $this->createMock(UserIdentifiers::class);
        $attributes = $this->createMock(Attributes::class);
        $user = new User($identifiers, $attributes);

        $this->assertSame($identifiers, $user->getIdentifiers());
        $this->assertSame($attributes, $user->getAttributes());
        $this->assertNull($user->getEvents());

        $events = [
            $this->getEvent(),
            $this->getEvent()
        ];

        foreach ($events as $event) {
            $user = $user->withEvent($event);
        }

        $this->assertSame($events, $user->getEvents());
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testJsonSerializeWithAllParameters(): void
    {
        $identifiers = new UserIdentifiers(
            '12345',
            'example@example.com',
            '+3312345678', [
                'key' => 'value'
            ]
        );

        $attributes = new Attributes(
            'example@example.com',
            '+3312345678',
            true,
            false,
            true,
            'Some Name',
            'Some Surname',
            new DateTime('2022-12-18T09:12:35'),
            'Female',
            'EN',
            'UK',
            'London',
        );
        foreach ([1, 2, 3] as $i) {
            $attributes = $attributes->withListId($i);
        }
        foreach (['key' => 'value', 'key2' => 'value2'] as $key => $value) {
            $attributes = $attributes->withCustomAttribute($key, $value);
        }
        $user = new User($identifiers, $attributes);

        $events = [$this->getEvent(), $this->getEvent()];

        foreach ($events as $event) {
            $user = $user->withEvent($event);
        }

        $this->assertSame(json_encode([
            'identifiers' => $identifiers,
            'attributes' => $attributes,
            'events' => $events,
        ]), json_encode($user));
    }

    /**
     * @throws InsiderApiClientException
     */
    public function testPartialJsonSerialize(): void
    {
        $identifiers = new UserIdentifiers(
            '12345',
            'example@example.com',
            '+3312345678', [
                'key' => 'value'
            ]
        );

        $user = new User($identifiers);

        $this->assertSame(json_encode([
            'identifiers' => $identifiers,
        ]), json_encode($user));
    }

    public function getEvent(): Event
    {
        return (new Event('event_name', new DateTime()));
    }
}
