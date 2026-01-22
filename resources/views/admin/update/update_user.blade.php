@extends('components.default')

@section('title', 'Edit System User | Santo Niño Parish Church')

@section('content')

<section class="bg-gray-50 min-h-screen">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Form Container --}}
            <div class="lg:w-10/12 w-full">

                {{-- Header & Back Navigation --}}
                <div class="mb-6">
                    <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 font-bold flex items-center gap-1 mb-2 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Return to User List
                    </a>
                    <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Edit Personnel</h1>
                    <p class="text-sm text-gray-500">Modifying profile for: <span class="font-bold text-gray-700">{{ $user->firstname }} {{ $user->lastname }}</span></p>
                </div>

                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
                    <form action="{{ route('admin.users.update', ['id' => $user->id]) }}" method="POST" class="p-8 lg:p-12">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            {{-- LEFT COLUMN: Basic Info --}}
                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest border-b border-blue-50 pb-2">Primary Identity</h3>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Firstname</label>
                                        <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" required
                                            class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Lastname</label>
                                        <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" required
                                            class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email Access</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Contact Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required
                                        class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                            </div>

                            {{-- RIGHT COLUMN: Role & Security --}}
                            <div class="space-y-6">
                                <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest border-b border-blue-50 pb-2">Access & Security</h3>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">System Role</label>
                                    <select name="role" id="role" required
                                        class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                                        <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Parish Staff</option>
                                        <option value="priest" {{ old('role', $user->role) === 'priest' ? 'selected' : '' }}>Parish Priest</option>
                                        <option value="member" {{ old('role', $user->role) === 'member' ? 'selected' : '' }}>Church Member</option>
                                    </select>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">New Security Key (Password)</label>
                                    <input type="password" name="password" placeholder="Leave blank to maintain current"
                                        class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all placeholder:text-gray-300">
                                    <p class="text-[9px] text-gray-400 italic px-1 italic mt-1">*Only fill this if the user needs a password reset.</p>
                                </div>
                            </div>

                            {{-- CONDITIONAL: Member Details --}}
                            <div id="member-fields" class="md:col-span-2 mt-4 bg-blue-50/50 rounded-[2rem] p-8 border border-blue-100 transition-all {{ $user->role === 'member' ? '' : 'hidden' }}">
                                <h3 class="text-xs font-black text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                    Extended Member Profile
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Middle Name</label>
                                        <input type="text" name="middle_name" value="{{ old('middle_name', optional($user->member)->middle_name) }}"
                                            class="w-full bg-white border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Birth Date</label>
                                        <input type="date" name="birth_date" value="{{ old('birth_date', optional($user->member)->birth_date) }}"
                                            class="w-full bg-white border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Place of Birth</label>
                                        <input type="text" name="place_of_birth" value="{{ old('place_of_birth', optional($user->member)->place_of_birth) }}"
                                            class="w-full bg-white border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Residential Address</label>
                                        <input type="text" name="address" value="{{ old('address', optional($user->member)->address) }}"
                                            class="w-full bg-white border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Final Actions --}}
                        <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-50 pt-8">
                            <a href="{{ route('admin.users') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">Discard Changes</a>
                            <button type="submit" class="bg-blue-600 px-10 py-4 rounded-2xl text-white font-black uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                                Update Personnel
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
            memberFields.classList.add('animate-in', 'fade-in', 'slide-in-from-top-4', 'duration-300');
        } else {
            memberFields.classList.add('hidden');
        }
    });
</script>
@endpush
