<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'rating',
        'episodes_num',
        'episode_duration',
        'categories',
        'image',
        'completed',
        'year_of_release',
        'studio',
        'age_class',
    ];

}
