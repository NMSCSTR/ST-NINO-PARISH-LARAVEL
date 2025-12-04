@extends('components.default')

@section('title', 'Priest Profile | Santo Niño Parish Church')

@section('content')
<section class="min-h-screen pt-24 px-4 lg:px-10 bg-gray-100">

    {{-- Include Top Navigation --}}
    @include('components.priest.topnav')

    <div class="max-w-3xl mx-auto mt-6">
        {{-- Back Button --}}
        <a href="{{ route('priest.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded mb-6 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 14.707a1 1 0 01-1.414 0L3.586 10l4.707-4.707a1 1 0 011.414 1.414L6.414 10l3.293 3.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M10 15a1 1 0 01-1-1V6a1 1 0 112 0v8a1 1 0 01-1 1z" clip-rule="evenodd" />
            </svg>
            Back to Dashboard
        </a>

        <div class="bg-white shadow-xl rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-blue-800 mb-6">Edit Profile</h2>

            <form action="{{ route('priest.profile.update') }}" method="POST">
                @csrf

                {{-- Name Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="firstname" class="block text-gray-700 font-medium mb-2">First Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                                </svg>
                            </span>
                            <input type="text" name="firstname" id="firstname"
                                value="{{ old('firstname', $priest->firstname) }}"
                                class="w-full border px-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        @error('firstname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="lastname" class="block text-gray-700 font-medium mb-2">Last Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 21v-2a4 4 0 00-3-3.87M9 7a4 4 0 11-8 0 4 4 0 018 0zM21 21v-2a4 4 0 00-3-3.87" />
                                </svg>
                            </span>
                            <input type="text" name="lastname" id="lastname"
                                value="{{ old('lastname', $priest->lastname) }}"
                                class="w-full border px-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        @error('lastname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12H8m0 0H6m2 0h8m-4 0v4m0-4v-4" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email', $priest->email) }}"
                            class="w-full border px-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Phone --}}
                <div class="mb-5">
                    <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10l1-2m0 0l7-7 7 7M13 7v10m4 4h-6a2 2 0 01-2-2V7m8 4v8" />
                            </svg>
                        </span>
                        <input type="text" name="phone_number" id="phone_number"
                            value="{{ old('phone_number', $priest->phone_number) }}"
                            class="w-full border px-10 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                    @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-1">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c.667 0 1-.333 1-1V7a1 1 0 00-2 0v3c0 .667.333 1 1 1z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 11V7a7 7 0 0114 0v4" />
                                </svg>
                                New Password
                            </span>
                            <span class="text-gray-400 text-sm ml-1">(Leave blank to keep current password)</span>
                        </label>
                        <input type="password" name="password" id="password"
                            class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">
                            <span class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c.667 0 1-.333 1-1V7a1 1 0 00-2 0v3c0 .667.333 1 1 1z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 11V7a7 7 0 0114 0v4" />
                                </svg>
                                Confirm Password
                            </span>
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700 shadow-lg font-medium">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@include('components.alerts')
@endpush
