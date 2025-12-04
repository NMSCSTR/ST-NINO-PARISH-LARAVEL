@extends('components.default')

@section('title', 'Priest Profile | Santo Niño Parish Church')

@section('content')
<section class="min-h-screen pt-24 px-4 lg:px-10 bg-gray-100">

    {{-- Include Top Navigation --}}
    @include('components.priest.topnav')

    <div class="max-w-3xl mx-auto mt-6">
        {{-- Back Button --}}
        <a href="{{ route('priest.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 14.707a1 1 0 01-1.414 0L3.586 10l4.707-4.707a1 1 0 011.414 1.414L6.414 10l3.293 3.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M10 15a1 1 0 01-1-1V6a1 1 0 112 0v8a1 1 0 01-1 1z" clip-rule="evenodd" />
            </svg>
            Back to Dashboard
        </a>

        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Edit Profile</h2>

            @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('priest.profile.update') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="firstname" class="block text-gray-700 font-medium mb-1">First Name</label>
                        <input type="text" name="firstname" id="firstname"
                            value="{{ old('firstname', $priest->firstname) }}"
                            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('firstname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="lastname" class="block text-gray-700 font-medium mb-1">Last Name</label>
                        <input type="text" name="lastname" id="lastname"
                            value="{{ old('lastname', $priest->lastname) }}"
                            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('lastname') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $priest->email) }}"
                        class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number"
                        value="{{ old('phone_number', $priest->phone_number) }}"
                        class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-1">New Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                        @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 mt-2">
                    Update Profile
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
