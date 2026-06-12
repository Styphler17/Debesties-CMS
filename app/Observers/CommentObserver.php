<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Comment;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        if ($comment->status === 'pending') {
            ActivityLog::create([
                'user_id' => $comment->user_id,
                'action' => 'comment.pending',
                'model_type' => Comment::class,
                'model_id' => $comment->id,
                'details' => [
                    'body' => substr($comment->body, 0, 100),
                    'post_id' => $comment->post_id,
                ],
            ]);
        }
    }

    public function updated(Comment $comment): void
    {
        //
    }

    public function deleted(Comment $comment): void
    {
        //
    }
}
