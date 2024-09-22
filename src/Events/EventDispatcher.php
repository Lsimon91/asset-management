<?php

namespace App\Events;

class EventDispatcher
{
    private $listeners = [];

    public function addListener($eventName, $listener)
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(Event $event)
    {
        $eventName = $event->getName();
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listener) {
                call_user_func($listener, $event);
            }
        }
    }
}
