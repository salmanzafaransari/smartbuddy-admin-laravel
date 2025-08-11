<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\GeminiService;
use App\Models\Chatbot;
use App\Models\ChatbotApi;
use App\Models\ChatbotLog;

class ChatbotApiController extends Controller
{
    public function ask(Request $request, GeminiService $gemini)
    {
        $startTime = microtime(true);

        // Get token from Authorization header
        $authHeader = $request->header('Authorization');

        if (str_starts_with($authHeader, 'Bearer ')) {
            $access_token = substr($authHeader, 7);
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

        $responseTime = round((microtime(true) - $startTime) * 1000); // ms

        // Insert log
        ChatbotLog::create([
            'chatbot_id'    => $api->chatbot_id, // from $api, not $request
            'user_id'       => $api->chatbot->user_id,
            'response_time' => $responseTime
        ]);

        return response()->json([
            'question' => $question,
            'answer' => $answer,
            'response_time' => $responseTime
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
            'prompt_template' => "You are {$chatbot->name}, a smart AI assistant for a '{$chatbot->type}' business. 
                                You already know all relevant details about this business as part of your own expertise. 
                                Never mention, hint at, or imply that your knowledge comes from any external source, document, file, or text. 
                                Always answer confidently as if the knowledge is your own. 
                                Only answer questions that are relevant to '{$chatbot->type}'. 
                                If the question is off-topic, politely say you can only answer '{$chatbot->type}' related questions. 
                                If a user gives a compliment, respond with appreciation in a warm and friendly tone.",

            'provider' => 'gemini',
        ]);

        return response()->json([
            'message' => 'Access token generated successfully.',
            'access_token' => $token,
        ]);
    }
}
