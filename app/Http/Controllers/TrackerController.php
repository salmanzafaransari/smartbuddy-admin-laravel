<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use Illuminate\Http\Request;

class TrackerController extends Controller
{
    public function track(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|string|max:255',
            'chatbot_id' => 'required|string|max:255',
            'website'    => 'required|string|max:255',
            'page'       => 'required|string|max:255',
        ]);

        try {
            $user_id    = decrypt($validated['user_id']);
            $chatbot_id = decrypt($validated['chatbot_id']);

            $tracker = Tracker::updateOrCreate(
                [
                    'user_id'    => $user_id,
                    'chatbot_id' => $chatbot_id,
                    'page'       => $validated['page'],
                    'website'    => $validated['website'],
                ]
            );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving tracker',
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ], 500);
        }
    }

}
