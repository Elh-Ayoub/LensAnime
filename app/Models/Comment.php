<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'author',
        'content',
        'anime_id',
        'episode_id',
        'comment_id',
        'status',
        'rating',
    ];
}
