<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Research Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <form method="GET" action="{{ route('dashboard') }}" class="mb-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search research..." class="border px-4 py-2 w-full rounded-md">
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Search
                </button>
            </form>

            @foreach($departments as $department => $projects)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">{{ $department }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $project)
                            <div class="bg-white border rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                    alt="Project Banner" class="w-full h-48 object-cover rounded-t-lg">
                                
                                <div class="p-4">
                                    <h4 class="font-bold text-xl mb-2">{{ $project->project_name }}</h4>
                                    
                                    <div class="mb-3 text-gray-600">
                                        <p><span class="font-semibold">Authors:</span> {{ $project->members }}</p>
                                        <p><span class="font-semibold">Department:</span> {{ $project->department }}</p>
                                        <p><span class="font-semibold">Published:</span> 
                                            {{ $project->created_at->format('F d, Y') }}
                                        </p>
                                    </div>

                                    <a href="{{ route('research.show', $project->id) }}" 
                                        class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
