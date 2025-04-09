<x-app-layout>
    <!-- Hero Section -->
    <div class="relative h-[100vh] bg-gradient-to-r from-blue-800/100 to-blue-600/80 pt-16"> <!-- Added pt-16 for navbar offset -->
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/60"></div>
            <img src="{{ asset('images/image.jpg') }}" alt="Library Background" class="w-full h-full object-cover">
        </div>

        <!-- Content Overlay -->
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold mb-4 text-white leading-tight">
                    Preserving Knowledge Empowering Research
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-white mb-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 leading-relaxed">
                    Discover, Access, and Contribute to the University of Southern Philippines Foundation's digital
                    archive of research papers.
                </p>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
                <p class="mt-4 text-lg text-gray-600">Understanding USPF's Research Archive System</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                <!-- Step 1 -->
                <div class="relative p-6 bg-white rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">1</div>
                    <div class="pt-4">
                        <h3 class="text-xl font-semibold mb-3">Search & Discover</h3>
                        <p class="text-gray-600 mb-4">Use our powerful search to find research papers by title, author, department, or keywords.</p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Advanced search filters
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Real-time suggestions
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative p-6 bg-white rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">2</div>
                    <div class="pt-4">
                        <h3 class="text-xl font-semibold mb-3">Access & Review</h3>
                        <p class="text-gray-600 mb-4">View detailed information about research papers including abstracts, methodologies, and findings.</p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                PDF preview available
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Citation formats provided
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative p-6 bg-white rounded-lg shadow-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute -top-4 -left-4 w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">3</div>
                    <div class="pt-4">
                        <h3 class="text-xl font-semibold mb-3">Collaborate & Share</h3>
                        <p class="text-gray-600 mb-4">Connect with other researchers and share knowledge across departments.</p>
                        <ul class="text-sm text-gray-500 space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Find related research
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-green-500 mr-2"></i>
                                Contact authors
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- System Features -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-gray-50 rounded-lg text-center" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-lock text-3xl text-blue-500 mb-4"></i>
                    <h4 class="font-semibold mb-2">Secure Access</h4>
                    <p class="text-sm text-gray-600">Protected research papers with authenticated access</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-lg text-center" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-quote-right text-3xl text-blue-500 mb-4"></i>
                    <h4 class="font-semibold mb-2">Citation Tools</h4>
                    <p class="text-sm text-gray-600">Generate citations in APA, IEEE formats</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-lg text-center" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-chart-line text-3xl text-blue-500 mb-4"></i>
                    <h4 class="font-semibold mb-2">Analytics</h4>
                    <p class="text-sm text-gray-600">Track research impact and views</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-lg text-center" data-aos="zoom-in" data-aos-delay="400">
                    <i class="fas fa-mobile-alt text-3xl text-blue-500 mb-4"></i>
                    <h4 class="font-semibold mb-2">Mobile Friendly</h4>
                    <p class="text-sm text-gray-600">Access research on any device</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Browse by Department Section -->
            <div class="mb-8" data-aos="fade-up">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Browse by Department</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($departments as $department => $projects)
                        <a href="{{ route('department.show', ['department' => urlencode($department)]) }}" 
                           class="block" 
                           data-aos="fade-up" 
                           data-aos-delay="{{ $loop->index * 100 }}">
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
                <div class="bg-white shadow-md rounded-lg p-6 mb-6" data-aos="fade-up">
                    <h3 class="text-lg font-semibold mb-4">{{ $department }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($projects as $project)
                            <div class="bg-white border rounded-lg shadow-lg hover:shadow-xl transition-shadow"
                                 data-aos="fade-up"
                                 data-aos-delay="{{ $loop->index * 100 }}">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" alt="Project Banner"
                                    class="w-full h-48 object-cover rounded-t-lg">

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

    <!-- Include Footer -->
    @include('layouts.footer')

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