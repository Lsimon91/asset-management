<?php

namespace App\Notifications;

use App\Mail\Mailer;

class NotificationService
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($notifiable, Notification $notification)
    {
        $this->sendMail($notifiable, $notification);
        $this->saveToDatabase($notifiable, $notification);
    }

    private function sendMail($notifiable, Notification $notification)
    {
        $mailData = $notification->toMail($notifiable);
        $this->mailer->send($notifiable->email, $mailData['subject'], $mailData['body']);
    }

    private function saveToDatabase($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);
        // Aquí implementarías la lógica para guardar la notificación en la base de datos
    }
}
