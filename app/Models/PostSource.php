<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSource extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'title', 'url', 'order'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
