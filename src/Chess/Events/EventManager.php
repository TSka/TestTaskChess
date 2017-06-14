<?php

namespace Chess\Events;

class EventManager implements ManagerInterface
{
    private $listeners;

    public function subscribe($eventType, $listener)
    {
        $this->listeners[$eventType][$listener];
    }

    public function unsubscribe($eventType, $listener)
    {
        foreach ($this->listeners[$eventType] as $key => $value) {
            if ($listener === $value) {
                unset($this->listeners[$eventType][$key]);
            }
        }
    }

    public function notify($eventType, $data)
    {
        foreach ($this->listeners[$eventType] as $listener) {
            call_user_func($listener, $data);
        }
    }
}