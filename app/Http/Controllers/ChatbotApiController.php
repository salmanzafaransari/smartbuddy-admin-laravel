<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GeminiService;
use App\Models\Chatbot;
use App\Models\ChatbotApi;

class ChatbotApiController extends Controller
{
   public function ask(Request $request, GeminiService $gemini)
    {
        // Get token from Authorization header
        $authHeader = $request->header('Authorization');

        // If using "Bearer <token>"
        if (str_starts_with($authHeader, 'Bearer ')) {
            $access_token = substr($authHeader, 7); // remove "Bearer "
        } else {
            abort(401, 'Invalid authorization header.');
        }

        $api = ChatbotApi::with('chatbot')
            ->where('access_token', $access_token)
            ->firstOrFail();

        $question = $request->input('question');

        $prompt = ($api->prompt_template ?: "You are a helpful assistant. Answer based on the document below.") . "\n\n";
        $prompt .= $api->chatbot->extracted_text . "\n\n";
        $prompt .= "Question: " . $question;

        $answer = $gemini->ask($prompt);

        return response()->json([
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    public function generateToken($id)
    {
        $chatbot = Chatbot::findOrFail($id);

        // Generate md5 hash based on UUID + current timestamp
        $raw = Str::uuid() . now();
        $hash = md5($raw);

        // Add prefix
        $token = 'smartbuddy-' . $hash;

        // If token exists, update it
        if ($chatbot->api) {
            $chatbot->api->update([
                'access_token' => $token,
            ]);

            return response()->json([
                'message' => 'Access token regenerated successfully.',
                'access_token' => $token,
            ]);
        }

        // Else, create new token
        $api = ChatbotApi::create([
            'chatbot_id' => $chatbot->id,
            'access_token' => $token,
            'prompt_template' => "Your name is ".$chatbot->name . ", a smart AI Asistent. you need to answers from " .$chatbot->type. " type question only from document below. and never let user know that you are answring from the document.",
            'provider' => 'gemini',
        ]);

        return response()->json([
            'message' => 'Access token generated successfully.',
            'access_token' => $token,
        ]);
    }
}
