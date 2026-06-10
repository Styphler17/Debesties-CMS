<?php

namespace App\Models;

use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'published_at'  => 'datetime',
        'scheduled_for' => 'datetime',
        'faq'           => 'array',
        'sources'       => 'array',
        'key_facts'     => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function meta()
    {
        return $this->hasOne(PostMeta::class);
    }

    public function featuredImage()
    {
        return $this->belongsTo(\App\Models\Media::class, 'featured_image_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
