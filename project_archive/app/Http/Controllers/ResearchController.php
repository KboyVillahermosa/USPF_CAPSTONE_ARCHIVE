<?php

namespace App\Http\Controllers;

use App\Models\ResearchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResearchController extends Controller
{
    public function index()
    {
        // Get all approved research projects
        $projects = ResearchRepository::where('approved', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Group projects by department, ensuring we filter out any with empty departments
        $departments = $projects->groupBy('department')
            ->filter(function ($projects, $department) {
                return !empty($department);
            });
            
        return view('dashboard', compact('departments'));
    }
    
    public function store(Request $request)
    {
        // Add this temporarily to debug
        \Log::info('Department value: ' . $request->department);
        if ($request->has('custom_department')) {
            \Log::info('Custom department value: ' . $request->custom_department);
        }
        
        // Validate the request data
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'members' => 'required|string',
            'department' => 'required|string|max:255',
            'curriculum' => 'required|string',
            'abstract' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx',
            'banner_image' => 'nullable|image|max:2048',
            'custom_department' => 'nullable|string|max:255',
        ]);

        // Create new research repository
        $project = new ResearchRepository();
        $project->project_name = $request->project_name;
        $project->members = $request->members;
        
        // Fix: Use the custom department value if provided
        if ($request->has('custom_department')) {
            $project->department = $request->custom_department;
        } else {
            $project->department = $request->department;
        }
        
        $project->curriculum = $request->curriculum;
        $project->abstract = $request->abstract;
        $project->user_id = auth()->id();
        
        // Store file
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('research_files', 'public');
            $project->file = $filePath;
        }
        
        // Store banner image
        if ($request->hasFile('banner_image')) {
            $imagePath = $request->file('banner_image')->store('research_banners', 'public');
            $project->banner_image = $imagePath;
        } else {
            // Default banner image
            $project->banner_image = 'research_banners/default-banner.jpg';
        }
        
        $project->save();
        
        return redirect()->route('research.history')
            ->with('success', 'Research project submitted successfully. It will be reviewed by administrators.');
    }

    public function show($id)
    {
        // Find the research project by ID
        $project = ResearchRepository::findOrFail($id);
        
        // Get related studies using the existing method
        $relatedStudies = $project->getRelatedStudies();

        return view('research.show', compact('project', 'relatedStudies'));
    }

    public function history()
    {
        // Get all research projects by current user
        $userProjects = ResearchRepository::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('research.history', compact('userProjects'));
    }
    
    public function department($department)
    {
        // Get all approved research projects for a specific department
        $projects = ResearchRepository::where('approved', true)
            ->where('department', $department)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('department.show', compact('projects', 'department'));
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
    
    public function edit($id)
    {
        // Find the research project by ID and ensure it belongs to the current user
        $project = ResearchRepository::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        return view('research.edit', compact('project'));
    }
    
    public function update(Request $request, $id)
    {
        // Find the research project by ID and ensure it belongs to the current user
        $project = ResearchRepository::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        // Validate the request
        $request->validate([
            'project_name' => 'required|string|max:255',
            'members' => 'required|string',
            'department' => 'required|string',
            'curriculum' => 'required|string',
            'abstract' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'custom_department' => 'nullable|string|max:255',
        ]);
        
        // Update project details
        $project->project_name = $request->project_name;
        $project->members = $request->members;
        
        // Fix: Use the custom department value if provided
        if ($request->has('custom_department')) {
            $project->department = $request->custom_department;
        } else {
            $project->department = $request->department;
        }
        
        $project->curriculum = $request->curriculum;
        $project->abstract = $request->abstract;
        
        // Update file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($project->file) {
                Storage::disk('public')->delete($project->file);
            }
            
            // Store new file
            $filePath = $request->file('file')->store('research_files', 'public');
            $project->file = $filePath;
            
            // Reset approval status when file is updated
            $project->approved = false;
            $project->rejected = false;
            $project->rejection_reason = null;
        }
        
        // Update banner image if provided
        if ($request->hasFile('banner_image')) {
            // Delete old banner image
            if ($project->banner_image && $project->banner_image != 'research_banners/default-banner.jpg') {
                Storage::disk('public')->delete($project->banner_image);
            }
            
            // Store new banner image
            $imagePath = $request->file('banner_image')->store('research_banners', 'public');
            $project->banner_image = $imagePath;
        }
        
        $project->save();
        
        return redirect()->route('research.history')
            ->with('success', 'Research project updated successfully.');
    }
}