<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-3xl font-bold mb-8">{{ $department }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($projects as $project)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                         alt="Project Banner"
                                         class="w-full h-48 object-cover">
                                    <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm">
                                        {{ $project->curriculum }}
                                    </div>
                                </div>

                                <div class="p-6">
                                    <h4 class="font-bold text-xl mb-3 text-gray-900 line-clamp-2">
                                        {{ $project->project_name }}
                                    </h4>

                                    <div class="space-y-2 mb-4 text-gray-600 text-sm">
                                        <p class="flex items-center">
                                            <i class="fas fa-users w-5 text-blue-500"></i>
                                            <span class="ml-2">{{ $project->members }}</span>
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
            </div>
        </div>
    </div>
</x-app-layout>