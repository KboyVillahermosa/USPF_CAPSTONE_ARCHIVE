<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project Details
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Project Details</h3>

            <p><strong>Title:</strong> {{ $project->project_name }}</p>
            <p><strong>Members:</strong> {{ $project->members }}</p>
            <p><strong>Department:</strong> {{ $project->department }}</p>
            <p><strong>Abstract:</strong> {{ $project->abstract }}</p>
            <a href="{{ asset('storage/' . $project->file) }}" target="_blank" class="text-blue-600 underline">Download File</a>
        </div>
    </div>
</x-app-layout>
