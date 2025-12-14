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

                        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6 sm:p-8">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                                Update User Information
                            </h2>

                            <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="grid gap-5 sm:grid-cols-2">

                                    {{-- First Name --}}
                                    <div>
                                        <label for="firstname" class="block mb-1 text-sm font-medium text-gray-700">
                                            First Name
                                        </label>
                                        <input type="text" name="firstname" id="firstname"
                                            value="{{ old('firstname', $user->firstname) }}" required
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                    </div>

                                    {{-- Last Name --}}
                                    <div>
                                        <label for="lastname" class="block mb-1 text-sm font-medium text-gray-700">
                                            Last Name
                                        </label>
                                        <input type="text" name="lastname" id="lastname"
                                            value="{{ old('lastname', $user->lastname) }}" required
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                    </div>

                                    {{-- Email --}}
                                    <div class="sm:col-span-2">
                                        <label for="email" class="block mb-1 text-sm font-medium text-gray-700">
                                            Email Address
                                        </label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" required
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                    </div>

                                    {{-- Role --}}
                                    <div class="sm:col-span-2">
                                        <label for="role" class="block mb-1 text-sm font-medium text-gray-700">
                                            User Role
                                        </label>
                                        <select name="role" id="role" required
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' :
                                                '' }}>Admin</option>
                                            <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' :
                                                '' }}>Staff</option>
                                            <option value="member" {{ old('role', $user->role) === 'member' ? 'selected'
                                                : '' }}>Member</option>
                                        </select>
                                    </div>

                                    {{-- Password --}}
                                    <div class="sm:col-span-2">
                                        <label for="password" class="block mb-1 text-sm font-medium text-gray-700">
                                            New Password
                                            <span class="text-xs text-gray-400">(leave blank to keep current)</span>
                                        </label>
                                        <input type="password" name="password" id="password" placeholder="••••••••"
                                            class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                    </div>

                                    {{-- Member-specific fields --}}
                                    @if($user->role === 'member')
                                    <div class="sm:col-span-2 border-t border-gray-200 pt-6 mt-2">
                                        <h3 class="text-sm font-semibold text-gray-800 mb-4">
                                            Member Details
                                        </h3>

                                        <div class="grid gap-5 sm:grid-cols-2">
                                            <div>
                                                <label for="middle_name"
                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                    Middle Name
                                                </label>
                                                <input type="text" name="middle_name" id="middle_name"
                                                    value="{{ old('middle_name', optional($user->member)->middle_name) }}"
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                            </div>

                                            <div>
                                                <label for="birth_date"
                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                    Birth Date
                                                </label>
                                                <input type="date" name="birth_date" id="birth_date"
                                                    value="{{ old('birth_date', optional($user->member)->birth_date) }}"
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="place_of_birth"
                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                    Place of Birth
                                                </label>
                                                <input type="text" name="place_of_birth" id="place_of_birth"
                                                    value="{{ old('place_of_birth', optional($user->member)->place_of_birth) }}"
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="address"
                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                    Address
                                                </label>
                                                <input type="text" name="address" id="address"
                                                    value="{{ old('address', optional($user->member)->address) }}"
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="contact_number"
                                                    class="block mb-1 text-sm font-medium text-gray-700">
                                                    Contact Number
                                                </label>
                                                <input type="text" name="contact_number" id="contact_number"
                                                    value="{{ old('contact_number', optional($user->member)->contact_number) }}"
                                                    class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20" />
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="mt-8 flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users') }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                        Cancel
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
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
@push('scripts')
@include('components.alerts')
<script>
    const roleSelect = document.getElementById('role');
    const memberFields = document.getElementById('member-fields');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'member') {
            memberFields.classList.remove('hidden');
        } else {
            memberFields.classList.add('hidden');
        }
    });
</script>
@endpush
