<?php

namespace App\Events;

class UserCreatedEvent extends Event
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getName()
    {
        return 'user.created';
    }
}
