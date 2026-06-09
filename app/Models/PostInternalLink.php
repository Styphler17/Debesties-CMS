<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInternalLink extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'target_post_id', 'anchor_text', 'url'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function targetPost()
    {
        return $this->belongsTo(Post::class, 'target_post_id');
    }
}
