@extends('components.default')

@section('title', 'Members | Santo Niño Parish Church')

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

                <div class="bg-white rounded-2xl shadow-xl">
                    <div class="px-6 py-6">

                        <!-- Breadcrumb -->
                        <nav class="flex px-5 py-3 text-gray-600 border border-gray-200 rounded-lg bg-white"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600">
                                        <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#"
                                            class="ms-1 text-sm font-medium text-gray-600 hover:text-blue-600 md:ms-2">
                                            Dashboard
                                        </a>
                                    </div>
                                </li>

                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span class="ms-1 text-sm font-medium text-gray-400 md:ms-2">Members</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                    </div>

                    <!-- Table -->
                    <div class="relative overflow-x-auto sm:rounded-lg px-6 pb-6">
                        <table id="datatable" class="w-full text-sm text-gray-700">

                            <!-- Table Header -->
                            <thead class="text-xs uppercase bg-white border-b border-gray-200 text-gray-600">
                                <tr>
                                    <th class="px-6 py-3">Fullname</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Birthdate</th>
                                    <th class="px-6 py-3">Address</th>
                                    <th class="px-6 py-3">Place of Birth</th>
                                    <th class="px-6 py-3">Contact #</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-100">
                                @foreach($members as $member)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $member->user->firstname }} {{ $member->middle_name }} {{
                                        $member->user->lastname }}
                                    </td>

                                    <td class="px-6 py-4">{{ $member->user->email }}</td>
                                    <td class="px-6 py-4">{{ $member->birth_date }}</td>
                                    <td class="px-6 py-4">{{ $member->address }}</td>
                                    <td class="px-6 py-4">{{ $member->place_of_birth }}</td>
                                    <td class="px-6 py-4">{{ $member->contact_number }}</td>

                                    <td class="px-6 py-4 text-right space-x-2">

                                        <!-- Delete -->
                                        <a href="#" data-id="{{ $member->id }}"
                                            class="delete-user-btn inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                                            Delete
                                        </a>

                                        <!-- Edit -->
                                        <a href="{{ route('users.edit', ['id' => $member->id]) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                            Edit
                                        </a>

                                        <form id="delete-user-form" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

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
@endpush
