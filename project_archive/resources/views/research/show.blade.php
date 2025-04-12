<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Top Stats Bar - Fixed position for easy access -->
            <div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-20 rounded-t-lg">
                <div class="px-4 py-4 sm:px-6 flex flex-wrap items-center justify-between">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-gray-900 mr-4 truncate max-w-lg">
                            {{ $project->project_name }}
                        </h1>
                        <div class="hidden sm:flex items-center space-x-4 ml-4">
                            <!-- Views Counter -->
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>{{ number_format($project->view_count ?? 0) }}</span>
                            </div>
                            
                            <!-- Downloads Counter -->
                            <div class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>{{ number_format($project->download_count ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <button data-download-trigger 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Download
                        </button>
                        
                        <a href="{{ url()->previous() }}" 
                            class="text-gray-600 hover:text-gray-800 flex items-center text-sm font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            @if($project)
                <!-- Main Content with Sidebar Tabs -->
                <div class="bg-white overflow-hidden shadow-sm rounded-b-lg flex flex-col md:flex-row" x-data="{ activeTab: 'overview' }">
                    <!-- Sidebar Navigation -->
                    <div class="w-full md:w-64 bg-gray-50 border-r border-gray-200">
                        <div class="p-4 border-b border-gray-200 bg-white">
                            <div class="flex flex-col">
                                <h2 class="text-lg font-semibold text-gray-800">Research Details</h2>
                                <p class="text-sm text-gray-500">{{ $project->department }}</p>
                            </div>
                        </div>

                        <!-- Tabs Navigation -->
                        <nav class="flex flex-col p-2 space-y-1">
                            <button @click="activeTab = 'overview'" 
                                    :class="{'bg-blue-50 text-blue-700 border-l-4 border-blue-600': activeTab === 'overview',
                                            'text-gray-700 hover:bg-gray-100': activeTab !== 'overview'}"
                                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Overview
                            </button>

                            <button @click="activeTab = 'abstract'" 
                                    :class="{'bg-blue-50 text-blue-700 border-l-4 border-blue-600': activeTab === 'abstract',
                                            'text-gray-700 hover:bg-gray-100': activeTab !== 'abstract'}"
                                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Abstract
                            </button>

                            <button @click="activeTab = 'document'" 
                                    :class="{'bg-blue-50 text-blue-700 border-l-4 border-blue-600': activeTab === 'document',
                                            'text-gray-700 hover:bg-gray-100': activeTab !== 'document'}"
                                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                Document
                            </button>

                            <button @click="activeTab = 'citation'" 
                                    :class="{'bg-blue-50 text-blue-700 border-l-4 border-blue-600': activeTab === 'citation',
                                            'text-gray-700 hover:bg-gray-100': activeTab !== 'citation'}"
                                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                                Citation
                            </button>

                            <button @click="activeTab = 'related'" 
                                    :class="{'bg-blue-50 text-blue-700 border-l-4 border-blue-600': activeTab === 'related',
                                            'text-gray-700 hover:bg-gray-100': activeTab !== 'related'}"
                                    class="flex items-center px-4 py-3 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                Related
                            </button>

                            <div class="pt-4 mt-4 border-t border-gray-200">
                                <button onclick="toggleToc()" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                    Table of Contents
                                </button>

                                <button onclick="copyToClipboard()" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                    Share
                                </button>
                            </div>
                        </nav>

                        <!-- Mobile Stats (visible on small screens) -->
                        <div class="md:hidden border-t border-gray-200 p-4">
                            <div class="flex justify-around">
                                <!-- Views Counter -->
                                <div class="flex flex-col items-center">
                                    <div class="text-xl font-bold text-blue-600">{{ number_format($project->view_count ?? 0) }}</div>
                                    <div class="text-xs text-gray-500">Views</div>
                                </div>
                                
                                <!-- Downloads Counter -->
                                <div class="flex flex-col items-center">
                                    <div class="text-xl font-bold text-green-600">{{ number_format($project->download_count ?? 0) }}</div>
                                    <div class="text-xs text-gray-500">Downloads</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="flex-1 overflow-auto">
                        <!-- Tab Panels -->
                        <div class="p-6">
                            <!-- Overview Tab Panel -->
                            <div x-show="activeTab === 'overview'" class="space-y-6 animate-fadeIn">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">Research Overview</h2>
                                    <p class="text-sm text-gray-500 mt-1 sm:mt-0">
                                        Published: {{ $project->created_at->format('F d, Y') }}
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2 space-y-4">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">Research Information</h3>
                                            <div class="mt-2 space-y-2 text-gray-700">
                                                <p><span class="font-medium text-gray-900">Department:</span> {{ $project->department }}</p>
                                                <p><span class="font-medium text-gray-900">Curriculum:</span> {{ $project->curriculum }}</p>
                                            </div>
                                        </div>

                                        <!-- Authors Section -->
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">Authors</h3>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                @foreach(explode(',', $project->members) as $member)
                                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                                        {{ trim($member) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Research Brief -->
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">Research Brief</h3>
                                            <div class="mt-2 prose max-w-none text-gray-700">
                                                <p>{{ Str::limit(strip_tags(html_entity_decode($project->abstract)), 300) }}</p>
                                                <button @click="activeTab = 'abstract'" class="text-blue-600 hover:text-blue-800 text-sm mt-2">
                                                    Read full abstract →
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        @if($project->banner_image)
                                            <div class="rounded-lg overflow-hidden shadow-md">
                                                <img src="{{ asset('storage/' . $project->banner_image) }}" 
                                                    alt="Research Banner"
                                                    class="w-full h-auto object-cover">
                                            </div>
                                        @endif

                                        <!-- Quick Links -->
                                        <div class="mt-6 bg-gray-50 rounded-lg p-4">
                                            <h3 class="font-medium text-gray-900 mb-3">Quick Actions</h3>
                                            <div class="space-y-2">
                                                <button @click="activeTab = 'document'" class="flex items-center text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    Read Full Document
                                                </button>
                                                <button @click="activeTab = 'citation'" class="flex items-center text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                    </svg>
                                                    Get Citation
                                                </button>
                                                <button data-download-trigger class="flex items-center text-blue-600 hover:text-blue-800">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Download Research
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Stats Card -->
                                <div class="bg-gray-50 rounded-lg p-5 mt-6">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div class="text-center p-3">
                                            <div class="text-3xl font-bold text-blue-600">{{ number_format($project->view_count ?? 0) }}</div>
                                            <div class="text-sm text-gray-500 mt-1">Total Views</div>
                                        </div>
                                        <div class="text-center p-3">
                                            <div class="text-3xl font-bold text-green-600">{{ number_format($project->download_count ?? 0) }}</div>
                                            <div class="text-sm text-gray-500 mt-1">Downloads</div>
                                        </div>
                                        <div class="text-center p-3">
                                            <div class="text-3xl font-bold text-purple-600">{{ count(explode(',', $project->members)) }}</div>
                                            <div class="text-sm text-gray-500 mt-1">Authors</div>
                                        </div>
                                        <div class="text-center p-3">
                                            <div class="text-3xl font-bold text-amber-600">{{ $project->created_at->diffForHumans() }}</div>
                                            <div class="text-sm text-gray-500 mt-1">Published</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Abstract Tab Panel -->
                            <div x-show="activeTab === 'abstract'" class="space-y-6 animate-fadeIn">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">Abstract</h2>
                                </div>

                                @if($project->abstract)
                                    <div class="bg-gray-50 p-6 rounded-lg">
                                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                                            {!! strip_tags(html_entity_decode($project->abstract), '<br><p>') !!}
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-yellow-50 p-4 rounded-lg text-yellow-800">
                                        No abstract available for this research.
                                    </div>
                                @endif

                                <div class="flex justify-end pt-4">
                                    <button @click="activeTab = 'document'" class="flex items-center text-blue-600 hover:text-blue-800">
                                        Continue to Document
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Document Tab Panel -->
                            <div x-show="activeTab === 'document'" class="space-y-6 animate-fadeIn" id="documentTab">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">Research Document</h2>
                                </div>

                                <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                                    <!-- PDF Viewer Toolbar -->
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 sticky top-0 z-10">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <!-- Left Controls -->
                                            <div class="flex items-center space-x-2">
                                                <div class="flex items-center space-x-1 rounded-lg bg-white border border-gray-200 px-2 py-1">
                                                    <button onclick="zoomOut()" class="hover:text-blue-600 p-1" title="Zoom Out">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                        </svg>
                                                    </button>
                                                    <span id="zoomLevel" class="text-sm font-medium text-gray-700 w-12 text-center">100%</span>
                                                    <button onclick="zoomIn()" class="hover:text-blue-600 p-1" title="Zoom In">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Page Navigation -->
                                                <div class="flex items-center bg-white border border-gray-200 rounded-lg">
                                                    <button onclick="previousPage()" class="px-2 py-1 hover:bg-gray-100 border-r border-gray-200" title="Previous Page">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                        </svg>
                                                    </button>
                                                    <div class="text-sm px-3 py-1 border-r border-gray-200">
                                                        <span id="currentPage" class="font-medium">1</span>/<span id="totalPages" class="font-medium">-</span>
                                                    </div>
                                                    <button onclick="nextPage()" class="px-2 py-1 hover:bg-gray-100" title="Next Page">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Right Controls -->
                                            <div class="flex items-center space-x-2">
                                                <button onclick="toggleToc()" class="flex items-center px-2 py-1 text-sm text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                                    </svg>
                                                    Contents
                                                </button>
                                                <button onclick="toggleFullscreen()" class="flex items-center bg-blue-50 text-blue-600 px-2 py-1 text-sm rounded-lg hover:bg-blue-100 transition-colors">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="M4 8V4m0 0h4M4 4l5 5m11-5V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"/>
                                                    </svg>
                                                    Fullscreen
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PDF Viewer with TOC Sidebar -->
                                    <div class="flex w-full relative">
                                        <!-- TOC Sidebar (toggleable) -->
                                        <div id="tocSidebar" class="hidden w-64 border-r border-gray-200 h-[600px] bg-white overflow-y-auto p-4">
                                            <h3 class="font-semibold text-gray-800 mb-3">Document Contents</h3>
                                            <div id="tocContent" class="space-y-2">
                                                <div class="animate-pulse space-y-2">
                                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                                    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                                                    <div class="h-4 bg-gray-200 rounded w-2/3"></div>
                                                    <div class="h-4 bg-gray-200 rounded w-4/5"></div>
                                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-4">Loading document structure...</p>
                                            </div>
                                        </div>
                                        
                                        <!-- PDF Viewer Container -->
                                        <div id="pdfContainer" class="relative flex-1">
                                            <!-- Loading overlay -->
                                            <div id="pdfLoadingOverlay" class="absolute inset-0 flex flex-col items-center justify-center bg-white bg-opacity-90 z-10">
                                                <div class="w-16 h-16 border-4 border-blue-400 border-t-blue-600 rounded-full animate-spin mb-4"></div>
                                                <p class="text-gray-700">Loading document...</p>
                                            </div>
                                            <div class="w-full h-[600px] bg-gray-100">
                                                <iframe id="pdfViewer"
                                                    src="{{ asset('storage/' . $project->file) }}#toolbar=0"
                                                    class="w-full h-full transition-transform duration-200 ease-in-out"
                                                    type="application/pdf"
                                                    onload="this.contentWindow.focus()">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                                        <div class="flex items-center space-x-2 text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                            <!-- Citation Tab Panel -->
                            <div x-show="activeTab === 'citation'" class="space-y-6 animate-fadeIn">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">Citation Formats</h2>
                                </div>

                                <div class="space-y-6">
                                    <div class="bg-gray-50 p-5 rounded-lg">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="font-semibold text-lg">APA Format</h3>
                                            <button onclick="copyCitation('apa-citation')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Copy
                                            </button>
                                        </div>
                                        <div id="apa-citation" class="bg-white p-4 rounded border border-gray-200 text-gray-700">
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
                                            <em>{{ $project->project_name }}</em>. 
                                            {{ $project->department }}, {{ $project->curriculum }}, 
                                            University of Southern Philippines Foundation.
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-5 rounded-lg">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="font-semibold text-lg">IEEE Format</h3>
                                            <button onclick="copyCitation('ieee-citation')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Copy
                                            </button>
                                        </div>
                                        <div id="ieee-citation" class="bg-white p-4 rounded border border-gray-200 text-gray-700">
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
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-5 rounded-lg">
                                        <div class="flex justify-between items-center mb-2">
                                            <h3 class="font-semibold text-lg">MLA Format</h3>
                                            <button onclick="copyCitation('mla-citation')" class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Copy
                                            </button>
                                        </div>
                                        <div id="mla-citation" class="bg-white p-4 rounded border border-gray-200 text-gray-700">
                                            @php
                                                $membersList = explode(',', $project->members);
                                                
                                                // Format first author for MLA (Last Name, First Name)
                                                $firstMember = array_shift($membersList);
                                                $firstMemberParts = array_map('trim', explode(' ', $firstMember));
                                                $firstName = implode(' ', array_slice($firstMemberParts, 0, -1));
                                                $lastName = end($firstMemberParts);
                                                $firstAuthorMLA = $lastName . ', ' . $firstName;
                                                
                                                // Format remaining authors (First Name Last Name)
                                                $otherAuthorsMLA = $membersList;
                                            @endphp
                                            {{ $firstAuthorMLA }}{{ !empty($otherAuthorsMLA) ? ', et al' : '' }}. 
                                            "<em>{{ $project->project_name }}</em>." 
                                            {{ $project->department }}, University of Southern Philippines Foundation, 
                                            {{ $project->created_at->format('Y') }}.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Related Tab Panel -->
                            <div x-show="activeTab === 'related'" class="space-y-6 animate-fadeIn">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <h2 class="text-2xl font-bold text-gray-900">Related Studies</h2>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php $relatedCount = 0; @endphp
                                    @foreach($relatedStudies ?? [] as $study)
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
                                            @php $relatedCount++; @endphp
                                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                                                <div class="flex justify-between items-start mb-3">
                                                    <h3 class="font-semibold text-lg text-gray-900">{{ $study->project_name }}</h3>
                                                </div>

                                                <div class="space-y-2 mb-3 text-gray-700">
                                                    <p class="text-sm">
                                                        <span class="font-medium">Department:</span> {{ $study->department }}
                                                    </p>
                                                    <p class="text-sm">
                                                        <span class="font-medium">Year:</span> {{ $study->created_at->format('Y') }}
                                                    </p>
                                                    
                                                    <!-- Show relationship indicators -->
                                                    <div class="flex flex-wrap gap-2 mt-2">
                                                        @if(!empty($commonKeywords))
                                                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">
                                                                Related Topics: {{ implode(', ', array_slice($commonKeywords, 0, 2)) }}{{ count($commonKeywords) > 2 ? '...' : '' }}
                                                            </span>
                                                        @endif
                                                        
                                                        @if($departmentMatch)
                                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                                                Same Department
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

                                    @if($relatedCount === 0)
                                        <div class="col-span-2 p-6 text-center bg-gray-50 rounded-lg">
                                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-gray-500">No related studies found based on keywords, department, or content.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Research Project Not Found</h3>
                    <p class="text-gray-500 mb-6">The research paper you are looking for might have been removed or is not available.</p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Return to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Improved Download Purpose Modal -->
    <div id="downloadModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Download Research Paper</h3>
                <button id="cancelDownloadX" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <p class="text-gray-600 mb-6">
                To help us improve our research repository, please let us know how you plan to use this document:
            </p>

            <form action="{{ route('research.download', $project) }}" method="POST" id="downloadForm">
                @csrf
                <div class="mb-6 space-y-3">
                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="thesis_reference" 
                            class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500" id="thesis_reference">
                        <label for="thesis_reference" class="text-gray-700">
                            <span class="font-medium block">For Thesis/Capstone Reference</span>
                            <span class="text-sm text-gray-500">Using as source material for your own academic work</span>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="literature_review" 
                            class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500" id="literature_review">
                        <label for="literature_review" class="text-gray-700">
                            <span class="font-medium block">Literature Review</span>
                            <span class="text-sm text-gray-500">Surveying existing research on this topic</span>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="research_work" 
                            class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500" id="research_work">
                        <label for="research_work" class="text-gray-700">
                            <span class="font-medium block">Research Work</span>
                            <span class="text-sm text-gray-500">Using for professional or academic research</span>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="academic_study" 
                            class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500" id="academic_study">
                        <label for="academic_study" class="text-gray-700">
                            <span class="font-medium block">Academic Study</span>
                            <span class="text-sm text-gray-500">Personal learning or coursework</span>
                        </label>
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" name="purpose[]" value="other" 
                            class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500" id="other_purpose">
                        <label for="other_purpose" class="text-gray-700">
                            <span class="font-medium block">Other Purpose</span>
                            <span class="text-sm text-gray-500">Please specify below</span>
                        </label>
                    </div>

                    <div id="otherPurposeField" class="hidden mt-3 pl-7">
                        <input type="text" name="other_purpose_text" 
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Please specify your purpose">
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelDownload" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        Download Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const downloadModal = document.getElementById('downloadModal');
        const downloadForm = document.getElementById('downloadForm');
        const checkboxes = downloadForm.querySelectorAll('input[type="checkbox"]');
        const otherCheckbox = document.getElementById('other_purpose');
        const otherPurposeField = document.getElementById('otherPurposeField');

        // Show modal when download button is clicked
        document.querySelectorAll('[data-download-trigger]').forEach(button => {
            button.addEventListener('click', () => {
                downloadModal.classList.remove('hidden');
                downloadModal.classList.add('flex');
            });
        });

        // Hide modal when cancel is clicked
        document.getElementById('cancelDownload').addEventListener('click', hideDownloadModal);
        document.getElementById('cancelDownloadX').addEventListener('click', hideDownloadModal);

        function hideDownloadModal() {
            downloadModal.classList.remove('flex');
            downloadModal.classList.add('hidden');
            // Reset form
            checkboxes.forEach(checkbox => checkbox.checked = false);
            otherPurposeField.classList.add('hidden');
        }

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
        let tocVisible = false;

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

        function updateZoom() {
            const viewer = document.getElementById('pdfViewer');
            viewer.style.transform = `scale(${currentZoom/100})`;
            viewer.style.transformOrigin = 'center top';
            zoomLevelDisplay.textContent = `${currentZoom}%`;
        }

        function nextPage() {
            showLoading();
            pdfViewer.contentWindow.postMessage({ type: 'nextPage' }, '*');
        }

        function previousPage() {
            showLoading();
            pdfViewer.contentWindow.postMessage({ type: 'previousPage' }, '*');
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

        // Toggle table of contents
        function toggleToc() {
            const tocSidebar = document.getElementById('tocSidebar');
            tocVisible = !tocVisible;
            
            if (tocVisible) {
                tocSidebar.classList.remove('hidden');
            } else {
                tocSidebar.classList.add('hidden');
            }
        }

        // Copy to clipboard functions
        function copyToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link copied to clipboard!');
            }, (err) => {
                console.error('Could not copy text: ', err);
            });
        }

        function copyCitation(elementId) {
            const citation = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(citation).then(() => {
                showToast('Citation copied to clipboard!');
            }, (err) => {
                console.error('Could not copy text: ', err);
            });
        }

        // Show toast message
        function showToast(message) {
            // Create toast element if it doesn't exist
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 translate-y-20 opacity-0';
                document.body.appendChild(toast);
            }

            // Set message and show toast
            toast.textContent = message;
            setTimeout(() => {
                toast.classList.remove('translate-y-20', 'opacity-0');
            }, 10);

            // Hide toast after a delay
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        // Enhanced PDF loading handler
        window.addEventListener('load', () => {
            const pdfViewer = document.getElementById('pdfViewer');
            
            // Focus the PDF viewer when loaded
            pdfViewer.onload = () => {
                pdfViewer.contentWindow.focus();
                document.getElementById('pdfLoadingOverlay').classList.add('hidden');
            };

            // Initialize zoom
            updateZoom();
        });

        // Show loading overlay when changing pages
        function showLoading() {
            document.getElementById('pdfLoadingOverlay').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('pdfLoadingOverlay').classList.add('hidden');
            }, 800); // Hide after a short period even if load event doesn't fire
        }
    </script>

    <style>
        /* Animation classes */
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Hide scrollbar but allow scrolling */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Adjust margin-top for smooth scrolling to sections */
        .scroll-mt-20 {
            scroll-margin-top: 5rem;
        }
        
        /* Allow iframe content to be focused */
        iframe {
            pointer-events: auto;
        }
    </style>
</x-app-layout>