@extends('components.default')

@section('title', 'Edit User | Santo Niño Parish Church')

@section('content')
<section class="min-h-screen pt-24">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-8 gap-6">

        {{-- Sidebar --}}
        <div class="lg:w-2/12 w-full">
            @include('components.admin.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="lg:w-10/12 w-full">

            {{-- Page Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Edit User</h1>
                <p class="text-sm text-gray-500">
                    Update account information and role details
                </p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                <div class="px-8 py-8">

                    <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Basic Info --}}
                        <div class="grid gap-6 sm:grid-cols-2 mb-8">

                            <div>
                                <label class="form-label">First Name</label>
                                <input type="text" name="firstname"
                                    value="{{ old('firstname', $user->firstname) }}"
                                    class="form-input" required>
                            </div>

                            <div>
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lastname"
                                    value="{{ old('lastname', $user->lastname) }}"
                                    class="form-input" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="form-input" required>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="form-label">Role</label>
                                <select name="role" id="role" class="form-input" required>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Member</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="form-label">
                                    Password
                                    <span class="text-xs text-gray-400">(leave blank to keep current)</span>
                                </label>
                                <input type="password" name="password"
                                    placeholder="New password"
                                    class="form-input">
                            </div>
                        </div>

                        {{-- Member Information --}}
                        <div id="member-fields"
                            class="{{ $user->role === 'member' ? '' : 'hidden' }} bg-gray-50 border border-gray-200 rounded-xl p-6 mb-8">

                            <h3 class="text-lg font-medium text-gray-800 mb-4">
                                Member Information
                            </h3>

                            <div class="grid gap-6 sm:grid-cols-2">

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

                                <div class="sm:col-span-2">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number"
                                        value="{{ old('contact_number', optional($user->member)->contact_number) }}"
                                        class="form-input">
                                </div>

                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-between items-center">
                            <a href="{{ route('admin.users') }}"
                                class="px-6 py-2.5 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                                ← Back
                            </a>

                            <button type="submit"
                                class="px-6 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow">
                                Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .form-label {
    @apply block mb-2 text-sm font-medium text-gray-700;
}

.form-input {
    @apply w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm
           focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition;
}

</style>
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
