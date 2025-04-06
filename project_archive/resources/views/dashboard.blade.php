<x-app-layout>
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">
                Preserving Knowledge, Empowering Research
            </h1>
            <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                Discover, Access, and Contribute to the University of Southern Philippines Foundation's digital archive of research papers.
            </p>
            
            <!-- Search Form -->
            <div class="max-w-2xl mx-auto">
                <form method="GET" action="{{ route('dashboard') }}" class="relative">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               id="search-input"
                               value="{{ request('search') }}"
                               placeholder="Search research papers..." 
                               class="w-full px-6 py-4 rounded-lg shadow-lg text-gray-800 text-lg border-0 focus:ring-2 focus:ring-blue-400"
                               autocomplete="off">
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                    <div id="search-recommendations" 
                         class="absolute z-10 w-full bg-white border rounded-lg shadow-lg mt-2 hidden text-left">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Browse by Department Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Browse by Department</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($departments as $department => $projects)
                        <a href="{{ route('department.show', ['department' => urlencode($department)]) }}" 
                           class="block">
                            <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow p-6 text-center">
                                <div class="text-4xl mb-4">
                                    <i class="fas fa-building text-blue-500"></i>
                                </div>
                                <h3 class="font-semibold text-lg mb-2">{{ $department }}</h3>
                                <p class="text-gray-600">{{ count($projects) }} Research Papers</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            @foreach($departments as $department => $projects)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">{{ $department }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $project)
                            <div class="bg-white border rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                    alt="Project Banner" class="w-full h-48 object-cover rounded-t-lg">
                                
                                <div class="p-4">
                                    <h4 class="font-bold text-xl mb-2">{{ $project->project_name }}</h4>
                                    
                                    <div class="mb-3 text-gray-600">
                                        <p><span class="font-semibold">Authors:</span> {{ $project->members }}</p>
                                        <p><span class="font-semibold">Department:</span> {{ $project->department }}</p>
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
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search-input');
        const recommendationsContainer = document.getElementById('search-recommendations');

        searchInput.addEventListener('input', async (e) => {
            const searchTerm = e.target.value;
            console.log('Search term:', searchTerm); // Debug log
            
            if (searchTerm.length < 2) {
                recommendationsContainer.classList.add('hidden');
                return;
            }

            try {
                const url = `${window.location.protocol}//${window.location.host}/search-recommendations?term=${encodeURIComponent(searchTerm)}`;
                console.log('Fetching URL:', url); // Debug log

                const response = await fetch(url);
                
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
                }
                
                const recommendations = await response.json();
                console.log('Received recommendations:', recommendations); // Debug log
                
                if (recommendations && recommendations.length > 0) {
                    const html = recommendations
                        .map(item => `
                            <div class="p-2 hover:bg-gray-100 cursor-pointer recommendation-item">
                                <div class="font-medium">${item.project_name}</div>
                                <div class="text-sm text-gray-600">${item.department}</div>
                            </div>
                        `).join('');
                        
                    recommendationsContainer.innerHTML = html;
                    recommendationsContainer.classList.remove('hidden');
                    
                    // Add click handlers for recommendations
                    document.querySelectorAll('.recommendation-item').forEach(item => {
                        item.addEventListener('click', () => {
                            searchInput.value = item.querySelector('.font-medium').textContent;
                            recommendationsContainer.classList.add('hidden');
                            searchInput.form.submit();
                        });
                    });
                } else {
                    recommendationsContainer.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error fetching recommendations:', error);
                recommendationsContainer.classList.add('hidden');
            }
        });

        // Hide recommendations when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !recommendationsContainer.contains(e.target)) {
                recommendationsContainer.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
