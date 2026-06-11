<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'file_url',
        'mime_type',
        'file_size',
        'alt_text',
        'caption',
        'title',
        'folder',
        'width',
        'height',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
