<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'name',
        'email',
        'comment',
        'status',
        'parent_id',
        'author_name',
        'author_email',
        'author_url',
        'content',
        'body'
    ];

    public function getBodyAttribute()
    {
        return $this->attributes['comment'] ?? null;
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['comment'] = $value;
    }

    public function getContentAttribute()
    {
        return $this->attributes['comment'] ?? null;
    }

    public function setContentAttribute($value)
    {
        $this->attributes['comment'] = $value;
    }

    public function getAuthorNameAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setAuthorNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    public function getAuthorEmailAttribute()
    {
        return $this->attributes['email'] ?? null;
    }

    public function setAuthorEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
