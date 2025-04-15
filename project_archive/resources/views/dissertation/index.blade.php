
<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Academic Works Repository
                </h1>
                <p class="mt-2 text-gray-600">
                    Browse dissertations and theses from our academic collection
                </p>
            </div>
            
            <!-- Filters -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <form action="{{ route('dissertation.index') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Types</option>
                                <option value="dissertation" {{ request('type') == 'dissertation' ? 'selected' : '' }}>Dissertations</option>
                                <option value="thesis" {{ request('type') == 'thesis' ? 'selected' : '' }}>Theses</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <select id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Departments</option>
                                @php
                                    $departments = \App\Models\Dissertation::distinct()->pluck('department');
                                @endphp
                                @foreach($departments as $department)
                                    <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>{{ $department }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <select id="year" name="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Years</option>
                                @php
                                    $years = \App\Models\Dissertation::distinct()->pluck('year')->sort()->reverse();
                                @endphp
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search by title, author or keywords..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-filter mr-2"></i> Apply Filters
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Results -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow-sm">
                <p class="text-gray-600">
                    Showing {{ $dissertations->firstItem() ?? 0 }} - {{ $dissertations->lastItem() ?? 0 }} of {{ $dissertations->total() }} results
                </p>
            </div>
            
            <!-- Dissertations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($dissertations as $dissertation)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100"
                         data-aos="fade-up">
                        <div class="relative">
                            @if($dissertation->type === 'dissertation')
                                <div class="w-full h-48 bg-gradient-to-r from-blue-600 to-indigo-800 flex items-center justify-center">
                                    <i class="fas fa-book text-6xl text-white opacity-30"></i>
                                </div>
                                <div class="absolute top-4 right-4 bg-indigo-500 text-white px-3 py-1 rounded-full text-sm">
                                    Dissertation
                                </div>
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-green-600 to-teal-800 flex items-center justify-center">
                                    <i class="fas fa-scroll text-6xl text-white opacity-30"></i>
                                </div>
                                <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                                    Thesis
                                </div>
                            @endif
                            
                            <div class="absolute top-4 left-4 bg-gray-700 text-white px-3 py-1 rounded-full text-xs flex items-center">
                                {{ $dissertation->year }}
                            </div>
                        </div>

                        <div class="p-6">
                            <h4 class="font-bold text-xl mb-3 text-gray-900 line-clamp-2">
                                {{ Str::limit($dissertation->title, 60, '...') }}
                            </h4>

                            <div class="space-y-2 mb-4 text-gray-600 text-sm">
                                <p class="flex items-center">
                                    <i class="fas fa-user w-5 text-{{ $dissertation->type === 'dissertation' ? 'indigo' : 'green' }}-500"></i>
                                    <span class="ml-2">{{ $dissertation->author }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-graduation-cap w-5 text-{{ $dissertation->type === 'dissertation' ? 'indigo' : 'green' }}-500"></i>
                                    <span class="ml-2">{{ $dissertation->department }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-tags w-5 text-{{ $dissertation->type === 'dissertation' ? 'indigo' : 'green' }}-500"></i>
                                    <span class="ml-2">{{ Str::limit($dissertation->keywords, 40, '...') }}</span>
                                </p>
                                
                                <div class="flex justify-between mt-2">
                                    <p class="flex items-center">
                                        <i class="fas fa-eye w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $dissertation->view_count ?? 0 }}</span>
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-download w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ $dissertation->download_count ?? 0 }}</span>
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('dissertation.show', $dissertation->id) }}"
                               class="inline-flex items-center justify-center w-full bg-gray-50 text-{{ $dissertation->type === 'dissertation' ? 'indigo' : 'green' }}-500 px-4 py-2 rounded-lg hover:bg-{{ $dissertation->type === 'dissertation' ? 'indigo' : 'green' }}-500 hover:text-white transition-colors duration-300 font-medium">
                                View Details
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow">
                        <i class="fas fa-search text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No dissertations or theses found matching your criteria.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $dissertations->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>