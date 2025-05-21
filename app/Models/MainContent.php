<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainContent extends Model
{
    protected $fillable = [
        'start_video_link',
        'mission_description',
        'mission_image',
        'plan_description',
        'plan_image',
        'vision_description',
        'vision_image'
    ];
}
