
<?php

namespace App\Notifications;

abstract class Notification
{
    abstract public function toMail($notifiable);
    abstract public function toDatabase($notifiable);
}