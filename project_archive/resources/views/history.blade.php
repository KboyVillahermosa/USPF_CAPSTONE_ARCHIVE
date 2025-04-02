<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Research Archive
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Submitted Research Projects</h3>

                @if ($userProjects->isEmpty())
                    <p class="text-gray-500">No research projects uploaded yet.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Project Title</th>
                                <th class="px-4 py-2 border">Department</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userProjects as $project)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $project->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 border">{{ $project->project_name }}</td>
                                    <td class="px-4 py-2 border">{{ $project->department }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($project->approved)
                                            <span class="text-green-600 font-semibold">Published</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Pending Approval</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <a href="{{ route('research.edit', $project->id) }}" class="text-blue-500">Edit</a> |
                                        <a href="{{ route('research.show', $project->id) }}" class="text-green-500">View</a>
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
