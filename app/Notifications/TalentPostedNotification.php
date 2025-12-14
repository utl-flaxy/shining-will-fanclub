<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TalentPostedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public mixed $post
    ) {}

    /**
     * 通知チャンネル
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * DB保存用データ
     */
    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'talent_posted',
            'post_id' => $this->post->id,
            'title' => '新しい投稿',
            'message' => $this->post->user->name . ' さんが新しい投稿をしました',
        ];
    }
}
