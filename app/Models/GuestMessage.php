<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message'
    ];
}
