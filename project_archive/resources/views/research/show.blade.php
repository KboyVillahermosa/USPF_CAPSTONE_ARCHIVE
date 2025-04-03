<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Research Details
            </h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Banner Image -->
                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                    alt="Research Banner" class="w-full h-64 object-cover">
                
                <!-- Content -->
                <div class="p-8">
                    <h1 class="text-3xl font-bold mb-4">{{ $project->project_name }}</h1>
                    
                    <!-- Research Details -->
                    <div class="mb-6">
                        <p class="text-gray-600"><span class="font-semibold">Authors:</span> {{ $project->members }}</p>
                        <p class="text-gray-600"><span class="font-semibold">Department:</span> {{ $project->department }}</p>
                        <p class="text-gray-600">
                            <span class="font-semibold">Published:</span> 
                            {{ $project->created_at->format('F d, Y') }}
                        </p>
                    </div>

                    <!-- Abstract -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Abstract</h2>
                        <div class="prose max-w-none">
                            {!! $project->abstract !!}
                        </div>
                    </div>

                    <!-- PDF Viewer Section -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Research Paper</h2>
                        <div class="relative border rounded-lg">
                            <!-- PDF Controls -->
                            <div class="absolute top-0 right-0 m-4 space-x-2 z-10">
                                <button onclick="openFullscreen()" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Fullscreen
                                </button>
                                <button onclick="openDownloadModal()" 
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                    Download PDF
                                </button>
                            </div>
                            
                            <!-- PDF Embed -->
                            <div id="pdf-container" class="w-full h-[800px]">
                                <iframe 
                                    src="{{ $pdfUrl }}#toolbar=1&navpanes=1&scrollbar=1" 
                                    width="100%" 
                                    height="100%"
                                    class="rounded-lg"
                                    frameborder="0">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Download Modal -->
                    <div id="downloadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                            <div class="mt-3">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Download Purpose
                                </h3>
                                <p class="text-sm text-gray-500 mb-4">
                                    Before proceeding with the download, please provide the purpose of your request.
                                </p>
                                <form id="downloadForm" onsubmit="handleDownload(event)">
                                    <select id="downloadPurpose" 
                                        class="w-full mb-4 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"
                                        required>
                                        <option value="">Select purpose...</option>
                                        <option value="academic">Academic Research</option>
                                        <option value="business">Business Analysis</option>
                                        <option value="personal">Personal Study</option>
                                        <option value="teaching">Teaching Material</option>
                                        <option value="other">Other</option>
                                    </select>

                                    <div class="flex justify-end space-x-3">
                                        <button type="button" 
                                            onclick="closeDownloadModal()"
                                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            Proceed to Download
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Citations -->
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold mb-2">Citations</h2>
                        
                        <div class="space-y-4">
                            <!-- APA Citation -->
                            <div class="bg-gray-50 p-4 rounded">
                                <h3 class="font-semibold mb-2">APA Format</h3>
                                <p class="text-sm">
                                    {{ $project->members }}. ({{ $project->created_at->format('Y') }}). 
                                    {{ $project->project_name }}. {{ $project->department }}.
                                </p>
                            </div>

                            <!-- IEEE Citation -->
                            <div class="bg-gray-50 p-4 rounded">
                                <h3 class="font-semibold mb-2">IEEE Format</h3>
                                <p class="text-sm">
                                    {{ $project->members }}, "{{ $project->project_name }}," 
                                    {{ $project->department }}, {{ $project->created_at->format('Y') }}.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Studies -->
                    <div>
                        <h2 class="text-xl font-semibold mb-2">Related Studies</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($relatedStudies as $study)
                                <div class="border rounded p-4">
                                    <h3 class="font-semibold mb-2">{{ $study->project_name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $study->members }}</p>
                                    <a href="{{ route('research.show', $study->id) }}" 
                                        class="text-blue-500 hover:text-blue-700">
                                        View Research →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openFullscreen() {
            const pdfContainer = document.getElementById('pdf-container');
            
            if (pdfContainer.requestFullscreen) {
                pdfContainer.requestFullscreen();
            } else if (pdfContainer.webkitRequestFullscreen) {
                pdfContainer.webkitRequestFullscreen();
            } else if (pdfContainer.msRequestFullscreen) {
                pdfContainer.msRequestFullscreen();
            }
        }

        function openDownloadModal() {
            document.getElementById('downloadModal').classList.remove('hidden');
        }

        function closeDownloadModal() {
            document.getElementById('downloadModal').classList.add('hidden');
        }

        function handleDownload(event) {
            event.preventDefault();
            const purpose = document.getElementById('downloadPurpose').value;
            
            if (!purpose) {
                alert('Please select a purpose for downloading.');
                return;
            }

            // You can log the download purpose here if needed
            console.log('Download purpose:', purpose);

            // Proceed with download
            const downloadUrl = "{{ $pdfUrl }}";
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = "{{ $project->project_name }}.pdf";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Close modal
            closeDownloadModal();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('downloadModal');
            if (event.target == modal) {
                closeDownloadModal();
            }
        }
    </script>
    @endpush
</x-app-layout>
