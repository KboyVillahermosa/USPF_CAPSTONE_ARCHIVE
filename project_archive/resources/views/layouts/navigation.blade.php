<nav x-data="{ 
    open: false, 
    showFilters: false,
    scrolled: false
}" 
x-init="window.addEventListener('scroll', () => { scrolled = window.pageYOffset > 0 })"
:class="{ 
    'bg-white/95 backdrop-blur-md shadow-md': scrolled,
    'bg-white': !scrolled
}"
class="border-b border-gray-100 z-50 w-full fixed top-0 transition-all duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    {{-- Replace the entire content with your custom logo --}}
                    <img src="{{ asset('images/logo-uspf.png') }}" alt="Your Logo Name" class="h-12 w-auto" />
                    <span class="hidden md:inline-block mr-2 text-sm lg:text-base xl:text-lg font-medium">USPF Research Archive</span>
                    <span class="md:hidden mr-2 text-xs font-medium">USPF Archive</span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('history')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                   

                    <!-- Upload Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>Upload Research</div>
                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('upload')" :active="request()->routeIs('upload')">
                                    {{ __('Student Upload') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('upload.faculty')" :active="request()->routeIs('upload.faculty')">
                                    {{ __('Faculty Upload') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <x-nav-link :href="route('history')" :active="request()->routeIs('dashboard')">
                        {{ __('History') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Enhanced Search Bar with Filters -->
            <div class="flex-1 max-w-3xl px-6 flex items-center">
                <form method="GET" action="{{ route('dashboard') }}" class="w-full relative">
                    <div class="flex gap-2">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <input type="text" 
                                name="search" 
                                id="search-input" 
                                placeholder="Search research papers..."
                                value="{{ request('search') }}"
                                class="w-full px-4 py-2 pl-10 pr-4 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200"
                                autocomplete="off">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <button type="button" 
                                @click="showFilters = !showFilters"
                                class="px-3 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-filter text-gray-500"></i>
                        </button>
                    </div>

                    <!-- Advanced Filters Dropdown -->
                    <div x-show="showFilters"
                        @click.away="showFilters = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg p-4 z-50">
                        
                        <!-- Department Filter -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                            <select name="department" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-400">
                                <option value="">All Departments</option>
                                <option value="CCS" {{ request('department') === 'CCS' ? 'selected' : '' }}>College of Computer Studies</option>
                                <option value="COE" {{ request('department') === 'COE' ? 'selected' : '' }}>College of Engineering</option>
                                <!-- Add other departments -->
                            </select>
                        </div>

                        <!-- Year Range -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" 
                                    name="year_from" 
                                    placeholder="From" 
                                    value="{{ request('year_from') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-400">
                                <input type="number" 
                                    name="year_to" 
                                    placeholder="To" 
                                    value="{{ request('year_to') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-400">
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <button type="submit" 
                                class="w-full bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600 transition-colors">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Log in</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-slot name="content">
                                <x-dropdown-link :href="route('upload')" :active="request()->routeIs('upload')">
                                    {{ __('Student Upload') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('upload.faculty')" :active="request()->routeIs('upload.faculty')">
                                    {{ __('Faculty Upload') }}
                                </x-dropdown-link>

            <x-responsive-nav-link :href="route('history')" :active="request()->routeIs('history')">
                {{ __('History') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
