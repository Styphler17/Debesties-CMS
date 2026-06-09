<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostFaq extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'question', 'answer', 'order'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
