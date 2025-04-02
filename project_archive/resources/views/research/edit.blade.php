<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Research Project
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('research.update', $research->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Project Name</label>
                        <input type="text" name="project_name" value="{{ $research->project_name }}" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Members</label>
                        <input type="text" name="members" value="{{ $research->members }}" class="w-full border-gray-300 rounded-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Department</label>
                        <select name="department" class="w-full border-gray-300 rounded-lg" required>
                            <option value="Engineering" {{ $research->department == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Computer Science" {{ $research->department == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                            <option value="Business" {{ $research->department == 'Business' ? 'selected' : '' }}>Business</option>
                            <option value="Education" {{ $research->department == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Medicine" {{ $research->department == 'Medicine' ? 'selected' : '' }}>Medicine</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Abstract</label>
                        <textarea name="abstract" class="w-full border-gray-300 rounded-lg" required>{{ $research->abstract }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Upload File (PDF, DOCX, etc.)</label>
                        <input type="file" name="file" class="w-full border-gray-300 rounded-lg">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
