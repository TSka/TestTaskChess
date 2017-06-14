<?php

namespace Chess\Events;

class EventManager implements ManagerInterface
{
    private $listeners;

    /**
     * Subscribe manager
     *
     * @param $eventType
     * @param $listener
     */
    public function subscribe($eventType, $listener)
    {
        $this->listeners[$eventType][$listener];
    }

    /**
     * Unsubscribe manager
     *
     * @param $eventType
     * @param $listener
     */
    public function unsubscribe($eventType, $listener)
    {
        foreach ($this->listeners[$eventType] as $key => $value) {
            if ($listener === $value) {
                unset($this->listeners[$eventType][$key]);
            }
        }
    }

    /**
     * Notify
     *
     * @param $eventType
     * @param $data
     */
    public function notify($eventType, $data)
    {
        foreach ($this->listeners[$eventType] as $listener) {
            call_user_func($listener, $data);
        }
    }
}