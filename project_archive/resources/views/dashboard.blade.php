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
                            <div class="bg-gray-100 p-4 rounded-lg shadow">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                    alt="Project Image" class="w-full h-40 object-cover rounded-md mb-3">
                                
                                <h4 class="font-semibold">{{ $project->project_name }}</h4>
                                <p class="text-gray-700 text-sm">Submitted by: {{ $project->email }}</p>

                                <button onclick="openModal('{{ asset('storage/' . $project->file) }}')" 
                                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    View Research
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="pdfModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Research Document</h3>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <iframe id="pdfViewer" class="w-full h-96"></iframe>
        </div>
    </div>

    <script>
        function openModal(pdfUrl) {
            document.getElementById('pdfViewer').src = pdfUrl;
            document.getElementById('pdfModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('pdfModal').classList.add('hidden');
            document.getElementById('pdfViewer').src = "";
        }
    </script>
</x-app-layout>
