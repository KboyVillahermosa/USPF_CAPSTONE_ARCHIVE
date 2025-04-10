<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResearchRepository;

class ResearchRepositoryController extends Controller {
    
    // ✅ Store new research submission
    public function store(Request $request) {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'members' => 'required|string',
            'department' => 'required|string',
            'curriculum' => 'required|string',  // Add this line
            'abstract' => 'required|string',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'required|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $validated['file'] = $request->file('file')->store('files', 'public');
        $validated['approved'] = false;
        $validated['user_id'] = auth()->id(); // ✅ Link the research project to the user

        ResearchRepository::create($validated);

        return redirect()->back()->with('success', 'Research uploaded successfully. Awaiting admin approval.');
    }

    // ✅ User's research history
    public function history() {
        $userProjects = ResearchRepository::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        return view('history', compact('userProjects'));
    }
    
    
    // ✅ Dashboard for approved research projects
    public function dashboard()
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
        
        return view('dashboard', compact(
            'departments',
            'recentSubmissions',
            'mostViewedSubmissions',
            'mostPopularSubmissions'
        ));
    }
    
    
    public function show($id)
    {
        try {
            $project = ResearchRepository::findOrFail($id);
            
            // Get related studies based on title similarity
            $relatedStudies = $project->getRelatedStudies();

            // Get file URL for PDF viewer
            $pdfUrl = asset('storage/' . $project->file);

            return view('research.show', compact('project', 'relatedStudies', 'pdfUrl'));

        } catch (\Exception $e) {
            \Log::error('Error showing research: ' . $e->getMessage());
            return redirect()
                ->route('dashboard')
                ->with('error', 'Research not found.');
        }
    }
    

    public function update(Request $request, $id)
    {
        $research = ResearchRepository::findOrFail($id);

        $research->update([
            'project_name' => $request->project_name,
            'members' => $request->members,
            'department' => $request->department,
            'curriculum' => $request->curriculumn,
            'abstract' => $request->abstract,
        ]);

        return redirect()->route('history')->with('success', 'Research updated successfully!');
    }

    public function edit($id)
    {
        $research = ResearchRepository::findOrFail($id);
        return view('research.edit', compact('research'));
    }

    public function getSearchRecommendations(Request $request)
    {
        try {
            $term = $request->get('term');
            
            if (empty($term) || strlen($term) < 2) {
                return response()->json([]);
            }

            $recommendations = ResearchRepository::where('approved', true)
                ->where(function($query) use ($term) {
                    $query->where('project_name', 'LIKE', "%{$term}%")
                          ->orWhere('members', 'LIKE', "%{$term}%")
                          ->orWhere('department', 'LIKE', "%{$term}%");
                })
                ->select('id', 'project_name', 'department')
                ->limit(5)
                ->get();

            \Log::debug('Search term:', ['term' => $term]);
            \Log::debug('Search results:', ['count' => $recommendations->count(), 'data' => $recommendations]);

            return response()->json($recommendations);
            
        } catch (\Exception $e) {
            \Log::error('Search recommendations error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
