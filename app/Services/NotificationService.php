<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public function notify(
        User $user,
        string $type,
        string $title,
        string $body,
        ?string $url = null
    ): Notification {
        return Notification::create([
            'user_id'   => $user->id,
            'type'      => $type,
            'title'     => $title,
            'body'      => $body,
            'action_url'=> $url,
            'is_read'   => false,
        ]);
    }
}