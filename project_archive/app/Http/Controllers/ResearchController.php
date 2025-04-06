<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;

class ResearchController extends Controller
{
    public function show($id)
    {
        // Find the research project by ID
        $project = ResearchRepository::findOrFail($id);
        
        // Get related studies using the existing method
        $relatedStudies = $project->getRelatedStudies();

        return view('research.show', compact('project', 'relatedStudies'));
    }
}