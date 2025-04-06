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
        
        // Validate the download purpose
        $request->validate([
            'purpose' => 'required|array',
            'other_purpose_text' => 'nullable|string'
        ]);

        // Log the download
        \App\Models\DownloadLog::create([
            'research_id' => $project->id,
            'user_id' => auth()->id(),
            'purposes' => $request->purpose,
            'ip_address' => $request->ip()
        ]);

        // Get the file path - use 'file' instead of 'file_path'
        $filePath = $project->file;

        // Check if file exists
        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File not found.');
        }

        // Return file download response
        return Storage::disk('public')->download(
            $filePath, 
            $project->project_name . '.' . pathinfo($filePath, PATHINFO_EXTENSION)
        );
    }
}