<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($project)
                    <!-- Download Button at Top -->
                    

                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">{{ $project->project_name }}</h1>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-gray-600"><strong>Department:</strong> {{ $project->department }}</p>
                                <p class="text-gray-600"><strong>Curriculum:</strong> {{ $project->curriculum }}</p>
                                <p class="text-gray-600"><strong>Publication Date:</strong> 
                                    {{ $project->created_at->format('F d, Y') }}
                                </p>

                                <!-- Authors Section -->
                                <div class="mt-4">
                                    <p class="text-gray-600"><strong>Authors:</strong></p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach(explode(',', $project->members) as $member)
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                                {{ trim($member) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($project->banner_image)
                                    <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                         alt="Project Banner"
                                         class="w-full h-48 object-cover rounded-lg">
                                @endif
                            </div>
                        </div>

                        <!-- Abstract Section -->
                        @if($project->abstract)
                            <div class="mb-8">
                                <h2 class="text-xl font-semibold mb-3">Abstract</h2>
                                <div class="bg-gray-50 p-6 rounded-lg">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                                        {!! strip_tags(html_entity_decode($project->abstract), '<br><p>') !!}
                                    </p>
                                </div>
                            </div>
                        @endif

                        <!-- PDF Viewer Section -->
                        <div class="mb-8">
                            <h2 class="text-2xl font-semibold mb-4">Research Document</h2>
                            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                                <!-- Advanced Toolbar -->
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <!-- Left Controls -->
                                        <div class="flex items-center space-x-6">
                                            <!-- Zoom Controls -->
                                            <div class="flex items-center space-x-2">
                                                <button onclick="zoomOut()" class="toolbar-button" title="Zoom Out">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                    </svg>
                                                </button>
                                                <span id="zoomLevel" class="text-sm font-medium text-gray-700 w-16 text-center">100%</span>
                                                <button onclick="zoomIn()" class="toolbar-button" title="Zoom In">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Page Controls -->
                                            <div class="flex items-center space-x-3">
                                                <button onclick="previousPage()" class="toolbar-button" title="Previous Page">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                    </svg>
                                                </button>
                                                <div class="text-sm text-gray-700">
                                                    Page <span id="currentPage" class="font-medium">1</span> of 
                                                    <span id="totalPages" class="font-medium">-</span>
                                                </div>
                                                <button onclick="nextPage()" class="toolbar-button" title="Next Page">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Right Controls -->
                                        <div class="flex items-center space-x-4">
                                            <button onclick="resetZoom()" class="toolbar-button-secondary" title="Reset View">
                                                Reset View
                                            </button>
                                            <button onclick="toggleFullscreen()" class="toolbar-button" title="Toggle Fullscreen">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                        d="M4 8V4m0 0h4M4 4l5 5m11-5V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- PDF Viewer Container -->
                                <div id="pdfContainer" class="relative">
                                    <div class="w-full h-[800px] bg-gray-100">
                                        <iframe id="pdfViewer"
                                            src="{{ asset('storage/' . $project->file) }}#toolbar=0"
                                            class="w-full h-full transition-transform duration-200 ease-in-out"
                                            type="application/pdf"
                                            onload="this.contentWindow.focus()">
                                        </iframe>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                                    <div class="flex items-center space-x-2 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-sm">Research Paper (PDF)</span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Last modified: {{ $project->updated_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Citation Formats -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-3">Citation Formats</h2>

                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <h3 class="font-semibold mb-2">APA Format</h3>
                                <p class="text-gray-700">
                                    @php
                                        $membersList = explode(',', $project->members);
                                        $lastMember = array_pop($membersList);
                                        
                                        // Format authors for APA (Last Name, First Initial.)
                                        $formattedMembers = array_map(function($member) {
                                            $parts = array_map('trim', explode(' ', $member));
                                            $lastName = array_pop($parts);
                                            $initials = array_map(function($part) {
                                                return strtoupper(substr($part, 0, 1)) . '.';
                                            }, $parts);
                                            return $lastName . ', ' . implode(' ', $initials);
                                        }, $membersList);

                                        $lastMemberParts = array_map('trim', explode(' ', $lastMember));
                                        $lastName = array_pop($lastMemberParts);
                                        $initials = array_map(function($part) {
                                            return strtoupper(substr($part, 0, 1)) . '.';
                                        }, $lastMemberParts);
                                        $formattedLastMember = $lastName . ', ' . implode(' ', $initials);

                                        $allAuthors = !empty($formattedMembers) ? 
                                            implode(', ', $formattedMembers) . ', & ' . $formattedLastMember :
                                            $formattedLastMember;
                                    @endphp
                                    {{ $allAuthors }} ({{ $project->created_at->format('Y') }}). 
                                    {{ $project->project_name }}. 
                                    {{ $project->department }}, {{ $project->curriculum }}, 
                                    University of Southern Philippines Foundation.
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2">IEEE Format</h3>
                                <p class="text-gray-700">
                                    @php
                                        $membersList = explode(',', $project->members);
                                        // Format authors for IEEE (First Initial. Last Name)
                                        $formattedMembersIEEE = array_map(function($member) {
                                            $parts = array_map('trim', explode(' ', $member));
                                            $lastName = array_pop($parts);
                                            $initials = array_map(function($part) {
                                                return strtoupper(substr($part, 0, 1)) . '.';
                                            }, $parts);
                                            return implode(' ', $initials) . ' ' . $lastName;
                                        }, $membersList);

                                        // Join with commas and 'and' for the last author
                                        $lastAuthor = array_pop($formattedMembersIEEE);
                                        $ieeeAuthors = !empty($formattedMembersIEEE) ? 
                                            implode(', ', $formattedMembersIEEE) . ', and ' . $lastAuthor :
                                            $lastAuthor;
                                    @endphp
                                    {{ $ieeeAuthors }}, "{{ $project->project_name }}," 
                                    {{ $project->department }}, University of Southern Philippines Foundation, 
                                    {{ $project->curriculum }}, {{ $project->created_at->format('Y') }}.
                                </p>
                            </div>
                        </div>

                        <!-- Relat Studies -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-3">Related Studies</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($relatedStudies as $study)
                                    @php
                                        // Calculate meaningful relationships using multiple criteria
                                        $departmentMatch = $project->department === $study->department;
                                        $curriculumMatch = $project->curriculum === $study->curriculum;
                                        
                                        // Extract keywords
                                        $projectKeywords = array_map('trim', explode(',', $project->keywords ?? ''));
                                        $studyKeywords = array_map('trim', explode(',', $study->keywords ?? ''));
                                        $commonKeywords = array_intersect($projectKeywords, $studyKeywords);
                                        
                                        // Calculate title similarity
                                        $projectWords = array_map('strtolower', explode(' ', $project->project_name));
                                        $studyWords = array_map('strtolower', explode(' ', $study->project_name));
                                        $commonWords = array_intersect($projectWords, $studyWords);
                                        
                                        // Determine if studies are truly related (must meet multiple criteria)
                                        $isRelated = (
                                            ($departmentMatch && !empty($commonKeywords)) || // Same department and shared keywords
                                            ($departmentMatch && count($commonWords) >= 3) || // Same department and significant title overlap
                                            (!empty($commonKeywords) && count($commonKeywords) >= 2) // Multiple shared keywords
                                        );
                                    @endphp

                                    @if($isRelated)
                                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                                            <div class="flex justify-between items-start mb-3">
                                                <h3 class="font-semibold text-lg">{{ $study->project_name }}</h3>
                                            </div>

                                            <div class="space-y-2 mb-3">
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-medium">Department:</span> {{ $study->department }}
                                                </p>
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-medium">Year:</span> {{ $study->created_at->format('Y') }}
                                                </p>
                                                
                                                <!-- Show relationship indicators -->
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    @if(!empty($commonKeywords))
                                                        <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                            Related Topics: {{ implode(', ', $commonKeywords) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex justify-end">
                                                <a href="{{ route('research.show', $study) }}"
                                                   class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View Research
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500">Research project not found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Download Purpose Modal -->
    <div id="downloadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-md w-full mx-4">
            <h3 class="text-xl font-semibold mb-4">Download Purpose</h3>
            <p class="text-gray-600 mb-4">
                Please select your purpose for downloading this research paper:
            </p>

            <form action="{{ route('research.download', $project) }}" method="POST" id="downloadForm">
                @csrf
                <div class="mb-4 space-y-3">
                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="thesis_reference" 
                            class="mt-1 mr-3" id="thesis_reference">
                        <label for="thesis_reference" class="text-gray-700">
                            For Thesis/Capstone Reference
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="literature_review" 
                            class="mt-1 mr-3" id="literature_review">
                        <label for="literature_review" class="text-gray-700">
                            Literature Review
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="research_work" 
                            class="mt-1 mr-3" id="research_work">
                        <label for="research_work" class="text-gray-700">
                            Research Work
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="academic_study" 
                            class="mt-1 mr-3" id="academic_study">
                        <label for="academic_study" class="text-gray-700">
                            Academic Study
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="other" 
                            class="mt-1 mr-3" id="other_purpose">
                        <label for="other_purpose" class="text-gray-700">
                            Other Purpose
                        </label>
                    </div>

                    <div id="otherPurposeField" class="hidden">
                        <input type="text" name="other_purpose_text" 
                            class="w-full mt-2 p-2 border rounded"
                            placeholder="Please specify your purpose">
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelDownload" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
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

    <script>
        const downloadModal = document.getElementById('downloadModal');
        const downloadForm = document.getElementById('downloadForm');
        const checkboxes = downloadForm.querySelectorAll('input[type="checkbox"]');
        const otherCheckbox = document.getElementById('other_purpose');
        const otherPurposeField = document.getElementById('otherPurposeField');

        // Show modal when download button is clicked
        document.querySelector('[data-download-trigger]').addEventListener('click', () => {
            downloadModal.classList.remove('hidden');
            downloadModal.classList.add('flex');
        });

        // Hide modal when cancel is clicked
        document.getElementById('cancelDownload').addEventListener('click', () => {
            downloadModal.classList.remove('flex');
            downloadModal.classList.add('hidden');
            // Reset form
            checkboxes.forEach(checkbox => checkbox.checked = false);
            otherPurposeField.classList.add('hidden');
        });

        // Toggle other purpose text field
        otherCheckbox.addEventListener('change', (e) => {
            if (e.target.checked) {
                otherPurposeField.classList.remove('hidden');
            } else {
                otherPurposeField.classList.add('hidden');
            }
        });

        // Validate form before submission
        downloadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
            
            if (checkedBoxes.length === 0) {
                alert('Please select at least one purpose for downloading.');
                return;
            }

            if (otherCheckbox.checked && !downloadForm.other_purpose_text.value.trim()) {
                alert('Please specify your other purpose.');
                return;
            }

            downloadForm.submit();
        });

        // PDF Viewer Controls
        let currentZoom = 100;
        const pdfViewer = document.getElementById('pdfViewer');
        const zoomLevelDisplay = document.getElementById('zoomLevel');

        function zoomIn() {
            if (currentZoom < 200) {
                currentZoom += 25;
                updateZoom();
            }
        }

        function zoomOut() {
            if (currentZoom > 50) {
                currentZoom -= 25;
                updateZoom();
            }
        }

        function resetZoom() {
            currentZoom = 100;
            updateZoom();
        }

        function updateZoom() {
            const viewer = document.getElementById('pdfViewer');
            viewer.style.transform = `scale(${currentZoom/100})`;
            viewer.style.transformOrigin = 'center top';
            zoomLevelDisplay.textContent = `${currentZoom}%`;
        }

        function nextPage() {
            pdfViewer.contentWindow.postMessage({ type: 'nextPage' }, '*');
        }

        function previousPage() {
            pdfViewer.contentWindow.postMessage({ type: 'previousPage' }, '*');
        }

        // Add smooth transitions for zoom
        function smoothZoom(targetZoom) {
            const steps = 10;
            const stepSize = (targetZoom - currentZoom) / steps;
            let step = 0;

            const animate = () => {
                if (step < steps) {
                    currentZoom += stepSize;
                    updateZoom();
                    step++;
                    requestAnimationFrame(animate);
                }
            };

            requestAnimationFrame(animate);
        }

        // Toggle fullscreen mode
        function toggleFullscreen() {
            const container = document.getElementById('pdfContainer');
            
            if (!document.fullscreenElement) {
                container.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // Enhanced PDF loading handler
        window.addEventListener('load', () => {
            const pdfViewer = document.getElementById('pdfViewer');
            
            // Focus the PDF viewer when loaded
            pdfViewer.onload = () => {
                pdfViewer.contentWindow.focus();
            };

            // Initialize zoom
            updateZoom();
        });
    </script>

    <!-- Add these styles to your existing styles or in a <style> tag -->
    <style>
        .toolbar-button {
            @apply p-2 text-gray-700 hover:bg-gray-200 rounded-lg transition-colors duration-150 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50;
        }
        
        .toolbar-button-secondary {
            @apply px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-200 rounded-md transition-colors duration-150
                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50;
        }
    </style>
</x-app-layout>