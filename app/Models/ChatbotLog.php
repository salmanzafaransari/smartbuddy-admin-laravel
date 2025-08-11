<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotLog extends Model
{
    protected $fillable = [
        'chatbot_id',
        'user_id',
        'response_time',
    ];

    public function chatbot()
    {
        return $this->belongsTo(Chatbot::class);
    }
}
