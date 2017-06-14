<?php

namespace Chess\Events;

interface ManagerInterface
{
    public function subscribe($eventType, $listener);

    public function unsubscribe($eventType, $listener);

    public function notify($eventType, $data);
}