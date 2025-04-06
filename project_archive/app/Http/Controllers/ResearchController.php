<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function download(Request $request, $id)
    {
        $project = ResearchRepository::findOrFail($id);
        
        // Validate the request
        $request->validate([
            'purpose' => 'required|string',
            'other_purpose' => 'required_if:purpose,other|string|max:500',
        ]);

        // Log the download purpose (optional)
        \Log::info('Research Download', [
            'research_id' => $project->id,
            'user_id' => auth()->id(),
            'purpose' => $request->purpose,
            'other_purpose' => $request->other_purpose,
            'timestamp' => now(),
        ]);

        // Generate the file download
        return Storage::download($project->file, $project->project_name . '.pdf');
    }
}