<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Academic Work') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Research Upload Card -->
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold mb-4">Research Paper</h3>
                            <p class="text-gray-600 mb-4">Upload research papers, articles, and publications.</p>
                            <a href="{{ route('upload') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Upload Research
                            </a>
                        </div>

                        <!-- Dissertation/Theses Upload Card -->
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-semibold mb-4">Dissertation/Thesis</h3>
                            <p class="text-gray-600 mb-4">Upload academic dissertations and theses.</p>
                            <a href="{{ route('upload.dissertation') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Upload Dissertation/Thesis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>