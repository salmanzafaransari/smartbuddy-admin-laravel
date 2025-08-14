<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotPreference extends Model
{
    protected $fillable = [
        'chatbot_id', 'primary_color', 'user_bubble', 'bot_bubble',
        'user_text_color', 'bot_text_color', 'position_x', 'position_y',
        'offset_x', 'offset_y', 'theme', 'bubble_pattern', 'background_pattern'
    ];

    public function chatbot()
    {
        return $this->belongsTo(Chatbot::class);
    }
}
