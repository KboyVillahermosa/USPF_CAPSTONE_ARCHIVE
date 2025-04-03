<?php

namespace App\Http\Controllers;

use App\Models\FacultyResearch;
use Illuminate\Http\Request;
use App\Models\ResearchRepository;

class FacultyResearchController extends Controller 
{
    public function create()
    {
        return view('upload_faculty');
    }

    // ✅ Store new research submission
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'members' => 'required|string',
            'department' => 'required|string',
            'abstract' => 'required|string',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            if ($request->hasFile('banner_image')) {
                $validated['banner_image'] = $request->file('banner_image')->store('faculty/banners', 'public');
            }

            if ($request->hasFile('file')) {
                $validated['file'] = $request->file('file')->store('faculty/files', 'public');
            }

            $validated['user_id'] = auth()->id();
            $validated['approved'] = false;

            FacultyResearch::create($validated);

            return redirect()
                ->route('research.history')
                ->with('success', 'Faculty research uploaded successfully.');

        } catch (\Exception $e) {
            \Log::error('Upload failed: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Upload failed. Please try again.');
        }
    }

    // ✅ User's research history
    public function history()
    {
        $userProjects = FacultyResearch::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('history', compact('userProjects'));
    }
    
    
    // ✅ Dashboard for approved research projects
    public function dashboard(Request $request) {
        $query = ResearchRepository::where('approved', true);
    
        // Initialize search variable
        $search = null;
    
        // Apply search filter
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('members', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%");
            });
        }
    
        $projects = $query->get();
        $departments = $projects->groupBy('department');
    
        return view('dashboard', compact('departments', 'search'));
    }
    
    
    public function show($id)
    {
        $project = ResearchRepository::find($id);
    
        if (!$project) {
            abort(404, 'Project not found');
        }
    
        return view('research.show', compact('project'));
    }
    

    public function update(Request $request, $id)
    {
        $research = ResearchRepository::findOrFail($id);

        $research->update([
            'project_name' => $request->project_name,
            'members' => $request->members,
            'department' => $request->department,
            'abstract' => $request->abstract,
        ]);

        return redirect()->route('history')->with('success', 'Research updated successfully!');
    }

    public function edit($id)
    {
        $research = ResearchRepository::findOrFail($id);
        return view('research.edit', compact('research'));
    }
}
