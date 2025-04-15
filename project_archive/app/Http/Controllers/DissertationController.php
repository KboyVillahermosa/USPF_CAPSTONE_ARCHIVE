<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dissertation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DissertationController extends Controller
{
    public function create()
    {
        return view('dissertation.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'type' => 'required|in:dissertation,thesis',
            'abstract' => 'required|string',
            'department' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'keywords' => 'required|string|max:255',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = 'dissertations/' . $fileName;
        
        // Store the file
        Storage::disk('public')->put($filePath, file_get_contents($file));

        // Create dissertation record
        $dissertation = new Dissertation();
        $dissertation->title = $request->title;
        $dissertation->author = $request->author;
        $dissertation->type = $request->type;
        $dissertation->abstract = $request->abstract;
        $dissertation->department = $request->department;
        $dissertation->year = $request->year;
        $dissertation->file_path = $filePath;
        $dissertation->keywords = $request->keywords;
        $dissertation->user_id = Auth::id();
        $dissertation->status = 'pending';
        $dissertation->save();

        // Redirect to the main history page with all submissions
        return redirect()->route('history')
            ->with('success', 'Your ' . ucfirst($request->type) . ' has been uploaded successfully and is pending approval.');
    }

    public function show($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        
        // Check if user is authorized to view this
        if ($dissertation->user_id != Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the file exists and pass this information to the view
        $fileExists = Storage::disk('public')->exists($dissertation->file_path);
        
        // Debug information - can be removed in production
        $storagePath = storage_path('app/public/' . $dissertation->file_path);
        $publicUrl = asset('storage/' . $dissertation->file_path);
        
        // Only try to increment if the column exists in the database
        try {
            $dissertation->increment('view_count');
        } catch (\Exception $e) {
            // Silently fail if the column doesn't exist yet
        }
        
        return view('dissertation.show', compact('dissertation', 'fileExists', 'storagePath', 'publicUrl'));
    }

    public function history()
    {
        // Get user's dissertations and theses
        $dissertations = Dissertation::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Redirect to the main history page with the dissertation tab active
        return redirect()->route('history')
            ->with('activeTab', 'dissertation');
    }

    public function index(Request $request)
    {
        $category = $request->get('category', 'dissertations');
        
        // Get dissertations
        if ($category === 'dissertations' || $category === 'all') {
            $query = Dissertation::where('status', 'approved');
            
            // Apply filters
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }
            
            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }
            
            if ($request->filled('year')) {
                $query->where('year', $request->year);
            }
            
            if ($request->filled('search')) {
                $search = '%' . $request->search . '%';
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', $search)
                      ->orWhere('author', 'like', $search)
                      ->orWhere('keywords', 'like', $search);
                });
            }
            
            $dissertations = $query->orderBy('created_at', 'desc')->paginate(12);
            
            if ($category === 'dissertations') {
                return view('dissertation.index', compact('dissertations'));
            }
        }
        
        // Get research papers
        if ($category === 'student' || $category === 'faculty' || $category === 'all') {
            $query = \App\Models\ResearchRepository::where('approved', 1);
            
            // Filter by type
            if ($category === 'faculty') {
                $query->where('is_faculty', 1);
            } elseif ($category === 'student') {
                $query->where('is_faculty', 0);
            }
            
            // Apply filters
            if ($request->filled('department')) {
                $query->where('department', $request->department);
            }
            
            if ($request->filled('curriculum')) {
                $query->where('curriculum', $request->curriculum);
            }
            
            if ($request->filled('year')) {
                $query->whereYear('created_at', $request->year);
            }
            
            if ($request->filled('search')) {
                $search = '%' . $request->search . '%';
                $query->where(function($q) use ($search) {
                    $q->where('project_name', 'like', $search)
                      ->orWhere('members', 'like', $search)
                      ->orWhere('keywords', 'like', $search);
                });
            }
            
            $projects = $query->orderBy('created_at', 'desc')->paginate(12);
            
            if ($category === 'student' || $category === 'faculty') {
                return view('dissertation.index', compact('projects'));
            }
        }
        
        // For 'all' category, we need both types
        if ($category === 'all') {
            // We already have both $dissertations and $projects from above
            return view('dissertation.index', compact('dissertations', 'projects'));
        }
        
        // Default fallback
        return view('dissertation.index', ['dissertations' => collect()]);
    }

    /**
     * Handle the download request for a dissertation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        // Find the dissertation
        $dissertation = Dissertation::findOrFail($id);
        
        // Check if status is approved
        if ($dissertation->status !== 'approved') {
            return back()->with('error', 'This dissertation is not available for download.');
        }

        // Check if file exists
        if (!Storage::exists($dissertation->file_path)) {
            return back()->with('error', 'The file could not be found.');
        }
        
        // Increment download count
        $dissertation->increment('download_count');
        
        // Log the download purpose if submitted
        if ($request->has('purpose')) {
            // Log purposes
            $purposes = $request->input('purpose');
            
            // Handle "other" purpose text if provided
            if (in_array('other', $purposes) && $request->has('other_purpose_text')) {
                $otherText = $request->input('other_purpose_text');
                // You might want to log this or save it to a download_logs table
                \Log::info("Dissertation {$id} downloaded for other purpose: {$otherText}");
            }
            
            // Log all selected purposes
            \Log::info("Dissertation {$id} downloaded for purposes: " . implode(", ", $purposes));
        }
        
        // Return the file download
        return Storage::download($dissertation->file_path, $dissertation->title . '.pdf');
    }
}