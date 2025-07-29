<?php

namespace App\Traits;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

trait FirebaseSendNotification
{
    public static function send($token, $title, $body, $imageUrl = null)
    {
        if (!$token) return;
        $credentialsPath = storage_path('app/firebase_config.json');
        if (!file_exists($credentialsPath)) return;
        $credentialsArray = json_decode(file_get_contents($credentialsPath), true);
        $projectId = $credentialsArray['project_id'];
        $credentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/firebase.messaging',
            $credentialsArray
        );
        $accessToken = $credentials->fetchAuthToken()['access_token'];
        $message = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $imageUrl,
                ]
            ]
        ];
        Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $message);
    }
}
