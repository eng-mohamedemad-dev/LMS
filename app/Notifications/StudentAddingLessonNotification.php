<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class StudentAddingLessonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $title,
        public $body,
        public $imageUrl = null
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'body' => $this->body,
            'image' => $this->imageUrl,
        ];
    }
}
