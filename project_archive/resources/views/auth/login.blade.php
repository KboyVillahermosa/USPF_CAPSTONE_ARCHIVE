<x-guest-layout class="!p-0 !m-0">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Login Form Section -->
        <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-20 xl:px-24 bg-gradient-to-b from-white to-gray-50">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="mb-10 text-center">
                    <img src="{{ asset('images/logo-uspf.png') }}" alt="Logo" class="h-20 mx-auto mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Welcome to USPF Research Archive</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Access the university's academic repository
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" class="text-sm font-medium text-gray-700" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-text-input id="email" 
                                class="block w-full pl-10 px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username" 
                                placeholder="university@email.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="password" 
                                class="block w-full pl-10 px-3 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-gray-900"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password" 
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-blue-600 hover:text-blue-700 transition duration-150" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                    
                    <div class="text-center text-sm text-gray-600 mt-6">
                        <p>Need access to the archive? <a href="#" class="font-medium text-blue-600 hover:text-blue-700">Contact the research department</a></p>
                    </div>
                </form>
                
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center justify-center">
                        <div class="text-xs text-gray-500">
                            © {{ date('Y') }} University of Southern Philippines Foundation. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Section -->
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="{{ asset('images/image.jpg') }}" 
                 alt="Library Background">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/70 to-indigo-900/80"></div>
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="max-w-md text-center">
                    <h1 class="text-4xl font-bold text-white mb-6">
                        USPF Research Archive
                    </h1>
                    <p class="text-lg text-white/90 mb-8">
                        Discover and access academic research papers from the University of Southern Philippines Foundation
                    </p>
                    <div class="flex justify-center space-x-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-5 text-white text-center shadow-lg">
                            <div class="text-4xl font-bold">500+</div>
                            <div class="text-sm mt-1">Research Papers</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-5 text-white text-center shadow-lg">
                            <div class="text-4xl font-bold">50+</div>
                            <div class="text-sm mt-1">Departments</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-5 text-white text-center shadow-lg">
                            <div class="text-4xl font-bold">10+</div>
                            <div class="text-sm mt-1">Years of Research</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-6 left-6 text-white/70 text-sm">
                Photo: USPF Main Library
            </div>
        </div>
    </div>

    <style>
        /* Remove any top spacing */
        body, html {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
        }
    </style>
</x-guest-layout>
