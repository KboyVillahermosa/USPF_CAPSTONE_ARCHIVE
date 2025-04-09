<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Overview Card -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Profile Overview') }}
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Name</p>
                            <p class="mt-1">{{ $user->name }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1">{{ $user->email }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Department</p>
                            <p class="mt-1">{{ $user->department }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Course</p>
                            <p class="mt-1">{{ $user->course }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Year Level</p>
                            <p class="mt-1">{{ $user->year_level }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Student/Faculty ID</p>
                            <p class="mt-1">{{ $user->student_id }}</p>
                        </div>

                        @if($user->role === 'faculty')
                        <div>
                            <p class="text-sm font-medium text-gray-500">Position</p>
                            <p class="mt-1">{{ $user->position }}</p>
                        </div>
                        @endif

                        <div>
                            <p class="text-sm font-medium text-gray-500">Role</p>
                            <p class="mt-1 capitalize">{{ $user->role }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Existing Profile Update Forms -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

           
        </div>
    </div>
</x-app-layout>
