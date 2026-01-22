@extends('components.default')

@section('title', 'User Management | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24 bg-gray-50">
        @include('components.admin.bg')
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-10 gap-6">
            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                    {{-- Header Section --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <div>
                            <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">System Users</h2>
                            <p class="text-sm text-gray-500">Manage church accounts and access levels.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Archive Trigger --}}
                            <button data-modal-target="archiveModal" data-modal-toggle="archiveModal"
                                class="inline-flex items-center gap-2 rounded-xl bg-amber-50 px-5 py-2.5 text-sm font-bold text-amber-700 hover:bg-amber-100 transition border border-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                Archives ({{ $archivedUsers->count() }})
                            </button>
                            {{-- Add User Trigger --}}
                            <button data-modal-target="createUserModal" data-modal-toggle="createUserModal"
                                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Add User
                            </button>
                        </div>
                    </div>

                    {{-- Main Users Table --}}
                    <div class="p-6 overflow-x-auto">
                        <table id="datatable" class="w-full text-sm text-left">
                            <thead class="text-[10px] text-gray-400 uppercase font-black tracking-widest bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-center">Name</th>
                                    <th class="px-6 py-4 text-center">Contact Info</th>
                                    <th class="px-6 py-4 text-center">Role</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($users as $user)
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="px-6 py-4 text-center font-bold text-gray-900">{{ $user->firstname }} {{ $user->lastname }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-gray-700 font-medium">{{ $user->email }}</div>
                                        <div class="text-[10px] text-gray-400">{{ $user->phone_number ?? 'No Phone' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'staff' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'priest' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'member' => 'bg-gray-100 text-gray-700 border-gray-200',
                                            ];
                                        @endphp
                                        <span class="{{ $roleColors[$user->role] ?? 'bg-gray-50' }} px-3 py-1 rounded-lg text-[10px] font-black uppercase border">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            @if($user->role === 'member')
                                            <button data-modal-target="memberModal{{ $user->id }}" data-modal-toggle="memberModal{{ $user->id }}" class="p-2 text-gray-400 hover:text-blue-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            </button>
                                            @endif
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-gray-400 hover:text-blue-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <button onclick="confirmArchive({{ $user->id }})" class="p-2 text-gray-400 hover:text-amber-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                            </button>
                                            <form id="archive-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
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

    {{-- 1. ADD USER MODAL --}}
    <div id="createUserModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-blue-600 px-8 py-5 flex justify-between items-center text-white">
                <h3 class="text-lg font-bold uppercase tracking-widest">New System User</h3>
                <button data-modal-toggle="createUserModal" class="hover:text-blue-100">✕</button>
            </div>
            <form action="{{ route('admin.users.add') }}" method="POST" class="p-8 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Firstname</label>
                        <input type="text" name="firstname" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Lastname</label>
                        <input type="text" name="lastname" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Email</label>
                    <input type="email" name="email" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Phone</label>
                    <input type="text" name="phone_number" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</label>
                    <select name="role" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                        <option value="staff">Staff</option>
                        <option value="priest">Priest</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 pb-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password</label>
                        <input type="password" name="password" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Confirm</label>
                        <input type="password" name="password_confirmation" required class="w-full rounded-xl border-gray-200 bg-gray-50 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition shadow-lg">Create Account</button>
            </form>
        </div>
    </div>

    {{-- 2. ARCHIVE LIST MODAL --}}
    <div id="archiveModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm p-4">
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden animate-in zoom-in duration-200">
            <div class="bg-amber-600 px-8 py-5 flex justify-between items-center text-white">
                <h3 class="text-lg font-bold uppercase tracking-widest">Archived Users</h3>
                <button data-modal-toggle="archiveModal" class="hover:text-amber-100 transition">✕</button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <table class="w-full text-sm text-left">
                    <thead class="text-[10px] text-gray-400 uppercase font-black tracking-widest bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Archived At</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($archivedUsers as $archived)
                        <tr class="hover:bg-amber-50/30 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-700">{{ $archived->firstname }} {{ $archived->lastname }}</div>
                                <div class="text-[10px] text-gray-400 italic">ID #{{ $archived->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $archived->deleted_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-3 items-center">
                                    <form action="{{ route('admin.users.restore', $archived->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 font-black text-[10px] uppercase hover:underline">Restore</button>
                                    </form>
                                    <button onclick="forceDelete({{ $archived->id }})" class="text-red-600 font-black text-[10px] uppercase hover:underline">Delete Forever</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">No archived users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 3. MEMBER MODALS --}}
    @foreach($users as $user)
        @if($user->role === 'member')
        <div id="memberModal{{ $user->id }}" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden border border-gray-200">
                <div class="flex items-center justify-between px-6 py-4 bg-blue-50 border-b">
                    <h3 class="text-lg font-bold text-gray-800">Member Profile</h3>
                    <button data-modal-toggle="memberModal{{ $user->id }}" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>
                <div class="p-8 space-y-6">
                    <div class="bg-gray-50 p-6 rounded-2xl">
                        <h4 class="text-xs font-black text-blue-600 uppercase mb-4">Personal Details</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <p><strong>Firstname:</strong> {{ $user->firstname }}</p>
                            <p><strong>Lastname:</strong> {{ $user->lastname }}</p>
                            <p><strong>Birth Date:</strong> {{ $user->member->birth_date ?? 'N/A' }}</p>
                            <p><strong>Phone:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                    <button data-modal-toggle="memberModal{{ $user->id }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg font-bold">Close</button>
                </div>
            </div>
        </div>
        @endif
    @endforeach

</section>
@endsection

@push('scripts')
@include('components.alerts')
<script>
    function confirmArchive(id) {
        Swal.fire({
            title: 'Archive User?',
            text: "This user will be hidden but their transaction history will be preserved.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b',
            confirmButtonText: 'Yes, Archive'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`archive-form-${id}`).submit();
            }
        });
    }

    function forceDelete(id) {
        Swal.fire({
            title: 'Delete Forever?',
            text: "WARNING: This is permanent. This may cause issues with linked transaction data!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Delete Permanently'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/admin/users/force-delete/${id}`;
            }
        });
    }
</script>
@endpush
