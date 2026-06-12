<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrawlerLog extends Model
{
    use HasFactory;

    protected $fillable = ['bot_name', 'user_agent', 'ip_address', 'path', 'status_code'];
}
