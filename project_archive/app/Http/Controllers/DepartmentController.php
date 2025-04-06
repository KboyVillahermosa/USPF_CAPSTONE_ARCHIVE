<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function show($department)
    {
        $department = urldecode($department);
        
        // Get all research papers for this department
        $projects = ResearchRepository::where('department', $department)
                                    ->where('approved', true)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // Get unique curriculums for filtering
        $curriculums = ResearchRepository::where('department', $department)
                                        ->where('approved', true)
                                        ->distinct()
                                        ->pluck('curriculum');

        // Get unique years for filtering
        $years = $projects->map(function($project) {
            return $project->created_at->format('Y');
        })->unique()->values();

        return view('department.show', compact('department', 'projects', 'curriculums', 'years'));
    }
}
