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
        
        return view('dissertation.show', compact('dissertation'));
    }
}