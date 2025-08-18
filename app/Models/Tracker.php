<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'chatbot_id', 'user_id', 'website', 'page',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chatbots()
    {
        return $this->belongsTo(Chatbot::class, 'chatbot_id');
    }
}
