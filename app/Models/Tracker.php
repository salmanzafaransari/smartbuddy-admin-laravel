<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'chatbot_id', 'user_id', 'website', 'page',
    ];
}
