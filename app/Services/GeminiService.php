<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.0-flash:generateContent?key=';
    }

    public function ask(string $prompt): string
    {
        if (!$prompt) {
            return 'No prompt provided.';
        }

        // Get chat history from session (Laravel session helper)
        $history = Session::get('chat_history', []);

        // Add user's message
        $history[] = [
            'role' => 'user',
            'parts' => [['text' => $prompt]]
        ];

        // Send request to Gemini API
        $response = Http::post($this->baseUrl . $this->apiKey, [
            'contents' => $history,
        ]);

        if (!$response->successful()) {
            return 'Something Went Wrong: ' . $response->status();
        }

        $json = $response->json();

        $answer = $json['candidates'][0]['content']['parts'][0]['text'] ?? 'No answer found.';

        // Add model's response to chat history
        $history[] = [
            'role' => 'model',
            'parts' => [['text' => $answer]]
        ];

        // Save updated history back to session
        Session::put('chat_history', $history);

        return $answer;
    }

    // Optional method to clear chat history
    public function reset()
    {
        Session::forget('chat_history');
    }


}
