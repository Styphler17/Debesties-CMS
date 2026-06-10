<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'seo_title',
        'meta_description',
        'focus_keyword',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image_id',
        'twitter_card',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
