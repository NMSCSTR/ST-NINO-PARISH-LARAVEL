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
                                    {{-- First Name --}}
                                    <div class="sm:col-span-1">
                                        <label for="firstname"
                                            class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                                        <input type="text" name="firstname" id="firstname"
                                            value="{{ old('firstname', $user->firstname) }}" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
                                    </div>

                                    {{-- Last Name --}}
                                    <div class="sm:col-span-1">
                                        <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900">Last
                                            Name</label>
                                        <input type="text" name="lastname" id="lastname"
                                            value="{{ old('lastname', $user->lastname) }}" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
                                    </div>

                                    {{-- Email --}}
                                    <div class="sm:col-span-2">
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email', $user->email) }}" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
                                    </div>

                                    {{-- Role --}}
                                    <div class="sm:col-span-2">
                                        <label for="role"
                                            class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                                        <select name="role" id="role" required
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full">
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
                                        <label for="password"
                                            class="block mb-2 text-sm font-medium text-gray-900">Password (leave blank
                                            to keep current)</label>
                                        <input type="password" name="password" id="password" placeholder="New Password"
                                            class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
                                    </div>

                                    {{-- Member-specific fields --}}
                                    @if($user->role === 'member')
{{-- Member-specific fields --}}
<div id="member-fields" class="{{ $user->role === 'member' ? '' : 'hidden' }}">
    <div class="sm:col-span-2">
        <label for="middle_name" class="block mb-2 text-sm font-medium text-gray-900">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name"
               value="{{ old('middle_name', optional($user->member)->middle_name) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
    </div>

    <div class="sm:col-span-1">
        <label for="birth_date" class="block mb-2 text-sm font-medium text-gray-900">Birth Date</label>
        <input type="date" name="birth_date" id="birth_date"
               value="{{ old('birth_date', optional($user->member)->birth_date) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
    </div>

    <div class="sm:col-span-1">
        <label for="place_of_birth" class="block mb-2 text-sm font-medium text-gray-900">Place of Birth</label>
        <input type="text" name="place_of_birth" id="place_of_birth"
               value="{{ old('place_of_birth', optional($user->member)->place_of_birth) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
    </div>

    <div class="sm:col-span-2">
        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
        <input type="text" name="address" id="address"
               value="{{ old('address', optional($user->member)->address) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
    </div>

    <div class="sm:col-span-2">
        <label for="contact_number" class="block mb-2 text-sm font-medium text-gray-900">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number"
               value="{{ old('contact_number', optional($user->member)->contact_number) }}"
               class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" />
    </div>
</div>

                                    @endif

                                </div>

                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('admin.users') }}"
                                        class="px-5 py-2.5 bg-gray-200 rounded-lg">Back</a>
                                    <button type="submit" class="px-5 py-2.5 bg-blue-700 text-white rounded-lg">Update
                                        User</button>
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

