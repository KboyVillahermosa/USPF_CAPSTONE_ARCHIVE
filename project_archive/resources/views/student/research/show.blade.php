@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>{{ $research->title }}</h4>
        </div>
        <div class="card-body">
            <h5>Current Version: {{ $research->current_version?->version_number ?? 'No versions' }}</h5>
            
            <!-- Upload New Version Form -->
            <div class="mt-4">
                <h5>Upload New Version</h5>
                <form action="{{ route('student.research.version.store', $research) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title (Optional Update)</label>
                        <input type="text" 
                               name="title" 
                               class="form-control" 
                               value="{{ $research->title }}"
                               placeholder="Update research title (optional)">
                    </div>
                    <div class="form-group mt-3">
                        <label>PDF File</label>
                        <input type="file" name="file" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Changes Made</label>
                        <textarea name="changes_description" 
                                  class="form-control" 
                                  rows="3" 
                                  required 
                                  placeholder="Describe the changes in this version"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Upload New Version</button>
                </form>
            </div>

            <!-- Version History -->
            <div class="mt-4">
                <h5>Version History</h5>
                <div class="list-group">
                    @foreach($versions as $version)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Version {{ $version->version_number }}</h6>
                                <small class="text-muted">Uploaded: {{ $version->created_at->format('M d, Y h:ia') }}</small>
                                @if($version->changes_description)
                                    <p class="mb-1"><strong>Changes:</strong> {{ $version->changes_description }}</p>
                                @endif
                            </div>
                            <a href="{{ Storage::url($version->file_path) }}" 
                               class="btn btn-sm btn-primary" 
                               target="_blank">
                                Download PDF
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection