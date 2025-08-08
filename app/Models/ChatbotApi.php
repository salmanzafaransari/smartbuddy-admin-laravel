<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotApi extends Model
{
   protected $fillable = ['chatbot_id', 'access_token', 'provider', 'prompt_template'];

    public function chatbot()
    {
        return $this->belongsTo(Chatbot::class);
    }
}
