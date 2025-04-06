<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($project)
                    <!-- Download Button at Top -->
                    <div class="mb-6 flex justify-end">
                        <button data-download-trigger
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Download Research Paper
                        </button>
                    </div>

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

                        <!-- PDF Viewer -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-3">Research Document</h2>
                            <div class="w-full h-[800px] border rounded-lg">
                                <iframe src="{{ asset('storage/' . $project->file) }}#toolbar=0" 
                                    class="w-full h-full rounded-lg"
                                    type="application/pdf">
                                </iframe>
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
                                        $formattedMembers = !empty($membersList) ?
                                            implode(', ', $membersList) . ' & ' . $lastMember :
                                            $lastMember;
                                    @endphp
                                    {{ $formattedMembers }} ({{ $project->created_at->format('Y') }}).
                                    {{ $project->project_name }}. {{ $project->department }},
                                    {{ $project->curriculum }}, Research Archive.
                                </p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2">IEEE Format</h3>
                                <p class="text-gray-700">
                                    @php
                                        $membersList = explode(',', $project->members);
                                        $formattedMembersIEEE = implode(', ', array_map('trim', $membersList));
                                    @endphp
                                    {{ $formattedMembersIEEE }}, "{{ $project->project_name }},"
                                    {{ $project->department }}, {{ $project->curriculum }},
                                    {{ $project->created_at->format('Y') }}.
                                </p>
                            </div>
                        </div>

                        <!-- Related Studies -->
                        <div>
                            <h2 class="text-xl font-semibold mb-3">Related Studies</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($relatedStudies as $study)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h3 class="font-semibold">{{ $study->project_name }}</h3>
                                        <p class="text-gray-600">{{ $study->department }}</p>
                                        <a href="{{ route('research.show', $study) }}"
                                            class="text-blue-500 hover:text-blue-700">View Research</a>
                                    </div>
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
                Before proceeding with the download, please provide the purpose of your request. This helps us understand how the document will be used and ensures responsible access to the content.
            </p>

            <form action="{{ route('research.download', $project) }}" method="POST" id="downloadForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Select Purpose:</label>
                    <select name="purpose" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Please select a purpose...</option>
                        <option value="academic_research">Academic Research</option>
                        <option value="thesis_reference">Thesis/Dissertation Reference</option>
                        <option value="literature_review">Literature Review</option>
                        <option value="course_requirement">Course Requirement</option>
                        <option value="teaching_material">Teaching Material</option>
                        <option value="personal_study">Personal Study</option>
                        <option value="industry_research">Industry/Professional Research</option>
                        <option value="other">Other (Please specify)</option>
                    </select>
                </div>

                <div id="otherPurposeField" class="mb-4 hidden">
                    <label class="block text-gray-700 font-medium mb-2">Please specify:</label>
                    <textarea name="other_purpose" rows="2" 
                        class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    ></textarea>
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
        const purposeSelect = downloadForm.querySelector('select[name="purpose"]');
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
        });

        // Show/hide other purpose field
        purposeSelect.addEventListener('change', () => {
            otherPurposeField.classList.toggle('hidden', purposeSelect.value !== 'other');
        });

        // Validate form before submission
        downloadForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            if (!purposeSelect.value) {
                alert('Please select a purpose for downloading.');
                return;
            }

            if (purposeSelect.value === 'other' && !downloadForm.other_purpose.value.trim()) {
                alert('Please specify your purpose for downloading.');
                return;
            }

            downloadForm.submit();
        });
    </script>
</x-app-layout>