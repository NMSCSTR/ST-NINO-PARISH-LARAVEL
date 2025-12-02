@extends('components.default')

@section('title', 'Payments | Santo Niño Parish Church')

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

                                        <span class="ms-1 text-sm font-medium text-gray-500">
                                            Payments
                                        </span>
                                    </div>
                                </li>

                            </ol>
                        </nav>

                    </div>

                    <div class="relative overflow-x-auto sm:rounded-lg px-6 py-6">

                        <table id="datatable" class="w-full text-sm text-left text-gray-700">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3">Reservation</th>
                                    <th class="px-6 py-3">Member Name</th>
                                    <th class="px-6 py-3">Amount</th>
                                    <th class="px-6 py-3">Payment Method</th>
                                    <th class="px-6 py-3">Reference #</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Receipt</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($payments as $payment)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $payment->reservation->event->title }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->member->user->firstname }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->amount }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->method }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->reference_no }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($payment->status) }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $payment->receipt_path }}
                                    </td>

                                    <td class="px-6 py-4 text-right flex gap-2">

                                        <a href="#" data-id="{{ $payment->id }}"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">

                                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7H5M6 7v12a2 2 0 002 2h8a2 2 0 002-2V7m-8 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3" />
                                            </svg>

                                            Delete
                                        </a>

                                        <a href="{{ route('admin.users.edit', ['id' => $payment->id]) }}"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">

                                            <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 7l-8 8H4v-4l8-8 4 4z" />
                                            </svg>

                                            Edit
                                        </a>

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
