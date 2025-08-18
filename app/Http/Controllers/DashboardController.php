<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Chatbot;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();
        $chatbots = $user->chatbots()->with('logs')->get();

        // Average response time across all chatbot logs
        $allLogs = $chatbots->pluck('logs')->flatten();
        $avgResponseTime = $allLogs->avg('response_time');
        $avgResponseTime = $avgResponseTime ? round($avgResponseTime) : null;

        // Total models and total calls
        $totalModels = $chatbots->count();
        $totalBotCalls = $chatbots->sum(fn($bot) => $bot->logs->count());

        // Months for chart
        $labels = collect(range(1,12))->map(fn($month) => Carbon::create()->month($month)->format('M'));

        // Get all unique years from logs
        $years = $chatbots->pluck('logs')->flatten()->pluck('created_at')->map(fn($d) => Carbon::parse($d)->year)->unique()->sortDesc()->values();

        // Default selected year (latest year or current year)
        $selectedYear = $years->first() ?? now()->year;

        // Prepare datasets for selected year
        $datasets = $chatbots->map(function($bot) use ($selectedYear) {
            $monthlyUsage = [];
            foreach(range(1,12) as $month){
                $monthlyCount = $bot->logs()->whereYear('created_at', $selectedYear)->whereMonth('created_at', $month)->count();
                $monthlyUsage[] = $monthlyCount;
            }

            $highlighterColors = [
                '#e6194b','#3cb44b','#4363d8','#f58231','#911eb4','#46f0f0','#f032e6',
                '#bcf60c','#fabebe','#008080','#e6beff','#9a6324','#fffac8','#800000',
                '#aaffc3','#808000','#ffd8b1','#000075','#808080','#f4a261','#2a9d8f'
            ];

            $colorIndex = $bot->id % count($highlighterColors);
            $color = $highlighterColors[$colorIndex];

            return [
                'label' => $bot->name,
                'data' => $monthlyUsage,
                'borderColor' => $color,
                'backgroundColor' => $color.'33',
                'tension' => 0.4,
                'fill' => true
            ];
        });

        return view('home', compact(
            'totalModels','totalBotCalls','avgResponseTime','labels','datasets','years','selectedYear'
        ));
    }

    public function usageByYear(Request $request){
        $year = $request->year;
        $user = Auth::user();
        $chatbots = $user->chatbots()->with('logs')->get();

        $months = collect(range(1,12))->map(fn($month) => Carbon::create()->month($month)->format('M'));

        $highlighterColors = [
            '#e6194b','#3cb44b','#4363d8','#f58231','#911eb4','#46f0f0','#f032e6',
            '#bcf60c','#fabebe','#008080','#e6beff','#9a6324','#fffac8','#800000',
            '#aaffc3','#808000','#ffd8b1','#000075','#808080','#f4a261','#2a9d8f'
        ];

        $colorIndex = 0;

        $datasets = $chatbots->map(function($bot) use ($year,$highlighterColors,&$colorIndex){
            $monthlyUsage = [];
            foreach(range(1,12) as $month){
                $count = $bot->logs()->whereYear('created_at',$year)->whereMonth('created_at',$month)->count();
                $monthlyUsage[] = $count;
            }

            $color = $highlighterColors[$colorIndex % count($highlighterColors)];
            $colorIndex++;

            return [
                'label' => $bot->name,
                'data' => $monthlyUsage,
                'borderColor' => $color,
                'backgroundColor' => $color.'33',
                'tension' => 0.4,
                'fill' => true
            ];
        });

        return response()->json(['datasets'=>$datasets]);
    }

}
