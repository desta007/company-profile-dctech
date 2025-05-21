<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'fullname',
        'position',
        'photo',
        'linkedin_account',
        'facebook_account',
        'instagram_account',
        'twitter_account'
    ];
}
