<x-app-layout>
    <!-- Hero Section with Parallax Effect -->
    <div class="relative h-[100vh] bg-gradient-to-r from-blue-900/95 to-blue-800/90 pt-16 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <!-- Increased opacity of the black overlay from 80% to 90% -->
            <div class="absolute inset-0 bg-black/100"></div>
            <!-- Added a darker gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/90 to-black/90"></div>
            <img src="{{ asset('images/image.jpg') }}" alt="Library Background" 
                 class="w-full h-full object-cover transform scale-105 motion-safe:animate-subtle-zoom opacity-75">
        </div>

        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-bold mb-6 text-white leading-tight animate-fade-in drop-shadow-lg">
                    <span class="text-yellow-500">Preserving</span> Knowledge
                    
                        Empowering
                
                    <span class="text-blue-500">Research</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl text-gray-100 mb-8 max-w-3xl mx-auto px-4 leading-relaxed animate-fade-in-delayed drop-shadow-lg">
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

    <!-- Department Cards Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center" data-aos="fade-up">
                Academic Departments
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($departments as $department => $projects)
                    <a href="{{ route('department.show', ['department' => urlencode($department)]) }}" 
                       class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100 group-hover:border-blue-500">
                            <div class="text-4xl mb-4 text-blue-500 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-building"></i>
                            </div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-800">{{ $department }}</h3>
                            <p class="text-gray-600">{{ count($projects) }} Research Papers</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Research Papers Grid -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($departments as $department => $projects)
                <div class="mb-12" data-aos="fade-up">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $department }}</h3>
                        <a href="{{ route('department.show', ['department' => urlencode($department)]) }}" 
                           class="text-blue-500 hover:text-blue-600 font-medium">
                            View All <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($projects as $project)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                                 data-aos="fade-up"
                                 data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                         alt="Project Banner"
                                         class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-300">
                                    <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                        {{ $project->curriculum }}
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h4 class="font-bold text-xl mb-3 text-gray-900 line-clamp-2">
                                        {{ Str::limit($project->project_name, 60, '...') }}
                                    </h4>

                                    <div class="space-y-2 mb-4 text-gray-600 text-sm">
                                        <p class="flex items-center">
                                            <i class="fas fa-users w-5 text-blue-500"></i>
                                            <span class="ml-2">{{ Str::limit($project->members, 40, '...') }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-calendar-alt w-5 text-blue-500"></i>
                                            <span class="ml-2">{{ $project->created_at->format('F d, Y') }}</span>
                                        </p>
                                    </div>

                                    <a href="{{ route('research.show', $project->id) }}"
                                        class="inline-flex items-center justify-center w-full bg-gray-50 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white transition-colors duration-300 font-medium">
                                        View Details
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @include('layouts.footer')

    <!-- Add custom styles -->
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-in;
        }
        .animate-fade-in-delayed {
            animation: fadeIn 1s ease-in 0.5s both;
        }
        .animate-subtle-zoom {
            animation: subtleZoom 20s infinite alternate;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes subtleZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }
    </style>
</x-app-layout>