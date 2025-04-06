<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Department Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ $department }}</h1>
                <p class="text-gray-600 mt-2">Browse all research papers from {{ $department }}</p>
            </div>

            <!-- Filters -->
            <div class="mb-6 flex flex-wrap gap-4">
                <!-- Curriculum Filter -->
                <select id="curriculum-filter" class="border rounded-md px-4 py-2">
                    <option value="all">All Curricula</option>
                    @foreach($curriculums as $curriculum)
                        <option value="{{ $curriculum }}">{{ $curriculum }}</option>
                    @endforeach
                </select>

                <!-- Year Filter -->
                <select id="year-filter" class="border rounded-md px-4 py-2">
                    <option value="all">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Research Papers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($projects as $project)
                    <div class="research-item bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow" 
                         data-curriculum="{{ $project->curriculum }}"
                         data-year="{{ $project->created_at->format('Y') }}">
                        <img src="{{ asset('storage/' . $project->banner_image) }}" 
                             alt="Project Banner" 
                             class="w-full h-48 object-cover rounded-t-lg">
                        
                        <div class="p-4">
                            <h3 class="font-bold text-xl mb-2">{{ $project->project_name }}</h3>
                            
                            <div class="mb-3 text-gray-600">
                                <p><span class="font-semibold">Authors:</span> {{ $project->members }}</p>
                                <p><span class="font-semibold">Curriculum:</span> {{ $project->curriculum }}</p>
                                <p><span class="font-semibold">Published:</span> 
                                    {{ $project->created_at->format('F d, Y') }}
                                </p>
                            </div>

                            <a href="{{ route('research.show', $project->id) }}" 
                               class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        No research papers found for this department.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        const curriculumFilter = document.getElementById('curriculum-filter');
        const yearFilter = document.getElementById('year-filter');
        const researchItems = document.querySelectorAll('.research-item');

        function filterItems() {
            const selectedCurriculum = curriculumFilter.value;
            const selectedYear = yearFilter.value;

            researchItems.forEach(item => {
                const matchesCurriculum = selectedCurriculum === 'all' || 
                                        item.dataset.curriculum === selectedCurriculum;
                const matchesYear = selectedYear === 'all' || 
                                  item.dataset.year === selectedYear;

                if (matchesCurriculum && matchesYear) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        curriculumFilter.addEventListener('change', filterItems);
        yearFilter.addEventListener('change', filterItems);
    </script>
</x-app-layout>