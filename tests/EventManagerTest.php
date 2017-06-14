<?php

namespace tests;

use Chess\Events\EventManager;
use PHPUnit\Framework\TestCase;

class EventManagerTest extends TestCase
{
    public function testEvents()
    {
        $events = new EventManager();
        $eventName = 'test_event';
        $data = sha1(rand(0, 100));

        $listener = $this->createPartialMock(\StdCLass::class, ['__invoke']);
        $listener
            ->expects(self::once())
            ->method('__invoke')
            ->with($data);

        $events->subscribe($eventName, $listener);
        $events->notify($eventName, $data);
        $events->unsubscribe($eventName, $listener);
        $events->notify($eventName, $data);
    }
}