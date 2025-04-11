<x-app-layout>
    <!-- Hero Section with Parallax Effect -->
    <div class="relative h-[100vh] bg-gradient-to-r from-blue-900/95 to-blue-800/90 pt-16 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div x-data="carousel" class="relative w-full h-full">
                <!-- Carousel slides -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="currentSlide === index" 
                         x-transition:enter="transition ease-out duration-1000"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute inset-0">
                        <div class="absolute inset-0 bg-black/90"></div>
                        <div class="absolute inset-0 bg-gradient-to-b from-black/90 to-black/90"></div>
                        <img :src="slide.image" :alt="slide.alt" 
                             class="w-full h-full object-cover transform scale-105 opacity-75">
                    </div>
                </template>

                <!-- Dots navigation -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2 z-20">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="currentSlide = index" 
                                :class="{'bg-white': currentSlide === index, 'bg-white/50': currentSlide !== index}"
                                class="w-2 h-2 rounded-full transition-all duration-300">
                        </button>
                    </template>
                </div>
            </div>
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

    <!-- Featured Research Papers Section -->
    <div class="bg-white py-16 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900">Featured Research</h2>
                <p class="mt-4 text-lg text-gray-600">Explore the most impactful submissions in our archive</p>
            </div>

            <!-- Tabs Navigation -->
            <div class="mb-8 border-b border-gray-200" x-data="{ activeTab: 'recent' }">
                <div class="flex flex-wrap -mb-px">
                    <button @click="activeTab = 'recent'" :class="{'border-blue-500 text-blue-600': activeTab === 'recent'}" 
                            class="mr-8 py-4 px-1 border-b-2 font-medium text-sm sm:text-base transition-colors duration-200 whitespace-nowrap">
                        <i class="fas fa-clock mr-2"></i> Most Recent
                    </button>
                    <button @click="activeTab = 'viewed'" :class="{'border-blue-500 text-blue-600': activeTab === 'viewed'}" 
                            class="mr-8 py-4 px-1 border-b-2 font-medium text-sm sm:text-base transition-colors duration-200 whitespace-nowrap">
                        <i class="fas fa-eye mr-2"></i> Most Viewed
                    </button>
                    <button @click="activeTab = 'popular'" :class="{'border-blue-500 text-blue-600': activeTab === 'popular'}" 
                            class="py-4 px-1 border-b-2 font-medium text-sm sm:text-base transition-colors duration-200 whitespace-nowrap">
                        <i class="fas fa-star mr-2"></i> Most Popular
                    </button>
                </div>

                <!-- Most Recent Tab -->
                <div x-show="activeTab === 'recent'" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($recentSubmissions as $project)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                             data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                     alt="Project Banner"
                                     class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                    {{ $project->curriculum }}
                                </div>
                                <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                    New
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
                                    <div class="flex justify-between mt-1">
                                        <p class="flex items-center">
                                            <i class="fas fa-eye w-5 text-gray-400"></i>
                                            <span class="ml-2">{{ $project->view_count ?? 0 }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-download w-5 text-gray-400"></i>
                                            <span class="ml-2">{{ $project->download_count ?? 0 }}</span>
                                        </p>
                                    </div>
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

                <!-- Most Viewed Tab -->
                <div x-show="activeTab === 'viewed'" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($mostViewedSubmissions as $project)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                             data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                     alt="Project Banner"
                                     class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                    {{ $project->curriculum }}
                                </div>
                                <div class="absolute top-4 left-4 bg-purple-500 text-white px-3 py-1 rounded-full text-xs flex items-center">
                                    <i class="fas fa-eye mr-1"></i> {{ $project->view_count ?? 0 }}
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
                                        <i class="fas fa-building w-5 text-blue-500"></i>
                                        <span class="ml-2">{{ $project->department }}</span>
                                    </p>
                                    <div class="flex justify-between mt-1">
                                        <p class="flex items-center text-purple-600 font-semibold">
                                            <i class="fas fa-eye w-5"></i>
                                            <span class="ml-2">{{ $project->view_count ?? 0 }} views</span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-download w-5 text-gray-400"></i>
                                            <span class="ml-2">{{ $project->download_count ?? 0 }}</span>
                                        </p>
                                    </div>
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

                <!-- Most Popular Tab -->
                <div x-show="activeTab === 'popular'" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($mostPopularSubmissions as $project)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                             data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="relative">
                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                     alt="Project Banner"
                                     class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                    {{ $project->curriculum }}
                                </div>
                                <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full text-xs flex items-center">
                                    <i class="fas fa-star mr-1"></i> Trending
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
                                        <i class="fas fa-building w-5 text-blue-500"></i>
                                        <span class="ml-2">{{ $project->department }}</span>
                                    </p>
                                    <div class="flex justify-between mt-1">
                                        <p class="flex items-center">
                                            <i class="fas fa-eye w-5 text-amber-500"></i>
                                            <span class="ml-2">{{ $project->view_count ?? 0 }}</span>
                                        </p>
                                        <p class="flex items-center">
                                            <i class="fas fa-download w-5 text-amber-500"></i>
                                            <span class="ml-2">{{ $project->download_count ?? 0 }}</span>
                                        </p>
                                    </div>
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
                    @if(!empty($department))
                        <a href="{{ route('department.show', ['department' => $department]) }}" 
                           class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100 group-hover:border-blue-500">
                                <div class="text-4xl mb-4 text-blue-500 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-building"></i>
                                </div>
                                <h3 class="font-semibold text-lg mb-2 text-gray-800">{{ $department }}</h3>
                                <p class="text-gray-600">{{ count($projects) }} Research Papers</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- NEW SECTION: Dissertations & Theses -->
    <div class="py-12 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-900">Academic Works</h2>
                <p class="mt-4 text-lg text-gray-600">Explore our collection of dissertations and theses</p>
            </div>
            
            <!-- Academic Works Tabs -->
            <div class="mb-8 border-b border-gray-200" x-data="{ activeAcademicTab: 'dissertations' }">
                <div class="flex flex-wrap -mb-px">
                    <button @click="activeAcademicTab = 'dissertations'" 
                            :class="{'border-blue-500 text-blue-600': activeAcademicTab === 'dissertations'}" 
                            class="mr-8 py-4 px-1 border-b-2 font-medium text-sm sm:text-base transition-colors duration-200 whitespace-nowrap">
                        <i class="fas fa-book mr-2"></i> Dissertations
                    </button>
                    <button @click="activeAcademicTab = 'theses'" 
                            :class="{'border-blue-500 text-blue-600': activeAcademicTab === 'theses'}" 
                            class="py-4 px-1 border-b-2 font-medium text-sm sm:text-base transition-colors duration-200 whitespace-nowrap">
                        <i class="fas fa-scroll mr-2"></i> Theses
                    </button>
                </div>
                
                <!-- Dissertations Tab -->
                <div x-show="activeAcademicTab === 'dissertations'" class="mt-6">
                    @php
                        $dissertationsByDepartment = App\Models\Dissertation::where('type', 'dissertation')
                                                    ->where('status', 'approved')
                                                    ->get()
                                                    ->groupBy('department');
                    @endphp
                    
                    @forelse($dissertationsByDepartment as $department => $dissertations)
                        <div class="mb-12" data-aos="fade-up">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $department }}</h3>
                                <a href="{{ route('dissertation.index', ['department' => $department, 'type' => 'dissertation']) }}" 
                                   class="text-blue-500 hover:text-blue-600 font-medium">
                                    View All <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($dissertations->take(3) as $dissertation)
                                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                                         data-aos="fade-up"
                                         data-aos-delay="{{ $loop->index * 100 }}">
                                        <div class="relative">
                                            <div class="w-full h-48 bg-gradient-to-r from-blue-600 to-indigo-800 flex items-center justify-center">
                                                <i class="fas fa-book text-6xl text-white opacity-30"></i>
                                            </div>
                                            <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                                Dissertation
                                            </div>
                                            <div class="absolute top-4 left-4 bg-indigo-500 text-white px-3 py-1 rounded-full text-xs flex items-center">
                                                {{ $dissertation->year }}
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <h4 class="font-bold text-xl mb-3 text-gray-900 line-clamp-2">
                                                {{ Str::limit($dissertation->title, 60, '...') }}
                                            </h4>

                                            <div class="space-y-2 mb-4 text-gray-600 text-sm">
                                                <p class="flex items-center">
                                                    <i class="fas fa-user w-5 text-blue-500"></i>
                                                    <span class="ml-2">{{ $dissertation->author }}</span>
                                                </p>
                                                <p class="flex items-center">
                                                    <i class="fas fa-graduation-cap w-5 text-blue-500"></i>
                                                    <span class="ml-2">{{ $dissertation->department }}</span>
                                                </p>
                                                <p class="flex items-center">
                                                    <i class="fas fa-tags w-5 text-blue-500"></i>
                                                    <span class="ml-2">{{ Str::limit($dissertation->keywords, 40, '...') }}</span>
                                                </p>
                                            </div>

                                            <a href="{{ route('dissertation.show', $dissertation->id) }}"
                                               class="inline-flex items-center justify-center w-full bg-gray-50 text-blue-500 px-4 py-2 rounded-lg hover:bg-blue-500 hover:text-white transition-colors duration-300 font-medium">
                                                View Details
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">No dissertations available at this time.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Theses Tab -->
                <div x-show="activeAcademicTab === 'theses'" class="mt-6">
                    @php
                        $thesesByDepartment = App\Models\Dissertation::where('type', 'thesis')
                                             ->where('status', 'approved')
                                             ->get()
                                             ->groupBy('department');
                    @endphp
                    
                    @forelse($thesesByDepartment as $department => $theses)
                        <div class="mb-12" data-aos="fade-up">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $department }}</h3>
                                <a href="{{ route('dissertation.index', ['department' => $department, 'type' => 'thesis']) }}" 
                                   class="text-blue-500 hover:text-blue-600 font-medium">
                                    View All <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach($theses->take(3) as $thesis)
                                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                                         data-aos="fade-up"
                                         data-aos-delay="{{ $loop->index * 100 }}">
                                        <div class="relative">
                                            <div class="w-full h-48 bg-gradient-to-r from-green-600 to-teal-800 flex items-center justify-center">
                                                <i class="fas fa-scroll text-6xl text-white opacity-30"></i>
                                            </div>
                                            <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                                Thesis
                                            </div>
                                            <div class="absolute top-4 left-4 bg-teal-500 text-white px-3 py-1 rounded-full text-xs flex items-center">
                                                {{ $thesis->year }}
                                            </div>
                                        </div>

                                        <div class="p-6">
                                            <h4 class="font-bold text-xl mb-3 text-gray-900 line-clamp-2">
                                                {{ Str::limit($thesis->title, 60, '...') }}
                                            </h4>

                                            <div class="space-y-2 mb-4 text-gray-600 text-sm">
                                                <p class="flex items-center">
                                                    <i class="fas fa-user w-5 text-green-500"></i>
                                                    <span class="ml-2">{{ $thesis->author }}</span>
                                                </p>
                                                <p class="flex items-center">
                                                    <i class="fas fa-graduation-cap w-5 text-green-500"></i>
                                                    <span class="ml-2">{{ $thesis->department }}</span>
                                                </p>
                                                <p class="flex items-center">
                                                    <i class="fas fa-tags w-5 text-green-500"></i>
                                                    <span class="ml-2">{{ Str::limit($thesis->keywords, 40, '...') }}</span>
                                                </p>
                                            </div>

                                            <a href="{{ route('dissertation.show', $thesis->id) }}"
                                               class="inline-flex items-center justify-center w-full bg-gray-50 text-green-500 px-4 py-2 rounded-lg hover:bg-green-500 hover:text-white transition-colors duration-300 font-medium">
                                                View Details
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-scroll text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">No theses available at this time.</p>
                        </div>
                    @endforelse
                </div>
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
                        @if(!empty($department))
                            <a href="{{ route('department.show', ['department' => $department]) }}" 
                               class="text-blue-500 hover:text-blue-600 font-medium">
                                View All <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @endif
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
                                        <div class="flex justify-between mt-1">
                                            <p class="flex items-center">
                                                <i class="fas fa-eye w-5 text-gray-400"></i>
                                                <span class="ml-2">{{ $project->view_count ?? 0 }}</span>
                                            </p>
                                            <p class="flex items-center">
                                                <i class="fas fa-download w-5 text-gray-400"></i>
                                                <span class="ml-2">{{ $project->download_count ?? 0 }}</span>
                                            </p>
                                        </div>
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('carousel', () => ({
                currentSlide: 0,
                slides: [
                    { image: '{{ asset("images/image5.jpg") }}', alt: 'Library Background 1' },
                    { image: '{{ asset("images/image4.jpg") }}', alt: 'Library Background 2' },
                    { image: '{{ asset("images/image3.jpg") }}', alt: 'Library Background 3' }
                ],
                init() {
                    setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    }, 5000); // Change slide every 5 seconds
                }
            }));
        });
    </script>
</x-app-layout>