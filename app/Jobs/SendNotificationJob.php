<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\SendNotifications;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $notifiables;
    public $notificationClass;
    public $title;
    public $body;
    public $imageUrl;

    public function __construct($notifiables, $notificationClass, $title, $body, $imageUrl = null)
    {
        $this->notifiables = $notifiables;
        $this->notificationClass = $notificationClass;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
    }

    public function handle(): void
    {
        if($this->notifiables->isNotEmpty()) {
        foreach ($this->notifiables as $user) {
                SendNotifications::send($user, $this->notificationClass, $this->title, $this->body, $this->imageUrl);
            }
        }
    }
}
