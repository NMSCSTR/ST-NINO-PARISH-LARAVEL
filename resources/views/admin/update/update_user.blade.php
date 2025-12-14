@extends('components.default')

@section('title', 'Edit Users | Santo Niño Parish Church')

@section('content')
<section class="min-h-screen pt-24 bg-gray-50">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-10 gap-6">

        {{-- Sidebar --}}
        <div class="w-full lg:w-2/12">
            @include('components.admin.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="w-full lg:w-10/12">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">

                {{-- Card Header --}}
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Edit User Information
                    </h2>
                    <p class="text-sm text-gray-500">
                        Update user details and permissions
                    </p>
                </div>

                {{-- Card Body --}}
                <div class="p-6">
                    <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            {{-- First Name --}}
                            <div>
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" name="firstname" id="firstname"
                                    value="{{ old('firstname', $user->firstname) }}" required class="form-input">
                            </div>

                            {{-- Last Name --}}
                            <div>
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" name="lastname" id="lastname"
                                    value="{{ old('lastname', $user->lastname) }}" required class="form-input">
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-2">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    required class="form-input">
                            </div>

                            {{-- Role --}}
                            <div class="sm:col-span-2">
                                <label for="role" class="form-label">User Role</label>
                                <select name="role" id="role" required class="form-input">
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Admin
                                    </option>
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>
                                        Staff
                                    </option>
                                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : ''
                                        }}>
                                        Member
                                    </option>
                                </select>
                            </div>

                            {{-- Password --}}
                            <div class="sm:col-span-2">
                                <label for="password" class="form-label">
                                    Password <span class="text-gray-400">(leave blank to keep current)</span>
                                </label>
                                <input type="password" name="password" id="password" placeholder="Enter new password"
                                    class="form-input">
                            </div>
                        </div>

                        {{-- Member Fields --}}
                        <div id="member-fields" class="mt-8 space-y-5 {{ $user->role === 'member' ? '' : 'hidden' }}">

                            <h3 class="text-sm font-semibold text-gray-700 border-b pb-2">
                                Member Information
                            </h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                                <div>
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="middle_name"
                                        value="{{ old('middle_name', optional($user->member)->middle_name) }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Birth Date</label>
                                    <input type="date" name="birth_date"
                                        value="{{ old('birth_date', optional($user->member)->birth_date) }}"
                                        class="form-input">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Place of Birth</label>
                                    <input type="text" name="place_of_birth"
                                        value="{{ old('place_of_birth', optional($user->member)->place_of_birth) }}"
                                        class="form-input">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address"
                                        value="{{ old('address', optional($user->member)->address) }}"
                                        class="form-input">
                                </div>

                                <div>
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number"
                                        value="{{ old('contact_number', optional($user->member)->contact_number) }}"
                                        class="form-input">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end gap-3 mt-8">
                            <a href="{{ route('admin.users') }}"
                                class="px-5 py-2.5 rounded-lg border text-gray-700 hover:bg-gray-100 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
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

    roleSelect.addEventListener('change', () => {
        memberFields.classList.toggle('hidden', roleSelect.value !== 'member');
    });
</script>
@endpush
