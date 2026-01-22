@extends('components.default')

@section('title', 'User Management | Santo Niño Parish Church')

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

            {{-- Main Dashboard --}}
            <div class="lg:w-10/12 w-full">

                {{-- Action Header --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">User Control</h1>
                        <p class="text-gray-500 font-medium text-sm mt-1">Manage system security and church personnel access.</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button data-modal-target="archiveModal" data-modal-toggle="archiveModal"
                                class="group flex items-center gap-2 bg-white border border-amber-200 px-5 py-2.5 rounded-2xl text-amber-700 font-bold text-sm shadow-sm hover:bg-amber-50 transition-all">
                            <span class="flex h-2 w-2 rounded-full bg-amber-500 group-hover:animate-ping"></span>
                            Archives ({{ $archivedUsers->count() }})
                        </button>

                        <button data-modal-target="createUserModal" data-modal-toggle="createUserModal"
                                class="flex items-center gap-2 bg-blue-600 px-6 py-2.5 rounded-2xl text-white font-bold text-sm shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3" stroke-linecap="round"/></svg>
                            Add New User
                        </button>
                    </div>
                </div>

                {{-- User Table Card --}}
                <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Personnel</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Contact Access</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-center">Status/Role</th>
                                    <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($users as $user)
                                <tr class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($user->firstname, 0, 1) }}{{ substr($user->lastname, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 leading-none">{{ $user->firstname }} {{ $user->lastname }}</p>
                                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">Registered: {{ $user->created_at->format('M Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <p class="text-sm font-medium text-gray-700">{{ $user->email }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->phone_number ?? '---' }}</p>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @php
                                            $roleStyle = match($user->role) {
                                                'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'priest' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'staff' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                default => 'bg-gray-100 text-gray-600 border-gray-200'
                                            };
                                        @endphp
                                        <span class="{{ $roleStyle }} px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex justify-end items-center gap-1">
                                            @if($user->role === 'member')
                                            <button data-modal-target="memberModal{{ $user->id }}" data-modal-toggle="memberModal{{ $user->id }}"
                                                    class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                                            </button>
                                            @endif

                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2"/></svg>
                                            </a>

                                            <button onclick="confirmArchive({{ $user->id }})" class="p-2.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" stroke-width="2"/></svg>
                                            </button>

                                            <form id="archive-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MODALS --}}

{{-- Archive Modal --}}
<div id="archiveModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/70 backdrop-blur-md p-4">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-4xl overflow-hidden animate-in zoom-in duration-200">
        <div class="bg-amber-500 px-10 py-6 flex justify-between items-center text-white">
            <h3 class="text-xl font-black uppercase tracking-tighter italic">Inactive Records</h3>
            <button data-modal-toggle="archiveModal" class="h-10 w-10 flex items-center justify-center rounded-full hover:bg-white/10 transition">✕</button>
        </div>
        <div class="p-10 max-h-[70vh] overflow-y-auto">
            <table class="w-full">
                <tbody class="divide-y divide-gray-100">
                    @forelse($archivedUsers as $arch)
                    <tr class="group">
                        <td class="py-4">
                            <p class="font-bold text-gray-800">{{ $arch->firstname }} {{ $arch->lastname }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Archived on: {{ $arch->deleted_at->format('M d, Y') }}</p>
                        </td>
                        <td class="py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <form action="{{ route('admin.users.restore', $arch->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-xs font-black uppercase hover:bg-blue-600 hover:text-white transition-all">Restore</button>
                                </form>
                                <button onclick="confirmWipe({{ $arch->id }})" class="bg-red-50 text-red-600 px-4 py-2 rounded-xl text-xs font-black uppercase hover:bg-red-600 hover:text-white transition-all">Wipe</button>
                                <form id="wipe-form-{{ $arch->id }}" action="{{ route('admin.users.force_delete', $arch->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td class="py-10 text-center text-gray-400 italic font-medium">No users currently archived.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Add User Modal --}}
<div id="createUserModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-gray-900/70 backdrop-blur-md p-4">
    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-xl overflow-hidden animate-in slide-in-from-bottom-8 duration-300">
        <div class="bg-gray-900 px-10 py-6 flex justify-between items-center text-white">
            <h3 class="text-xl font-black uppercase tracking-tighter">System Enrollment</h3>
            <button data-modal-toggle="createUserModal" class="h-10 w-10 flex items-center justify-center rounded-full hover:bg-white/10 transition">✕</button>
        </div>
        <form action="{{ route('admin.users.add') }}" method="POST" class="p-10 space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Firstname</label>
                    <input type="text" name="firstname" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Lastname</label>
                    <input type="text" name="lastname" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="space-y-1">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Email Access</label>
                <input type="email" name="email" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Role</label>
                    <select name="role" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="staff">Staff</option>
                        <option value="priest">Priest</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Contact</label>
                    <input type="text" name="phone_number" class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Security Key</label>
                    <input type="password" name="password" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Verify</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 py-4 rounded-2xl text-white font-black uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all">Establish Account</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmArchive(id) {
        Swal.fire({
            title: 'Deactivate User?',
            text: "Account will be archived. Transactions stay safe.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'Yes, Archive'
        }).then((result) => { if (result.isConfirmed) document.getElementById(`archive-form-${id}`).submit(); });
    }

    function confirmWipe(id) {
        Swal.fire({
            title: 'Permanent Wipe?',
            text: "Warning: All user data and linked histories will be erased forever!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Delete Forever'
        }).then((result) => { if (result.isConfirmed) document.getElementById(`wipe-form-${id}`).submit(); });
    }
</script>
@endpush
