@extends('components.default')

@section('title', 'Users | Santo Niño Parish Church')

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

                        <!-- Breadcrumb -->
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600">
                                            Dashboard
                                        </a>
                                    </div>
                                </li>

                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span class="ms-1 text-sm font-medium text-gray-500">Users</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                        <div class="flex justify-end py-2">
                            <button id="defaultModalButton" data-modal-target="createUserModal"
                                data-modal-toggle="createUserModal" class="flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700
                focus:ring-4 focus:outline-none focus:ring-blue-300
                font-medium rounded-lg text-sm px-5 py-2.5 shadow-md hover:shadow-lg transition">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>

                                Add User
                            </button>
                        </div>

                    </div>

                    <div class="relative overflow-x-auto sm:rounded-lg px-6 py-6">

                        <table id="datatable" class="w-full text-sm text-left text-gray-700">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3">Firstname</th>
                                    <th class="px-6 py-3">Lastname</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Role</th>
                                    <th class="px-6 py-3">Contact Number</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($users as $user)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $user->firstname }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $user->lastname }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>

                                    {{-- <td class="px-6 py-4">
                                        {{ ucfirst($user->role) }}
                                    </td> --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-700',
                                                'staff' => 'bg-blue-100 text-blue-700',
                                                'priest' => 'bg-amber-100 text-amber-700',
                                                'member' => 'bg-gray-100 text-gray-700',
                                            ];
                                        @endphp
                                        <span class="{{ $roleColors[$user->role] ?? 'bg-gray-50' }} px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                            {{ $user->role }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $user->phone_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block text-left">
                                            <!-- Dropdown button -->
                                            <button type="button"
                                                class="inline-flex justify-center w-10 h-10 text-gray-700 bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                id="menu-button-{{ $user->id }}" aria-expanded="true"
                                                aria-haspopup="true">
                                                <!-- Three dots icon -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="5" cy="12" r="2" />
                                                    <circle cx="12" cy="12" r="2" />
                                                    <circle cx="19" cy="12" r="2" />
                                                </svg>

                                            </button>

                                            <!-- Dropdown panel -->
                                            <div class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                                                role="menu" aria-orientation="vertical"
                                                aria-labelledby="menu-button-{{ $user->id }}"
                                                id="dropdown-{{ $user->id }}">
                                                <div class="py-1">
                                                    <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}"
                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M16 7l-8 8H4v-4l8-8 4 4z" />
                                                        </svg>
                                                        Edit
                                                    </a>
                                                    <a href="#" data-id="{{ $user->id }}"
                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 delete-user-btn">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M19 7L5 7M6 7v12a2 2 0 002 2h8a2 2 0 002-2V7M10 11v6M14 11v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                                        </svg>
                                                        Delete
                                                    </a>
                                                    @if($user->role === 'member')
                                                    <button data-modal-target="memberModal{{ $user->id }}"
                                                        data-modal-toggle="memberModal{{ $user->id }}"
                                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        More Info
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>



                                </tr>
                                @if($user->role === 'member')
                                <!-- Member Modal -->
                                <div id="memberModal{{ $user->id }}" tabindex="-1" aria-hidden="true"
                                    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

                                    <div class="relative w-full max-w-2xl p-4 animate-fadeIn">
                                        <div
                                            class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">

                                            <!-- Header -->
                                            <div
                                                class="flex items-center justify-between px-6 py-4 bg-blue-50 border-b">
                                                <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.79.597 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Member Information
                                                </h3>

                                                <button type="button" data-modal-toggle="memberModal{{ $user->id }}"
                                                    class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-200 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Body -->
                                            <div class="px-6 py-6 space-y-6">

                                                <!-- Personal Details Card -->
                                                <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
                                                    <h4
                                                        class="text-lg font-medium text-gray-700 mb-4 flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-gray-600" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.79.597 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        Personal Details
                                                    </h4>
                                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.79.597 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                            </svg> <strong>First Name:</strong> {{ $user->firstname }}
                                                        </p>
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4v1m0 14v1m8-8h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707M17.657 17.657l.707-.707M6.343 6.343l-.707-.707">
                                                                </path>
                                                            </svg> <strong>Last Name:</strong> {{ $user->lastname }}</p>
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16 12H8m0 0H4m8 0h4m0 0h4M12 4v16">
                                                                </path>
                                                            </svg> <strong>Email:</strong> {{ $user->email }}</p>
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 5a2 2 0 012-2h3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z">
                                                                </path>
                                                            </svg> <strong>Phone:</strong> {{ $user->phone_number ??
                                                            'N/A' }}</p>
                                                    </div>
                                                </div>

                                                <!-- Member Profile Card -->
                                                @if($user->member)
                                                <div class="bg-gray-50 rounded-lg p-4 shadow-inner">
                                                    <h4
                                                        class="text-lg font-medium text-gray-700 mb-4 flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-5 h-5 text-gray-600" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 10h4l3 6H5l-2 4h16l-2-4h-5l3-6h4">
                                                            </path>
                                                        </svg>
                                                        Member Profile
                                                    </h4>
                                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4v16m8-8H4"></path>
                                                            </svg> <strong>Middle Name:</strong> {{
                                                            $user->member->middle_name ?? 'N/A' }}</p>
                                                        <p class="flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M8 7V3m8 4V3M4 11h16M5 21h14M12 17v4">
                                                                </path>
                                                            </svg> <strong>Birth Date:</strong> {{
                                                            $user->member->birth_date ?? 'N/A' }}</p>
                                                        <p class="col-span-2 flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M17 20h5v-2a2 2 0 00-2-2h-3v4zM3 20h5v-4H5a2 2 0 00-2 2v2z">
                                                                </path>
                                                            </svg> <strong>Place of Birth:</strong> {{
                                                            $user->member->place_of_birth ?? 'N/A' }}</p>
                                                        <p class="col-span-2 flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7H3z"></path>
                                                            </svg> <strong>Address:</strong> {{ $user->member->address
                                                            ?? 'N/A' }}</p>
                                                        <p class="col-span-2 flex items-center gap-2"><svg
                                                                class="w-4 h-4 text-gray-500" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18">
                                                                </path>
                                                            </svg> <strong>Contact Number:</strong> {{
                                                            $user->member->contact_number ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>

                                            <!-- Footer -->
                                            <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                                                <button data-modal-toggle="memberModal{{ $user->id }}"
                                                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                                                    Close
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @endif

                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>





    <!-- Create User Modal -->
    <div id="createUserModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">

        <div class="relative w-full max-w-lg p-4">
            <div class="relative bg-white rounded-2xl shadow-2xl p-6">

                <!-- Modal header -->
                <div class="flex items-center justify-between border-b pb-3 mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        Add User
                    </h3>

                    <button type="button" data-modal-toggle="createUserModal"
                        class="p-2 rounded-full hover:bg-gray-200 text-gray-500 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Form -->
                <form action="{{ route('admin.users.add') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="text-sm font-medium">Firstname</label>
                        <input type="text" name="firstname" required
                            class="w-full p-2.5 border rounded-lg bg-gray-50" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Lastname</label>
                        <input type="text" name="lastname" required class="w-full p-2.5 border rounded-lg bg-gray-50" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Email</label>
                        <input type="email" name="email" required class="w-full p-2.5 border rounded-lg bg-gray-50" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Phone Number</label>
                        <input type="text" name="phone_number" required
                            class="w-full p-2.5 border rounded-lg bg-gray-50" placeholder="e.g., +63 912 345 6789" />
                    </div>


                    <div>
                        <label class="text-sm font-medium">Password</label>
                        <input type="password" name="password" required
                            class="w-full p-2.5 border rounded-lg bg-gray-50" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full p-2.5 border rounded-lg bg-gray-50" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Role</label>
                        <select name="role" class="w-full p-2.5 border rounded-lg bg-gray-50" required>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                            <option value="member">Member</option>
                            <option value="priest">Priest</option>
                        </select>
                    </div>


                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg px-5 py-2.5">
                        Add User
                    </button>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@include('components.alerts')
<script>
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-user-form');
                    form.setAttribute('action', `/admin/users/${userId}`);
                    form.submit();
                }
            });
        });
    });
</script>
<script>
    document.querySelectorAll('[id^="menu-button-"]').forEach(button => {
    const id = button.id.split('-')[2];
    const dropdown = document.getElementById(`dropdown-${id}`);

    button.addEventListener('click', () => {
        dropdown.classList.toggle('hidden');
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
});

</script>
@endpush
