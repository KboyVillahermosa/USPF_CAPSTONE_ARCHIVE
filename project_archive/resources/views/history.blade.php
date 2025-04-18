<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Academic Archives
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

            <!-- Archive Type Selection Tabs -->
            <div class="mb-6 bg-white shadow-md rounded-lg overflow-hidden">
                <div class="flex border-b">
                    <button onclick="showContent('all')" id="tab-all" class="tab-button px-6 py-3 font-medium transition-colors focus:outline-none tab-active">
                        All Submissions
                    </button>
                    <button onclick="showContent('research')" id="tab-research" class="tab-button px-6 py-3 font-medium transition-colors focus:outline-none">
                        Research Papers
                    </button>
                    <button onclick="showContent('dissertation')" id="tab-dissertation" class="tab-button px-6 py-3 font-medium transition-colors focus:outline-none">
                        Dissertations & Theses
                    </button>
                </div>
            </div>

            <!-- All Submissions Content -->
            <div id="content-all" class="content-section bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">All Academic Submissions</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('upload.select') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Upload New
                        </a>
                    </div>
                </div>

                @if((isset($userProjects) && $userProjects->isEmpty()) && (isset($dissertations) && $dissertations->isEmpty()))
                    <p class="text-gray-500">No academic submissions uploaded yet.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Title</th>
                                <th class="px-4 py-2 border">Authors</th>
                                <th class="px-4 py-2 border">Department</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($userProjects))
                                @foreach ($userProjects as $project)
                                    <tr class="research-row">
                                        <td class="px-4 py-2 border">{{ $project->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-2 border">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                Research
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 border">{{ $project->project_name }}</td>
                                        <td class="px-4 py-2 border">{{ $project->members }}</td>
                                        <td class="px-4 py-2 border">{{ $project->department ?: 'Not specified' }}</td>
                                        <td class="px-4 py-2 border">
                                            @if ($project->approved)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                    Published
                                                </span>
                                            @elseif ($project->rejected)
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                        Rejected
                                                    </span>
                                                    @if($project->rejection_reason)
                                                        <button onclick="showRejectionReason('{{ addslashes($project->rejection_reason) }}')" 
                                                                class="text-gray-500 hover:text-gray-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
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
                            @endif

                            @if(isset($dissertations))
                                @foreach ($dissertations as $dissertation)
                                    <tr class="dissertation-row">
                                        <td class="px-4 py-2 border">{{ $dissertation->created_at->format('M d, Y') }}</td>
                                        <td class="px-4 py-2 border">
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                {{ ucfirst($dissertation->type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 border">{{ $dissertation->title }}</td>
                                        <td class="px-4 py-2 border">{{ $dissertation->author }}</td>
                                        <td class="px-4 py-2 border">{{ $dissertation->department }}</td>
                                        <td class="px-4 py-2 border">
                                            @if ($dissertation->status === 'approved')
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                    Published
                                                </span>
                                            @elseif ($dissertation->status === 'rejected')
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('dissertation.show', $dissertation->id) }}" 
                                                   class="text-blue-600 hover:text-blue-800">
                                                    View
                                                </a>
                                                @if($dissertation->status === 'approved')
                                                    <a href="{{ Storage::url($dissertation->file_path) }}" 
                                                       class="text-purple-600 hover:text-purple-800"
                                                       target="_blank">
                                                        Download
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Research Papers Content -->
            <div id="content-research" class="content-section bg-white shadow-md rounded-lg p-6 hidden">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">My Research Papers</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('upload') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            Upload Research
                        </a>
                    </div>
                </div>

                @if(!isset($userProjects) || $userProjects->isEmpty())
                    <p class="text-gray-500">No research papers uploaded yet.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Title</th>
                                <th class="px-4 py-2 border">Authors</th>
                                <th class="px-4 py-2 border">Department</th>
                                <th class="px-4 py-2 border">Program</th>
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
                                    <td class="px-4 py-2 border">{{ $project->department ?: 'Not specified' }}</td>
                                    <td class="px-4 py-2 border">{{ $project->curriculum ?: 'Not specified' }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($project->approved)
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                Published
                                            </span>
                                        @elseif ($project->rejected)
                                            <div class="flex items-center space-x-2">
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                    Rejected
                                                </span>
                                                @if($project->rejection_reason)
                                                    <button onclick="showRejectionReason('{{ addslashes($project->rejection_reason) }}')" 
                                                            class="text-gray-500 hover:text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
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

            <!-- Dissertations & Theses Content -->
            <div id="content-dissertation" class="content-section bg-white shadow-md rounded-lg p-6 hidden">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">My Dissertations & Theses</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('upload.dissertation') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            Upload Dissertation/Thesis
                        </a>
                    </div>
                </div>

                @if(!isset($dissertations) || $dissertations->isEmpty())
                    <p class="text-gray-500">No dissertations or theses uploaded yet.</p>
                @else
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Date</th>
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Title</th>
                                <th class="px-4 py-2 border">Author</th>
                                <th class="px-4 py-2 border">Department</th>
                                <th class="px-4 py-2 border">Year</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dissertations as $dissertation)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $dissertation->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 border">{{ ucfirst($dissertation->type) }}</td>
                                    <td class="px-4 py-2 border">{{ $dissertation->title }}</td>
                                    <td class="px-4 py-2 border">{{ $dissertation->author }}</td>
                                    <td class="px-4 py-2 border">{{ $dissertation->department }}</td>
                                    <td class="px-4 py-2 border">{{ $dissertation->year }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($dissertation->status === 'approved')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                Published
                                            </span>
                                        @elseif ($dissertation->status === 'rejected')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('dissertation.show', $dissertation->id) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                View
                                            </a>
                                            @if($dissertation->status === 'approved')
                                                <a href="{{ Storage::url($dissertation->file_path) }}" 
                                                   class="text-purple-600 hover:text-purple-800"
                                                   target="_blank">
                                                    Download
                                                </a>
                                            @endif
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

    <!-- Rejection Reason Modal -->
    <div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Revision Required</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-4 max-h-96 overflow-y-auto">
                    <div id="modalRejectionReason" class="prose max-w-none text-gray-600"></div>
                </div>
                <div class="mt-6 border-t pt-4">
                    <button type="button" onclick="closeModal()" 
                            class="inline-flex justify-center px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tab-button {
            border-bottom: 2px solid transparent;
        }
        .tab-active {
            border-bottom: 2px solid #3b82f6;
            color: #3b82f6;
        }
    </style>

    <script>
        function showContent(type) {
            // Hide all content sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(tab => {
                tab.classList.remove('tab-active');
            });
            
            // Show selected content and activate tab
            document.getElementById('content-' + type).classList.remove('hidden');
            document.getElementById('tab-' + type).classList.add('tab-active');
        }

        function showRejectionReason(reason) {
            document.getElementById('modalRejectionReason').innerHTML = reason;
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            let modal = document.getElementById('rejectionModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</x-app-layout>
