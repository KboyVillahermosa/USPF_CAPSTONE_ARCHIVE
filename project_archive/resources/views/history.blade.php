<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Research Archive
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Show any flash messages -->
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">My Research Projects</h3>

                @if(isset($error))
                    <div class="text-red-600">{{ $error }}</div>
                @endif

                @if ($userProjects->isEmpty())
                    <p class="text-gray-500">No research projects uploaded yet.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Project Title</th>
                                <th class="px-4 py-2 border">Members</th>
                                <th class="px-4 py-2 border">Department</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userProjects as $project)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $project->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 border">{{ $project->project_name }}</td>
                                    <td class="px-4 py-2 border">{{ $project->members }}</td>
                                    <td class="px-4 py-2 border">{{ $project->department }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($project->approved)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                                Published
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('faculty.research.show', $project->id) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                View
                                            </a>
                                            <a href="{{ route('faculty.research.edit', $project->id) }}" 
                                               class="text-green-600 hover:text-green-800">
                                                Edit
                                            </a>
                                            <a href="{{ Storage::url($project->file) }}" 
                                               class="text-purple-600 hover:text-purple-800"
                                               target="_blank">
                                                Download
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
