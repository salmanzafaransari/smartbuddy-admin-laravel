<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'chatbot_photo',
        'chatbot_photo_public_id',
        'source_file',
        'source_file_public_id',
        'extracted_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function api()
    {
        return $this->hasOne(ChatbotApi::class);
    }
    public function logs()
    {
        return $this->hasMany(ChatbotLog::class);
    }
    public function preference()
    {
        return $this->hasOne(ChatbotPreference::class);
    }
}
