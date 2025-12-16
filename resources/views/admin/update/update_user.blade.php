@extends('components.default')

@section('title', 'Edit Users | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24 bg-gray-50">
        @include('components.admin.bg')
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-6 gap-6">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-md p-6 sm:p-8 w-full mx-auto">

                    {{-- Header --}}
                    <div class="mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900">
                            Edit User
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Update account details and role information
                        </p>
                    </div>

                    <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6 sm:grid-cols-2">

                            {{-- First Name --}}
                            <div>
                                <label for="firstname" class="block mb-1 text-sm font-medium text-gray-800">
                                    First Name
                                </label>
                                <input type="text" name="firstname" id="firstname"
                                    value="{{ old('firstname', $user->firstname) }}" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label for="lastname" class="block mb-1 text-sm font-medium text-gray-800">
                                    Last Name
                                </label>
                                <input type="text" name="lastname" id="lastname"
                                    value="{{ old('lastname', $user->lastname) }}" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-800">
                                    Email Address
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                            </div>

                        </div>

                        {{-- Phone Number --}}
                        <div class="mt-4">
                            <label for="phone_number" class="block mb-1 text-sm font-medium text-gray-800">
                                Phone Number
                            </label>
                            <input type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                        </div>

                        {{-- Role --}}
                        <div class="sm:col-span-2 mt-4">
                            <label for="role" class="block mb-1 text-sm font-medium text-gray-800">
                                User Role
                            </label>
                            <select name="role" id="role" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition">
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff
                                </option>
                                <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : ''
                                    }}>Member</option>
                            </select>
                        </div>

                        {{-- Password --}}
                        <div class="sm:col-span-2 mt-4">
                            <label for="password" class="block mb-1 text-sm font-medium text-gray-800">
                                New Password
                                <span class="text-xs text-gray-400">(leave blank to keep current)</span>
                            </label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                           focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                        </div>

                        {{-- Member Fields --}}
                        <div id="member-fields" class="sm:col-span-2 mt-6 rounded-xl border border-gray-200 bg-gray-50 p-6
                                {{ $user->role === 'member' ? '' : 'hidden' }}">

                            <h3 class="text-base font-semibold text-gray-900 mb-5 flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                Member Details
                            </h3>

                            <div class="grid gap-6 sm:grid-cols-2">

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-800">
                                        Middle Name
                                    </label>
                                    <input type="text" name="middle_name"
                                        value="{{ old('middle_name', optional($user->member)->middle_name) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                                   focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                                </div>

                                <div>
                                    <label class="block mb-1 text-sm font-medium text-gray-800">
                                        Birth Date
                                    </label>
                                    <input type="date" name="birth_date"
                                        value="{{ old('birth_date', optional($user->member)->birth_date) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                                   focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block mb-1 text-sm font-medium text-gray-800">
                                        Place of Birth
                                    </label>
                                    <input type="text" name="place_of_birth"
                                        value="{{ old('place_of_birth', optional($user->member)->place_of_birth) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                                   focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block mb-1 text-sm font-medium text-gray-800">
                                        Address
                                    </label>
                                    <input type="text" name="address"
                                        value="{{ old('address', optional($user->member)->address) }}"
                                        class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm
                                                   focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition" />
                                </div>

                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-10 flex justify-end gap-3 border-t border-gray-200 pt-6">
                            <a href="{{ route('admin.users') }}" class="rounded-xl border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700
                                               hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 transition">
                                Cancel
                            </a>

                            <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white
                                               hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition">
                                Update User
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@include('components.alerts')
<script>
    const roleSelect = document.getElementById('role');
    const memberFields = document.getElementById('member-fields');

    roleSelect.addEventListener('change', function () {
        if (this.value === 'member') {
            memberFields.classList.remove('hidden');
        } else {
            memberFields.classList.add('hidden');
        }
    });
</script>
@endpush
