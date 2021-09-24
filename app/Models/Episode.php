<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'anime_id',
        'rating',
        'video',
    ];
}
