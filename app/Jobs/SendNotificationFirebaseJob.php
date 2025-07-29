<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\FirebaseSendNotification;

class SendNotificationFirebaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    public $tokens;
    public $title;
    public $body;
    public $imageUrl;

    public function __construct($tokens, $title, $body, $imageUrl = null)
    {
        $this->tokens = $tokens;
        $this->title = $title;
        $this->body = $body;
        $this->imageUrl = $imageUrl;
    }

    public function handle(): void
    {
            if (!is_array($this->tokens) || empty($this->tokens)) {
                return;
            }
        
            foreach ($this->tokens as $token) {
                FirebaseSendNotification::send($token, $this->title, $this->body, $this->imageUrl);
            }
    }
}
