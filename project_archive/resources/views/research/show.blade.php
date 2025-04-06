<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($project)
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
                            <iframe src="{{ asset('storage/' . $project->file) }}"
                                class="w-full h-screen rounded-lg border"></iframe>
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
</x-app-layout>