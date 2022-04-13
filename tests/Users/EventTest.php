<?php

declare(strict_types=1);

namespace Tests\Chargemap\InsiderSdk\Users;

use Chargemap\InsiderSdk\Users\Event;
use Chargemap\InsiderSdk\Users\EventParams;
use DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\InsiderSdk\Users\Event
 */
class EventTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $name = 'name';
        $timestamp = new DateTime();
        $event = new Event($name, $timestamp);
        $this->assertSame($name, $event->getName());
        $this->assertSame($timestamp, $event->getTimestamp());
        $this->assertNull($event->getParams());

        $params = $this->createMock(EventParams::class);
        $event = new Event($name, $timestamp, $params);
        $this->assertSame($params, $event->getParams());
    }

    public function testJsonSerializeWithAllParameters(): void
    {
        $name = 'name';
        $timestamp = new DateTime();
        $params = $this->getEventParams();
        $event = new Event($name, $timestamp, $params);
        $this->assertSame(json_encode([
            'event_name' => $name,
            'timestamp' => $timestamp->format('Y-m-d\TH:i:s\Z'),
            'event_params' => $params
        ]), json_encode($event));
    }

    public function testPartialJsonSerialize(): void
    {
        $name = 'name';
        $timestamp = new DateTime();
        $event = new Event($name, $timestamp);
        $this->assertSame(json_encode([
            'event_name' => $name,
            'timestamp' => $timestamp->format('Y-m-d\TH:i:s\Z'),
        ]), json_encode($event));
    }

    public function getEventParams(): EventParams
    {
        return new EventParams(
            '123',
            '321',
            'product name'
        );
    }
}
