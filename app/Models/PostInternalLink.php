<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostInternalLink extends Model
{
    use HasFactory;

    protected $table = 'post_internal_links';

    protected $fillable = ['post_id', 'anchor_text', 'target_url', 'sort_order'];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
