<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TalentPostedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $post
    ) {}

    // DB通知のみ
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'talent_posted',
            'post_id' => $this->post->id,
            'title' => '新しい投稿',
            'message' => $this->post->user->name . ' さんが新しい投稿をしました',
        ];
    }
}
