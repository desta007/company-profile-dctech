<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
        'video_link',
        'count_client',
        'count_project',
        'count_year_of_experience',
        'count_award'
    ];
}
