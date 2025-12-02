@extends('components.default')

@section('title', 'Edit Users | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        {{-- Include Top Navigation --}}
        @include('components.admin.topnav')
        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Include Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">

                <div class="bg-white rounded-xl shadow-lg">
                    <div class="px-6 py-6">

                        <div>
                            <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                                    <div class="sm:col-span-1">
                                        <label for="firstname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                            Name</label>
                                        <input type="text" name="firstname" id="firstname"
                                            value="{{ old('firstname', $user->firstname) }}" placeholder="First Name"
                                            required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                    </div>
                                    <div class="sm:col-span-1">
                                        <label for="lastname"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                            Name</label>
                                        <input type="text" name="lastname" id="lastname"
                                            value="{{ old('lastname', $user->lastname) }}" placeholder="Last Name"
                                            required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" placeholder="Email" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="role"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                        <select name="role" id="role" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' :
                                                '' }}>Admin</option>
                                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' :
                                                '' }}>Staff</option>
                                            <option value="member" {{ old('role', $user->role) === 'member' ? 'selected'
                                                : '' }}>Member</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="password"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password
                                            (leave blank to keep current)</label>
                                        <input type="password" name="password" id="password" placeholder="New Password"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                                    </div>
                                </div>

                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('admin.users') }}"
                                        class="flex items-center text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Back
                                    </a>
                                    <button type="submit"
                                        class="flex items-center text-white bg-blue-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 17h2M12 12v5m9-9l-4-4a2.828 2.828 0 00-4 0L4 14v4h4l7-7z" />
                                        </svg>
                                        Update User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>

@endsection
