<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Login Form Section -->
        <div class="flex-1 flex flex-col justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="mb-8 text-center">
                    <img src="{{ asset('images/logo-uspf.png') }}" alt="Logo" class="h-12 mx-auto mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Welcome back</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Please sign in to your account
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-gray-700" />
                        <div class="mt-1">
                            <x-text-input id="email" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autofocus 
                                autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-gray-700" />
                        <div class="mt-1">
                            <x-text-input id="password" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                type="password"
                                name="password"
                                required 
                                autocomplete="current-password" />
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
                            <a class="text-sm font-medium text-blue-600 hover:text-blue-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image Section -->
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" 
                 src="{{ asset('images/image.jpg') }}" 
                 alt="Library Background">
            <div class="absolute inset-0 bg-blue-900/30 mix-blend-multiply"></div>
            <div class="absolute inset-0 flex items-center justify-center p-8">
                <div class="max-w-md text-center">
                    <h1 class="text-4xl font-bold text-white mb-4">
                        USPF Research Archive
                    </h1>
                    <p class="text-lg text-white/90">
                        Discover and access academic research papers from the University of Southern Philippines Foundation
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
