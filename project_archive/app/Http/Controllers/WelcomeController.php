<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get all approved research projects
        $allProjects = ResearchRepository::where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Group projects by department
        $departments = $allProjects->groupBy(function($project) {
            return $project->department ?: 'Not specified';
        })->filter(function ($projects, $department) {
            return !empty($department) && $department !== 'Not specified'; 
        });
        
        // Add "Not specified" department at the end if there are projects
        $unspecifiedProjects = $allProjects->filter(function($project) {
            return empty($project->department) || $project->department === 'Not specified';
        });
        
        if ($unspecifiedProjects->count() > 0) {
            $departments->put('Other Departments', $unspecifiedProjects);
        }
        
        // Get most recent submissions (last 3)
        $recentSubmissions = ResearchRepository::where('approved', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get most viewed submissions (top 3)
        $mostViewedSubmissions = ResearchRepository::where('approved', true)
            ->orderBy('view_count', 'desc')
            ->take(3)
            ->get();
        
        // Get most popular submissions (based on view + download count, top 3)
        $mostPopularSubmissions = ResearchRepository::where('approved', true)
            ->orderByRaw('(COALESCE(view_count, 0) + COALESCE(download_count, 0)) DESC')
            ->take(3)
            ->get();
        
        return view('welcome', compact(
            'departments',
            'recentSubmissions',
            'mostViewedSubmissions',
            'mostPopularSubmissions'
        ));
    }
}