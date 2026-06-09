<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostRelated extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'related_post_id', 'order'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function relatedPost()
    {
        return $this->belongsTo(Post::class, 'related_post_id');
    }
}
