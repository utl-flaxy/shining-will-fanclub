<?php

namespace App\Notifications;

use App\Models\PostComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CommentPostedNotification extends Notification
{
    use Queueable;

    /**
     * @var \App\Models\PostComment
     */
    public PostComment $comment;

    /**
     * コンストラクタ
     */
    public function __construct(PostComment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * 通知チャネル
     */
    public function via(object $notifiable): array
    {
        // まずは DB 通知だけ
        return ['database'];
    }

    /**
     * DB に保存するデータ
     */
    public function toDatabase(object $notifiable): array
    {
        $post   = $this->comment->post;
        $author = $this->comment->user;

        return [
            'comment_id'      => $this->comment->id,
            'post_id'         => $post?->id,
            'post_body'       => $post ? Str::limit((string) $post->body, 50) : null,
            'comment_body'    => Str::limit((string) $this->comment->comment, 50),
            'from_user_id'    => $author?->id,
            'from_user_name'  => $author->nickname ?? $author?->name,
            'created_at_text' => $this->comment->created_at?->diffForHumans(),
        ];
    }
}
