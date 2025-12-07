<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostCommented extends Notification
{
    use Queueable;

    protected Post $post;
    protected PostComment $comment;

    public function __construct(Post $post, PostComment $comment)
    {
        $this->post    = $post;
        $this->comment = $comment;
    }

    /**
     * どのチャンネルで通知するか
     * 今回は DB 通知だけにする
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * database 通知に保存する中身
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'post_id'        => $this->post->id,
            'post_body'      => $this->post->body,
            'comment_id'     => $this->comment->id,
            'comment_body'   => $this->comment->comment,
            'from_user_id'   => $this->comment->user_id,
            'from_user_name' => $this->comment->user->nickname
                                ?? $this->comment->user->name,
        ];
    }
}
