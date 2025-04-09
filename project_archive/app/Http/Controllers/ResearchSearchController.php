<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;

class ResearchSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        return ResearchRepository::where('approved', true)
            ->where(function($q) use ($query) {
                $q->where('project_name', 'like', "%{$query}%")
                  ->orWhere('members', 'like', "%{$query}%")
                  ->orWhere('abstract', 'like', "%{$query}%");
            })
            ->select('id', 
                    'project_name as title', 
                    'members as authors', 
                    'department',
                    'abstract',
                    'created_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'authors' => $item->authors,
                    'department' => $item->department,
                    'abstract' => \Str::limit($item->abstract, 150),
                    'year' => $item->created_at->format('Y')
                ];
            });
    }
}