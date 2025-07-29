<?php

namespace App\Traits;

trait SendNotifications
{
    public static function send($notifiable, $notificationClass, $title, $body, $imageUrl = null)
    {
        $notification = new $notificationClass($title, $body, $imageUrl);
        $notifiable->notify($notification);
    }
}
