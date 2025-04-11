<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dissertation;
use App\Models\ResearchRepository;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        try {
            // Get user's research projects
            $userProjects = ResearchRepository::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            // Get user's dissertations
            $dissertations = Dissertation::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            return view('history', compact('userProjects', 'dissertations'));
        } catch (\Exception $e) {
            return view('history', [
                'error' => 'An error occurred while fetching your history: ' . $e->getMessage(),
                'userProjects' => collect([]),
                'dissertations' => collect([])
            ]);
        }
    }
}