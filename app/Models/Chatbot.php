<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $fillable = [
        'user_id', 'name', 'type', 'chatbot_photo', 'source_file', 'extracted_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
