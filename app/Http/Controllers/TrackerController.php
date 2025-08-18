<?php

namespace App\Http\Controllers;

use App\Models\Tracker;
use App\Models\Chatbot;
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

    public function trackerList()
    {
        $tracker = Tracker::with([
            'chatbots:id,name',
            'users:id,first_name,last_name'
        ])
        ->selectRaw('
            MIN(id) as id,
            chatbot_id,
            website,
            MIN(user_id) as user_id,
            COUNT(page) as total_pages,
            MIN(created_at) as created_at
        ')
        ->groupBy('chatbot_id', 'website')
        ->get();


        return response()->json([
            'data' => $tracker
        ]);
    }
    public function trackerCount()
    {
        $count = Tracker::with([
            'chatbots:id,name',
            'users:id,first_name,last_name'
        ])
        ->select('chatbot_id', 'website')
        ->selectRaw('MIN(id) as id, MIN(chatbot_id) as chatbot_id, COUNT(page) as total_pages, MIN(created_at) as created_at')
        ->groupBy('chatbot_id', 'website')
        ->get()->count();
        return response()->json([
            'totalTrackerCount' => $count
        ]);
    }

    public function trackerDetails($chatbotId)
    {
        // $trackers = Tracker::with(['chatbots'])
        //     ->where('chatbot_id', $chatbotId)
        //     ->get();

        // return response()->json([
        //     'data' => $trackers
        // ]);

        // Get chatbot with minimal fields (no relations needed)
        $chatbot = Chatbot::select([
                'id',
                'user_id', 
                'name',
                'type',
                'chatbot_photo',
                'source_file',
                'created_at',
                'updated_at'
            ])
            ->findOrFail($chatbotId);

        // Get trackers with only the needed fields
        $trackers = Tracker::select([
                'id',
                'user_id',
                'chatbot_id',
                'website',
                'page',
                'created_at'
            ])
            ->where('chatbot_id', $chatbotId)
            ->get();
        
        $html = view('admin.tracker-details', compact('chatbot', 'trackers'))->render();

        return response()->json([
            'chatbot' => $chatbot,
            'trackers' => $trackers,
            'html' => $html
        ]);
    }



}
