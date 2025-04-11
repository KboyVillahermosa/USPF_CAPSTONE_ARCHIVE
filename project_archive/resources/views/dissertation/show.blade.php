<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $dissertation->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($dissertation->type) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ml-2
                                {{ $dissertation->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                  ($dissertation->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($dissertation->status) }}
                            </span>
                        </div>
                        <a href="{{ route('history') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Back to History
                        </a>
                    </div>

                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-bold">{{ $dissertation->title }}</h3>
                        <div class="mt-2 text-gray-700">
                            <p><strong>Author:</strong> {{ $dissertation->author }}</p>
                            <p><strong>Department:</strong> {{ $dissertation->department }}</p>
                            <p><strong>Year:</strong> {{ $dissertation->year }}</p>
                            <p><strong>Keywords:</strong> {{ $dissertation->keywords }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-semibold mb-2">Abstract</h4>
                        <div class="prose max-w-none">
                            {!! $dissertation->abstract !!}
                        </div>
                    </div>

                    @if($dissertation->status === 'approved')
                        <div class="mt-6">
                            <a href="{{ Storage::url($dissertation->file_path) }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Download Document
                            </a>
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded">
                            <p>This document is pending approval and cannot be downloaded yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>