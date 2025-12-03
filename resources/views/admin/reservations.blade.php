@extends('components.default')

@section('title', 'Reservations | Santo Niño Parish Church')

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
                                        <a href="#"
                                            class="ms-1 text-sm font-medium text-gray-600 hover:text-blue-600 md:ms-2">
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
                                        <span class="ms-1 text-sm font-medium text-gray-400 md:ms-2">Reservations</span>
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
                                    <th class="px-6 py-3">Member</th>
                                    <th class="px-6 py-3">Sacrament</th>
                                    <th class="px-6 py-3">Fee</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Reservation Date</th>
                                    <th class="px-6 py-3">Remarks</th>
                                    <th class="px-6 py-3">Approved By</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-100">
                                @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 transition">

                                    <!-- Member -->
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $reservation->member->user->firstname }}
                                        {{ $reservation->member->user->lastname }}
                                    </td>

                                    <!-- Sacrament -->
                                    <td class="px-6 py-4">
                                        {{ $reservation->sacrament->sacrament_type ?? 'N/A' }}
                                    </td>

                                    <!-- Fee -->
                                    <td class="px-6 py-4">
                                        ₱{{ number_format($reservation->fee, 2) }}
                                    </td>

                                    <!-- Reservation Status -->
                                    <td class="px-6 py-4">
                                        @if ($reservation->status === 'approved')
                                        <span class="text-green-600 font-semibold">Approved</span>
                                        @elseif ($reservation->status === 'pending')
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                        @elseif ($reservation->status === 'cancel')
                                        <span class="text-red-600 font-semibold">Cancelled</span>
                                        @endif
                                    </td>

                                    <!-- Reservation Date -->
                                    <td class="px-6 py-4">
                                        {{ $reservation->reservation_date->format('F j, Y \a\t g:i A') }}
                                    </td>

                                    <!-- Remarks -->
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $reservation->remarks ?? 'No remarks yet' }}
                                    </td>

                                    <!-- Approved By -->
                                    <td class="px-6 py-4">
                                        @if ($reservation->approvedBy)
                                        {{ $reservation->approvedBy->firstname }} {{ $reservation->approvedBy->lastname
                                        }}
                                        @else
                                        <span class="text-gray-400">Not yet approved</span>
                                        @endif
                                    </td>

                                    <!-- ACTIONS -->
                                    <td class="px-6 py-4 text-right space-x-2">

                                        {{-- DELETE BUTTON --}}
                                        <a href="#" data-id="{{ $reservation->id }}"
                                            class="delete-reservation-btn inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600">
                                            Delete
                                        </a>

                                        {{-- EDIT --}}
                                        @if ($reservation->status !== 'cancel')
                                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                            Edit
                                        </a>
                                        @endif

                                        {{-- APPROVE --}}
                                        @if ($reservation->status !== 'approved')
                                        <form action="{{ route('admin.reservations.approve', $reservation->id) }}"
                                            method="POST" class="inline approve-form">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>
                                        @else
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 border border-green-200 rounded-lg">
                                            Approved
                                        </span>
                                        @endif
                                    </td>
                                </tr>

                                {{-- PAYMENT DETAILS ROW --}}
                                <tr class="bg-gray-50">
                                    <td colspan="8" class="px-6 py-4">

                                        <h3 class="text-sm font-semibold mb-2 text-gray-700">Payment Information</h3>

                                        @if($reservation->payments->isEmpty())
                                        <p class="text-gray-500 text-sm">No payments submitted yet.</p>
                                        @else
                                        <table class="w-full text-xs border">
                                            <thead class="bg-gray-200">
                                                <tr>
                                                    <th class="px-3 py-2">Amount</th>
                                                    <th class="px-3 py-2">Method</th>
                                                    <th class="px-3 py-2">Status</th>
                                                    <th class="px-3 py-2">Receipt</th>
                                                    <th class="px-3 py-2">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reservation->payments as $payment)
                                                <tr class="border-b">

                                                    <td class="px-3 py-2">
                                                        ₱{{ number_format($payment->amount, 2) }}
                                                    </td>

                                                    <td class="px-3 py-2">
                                                        {{ $payment->method ?? '-' }}
                                                    </td>

                                                    <td class="px-3 py-2">
                                                        <span
                                                            class="{{ $payment->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>

                                                    <td class="px-3 py-2">
                                                        @if($payment->receipt_path)
                                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}"
                                                            class="text-blue-600 underline" target="_blank">View
                                                            Receipt</a>
                                                        @else
                                                        -
                                                        @endif
                                                    </td>

                                                    <td class="px-3 py-2">
                                                        {{ $payment->created_at->format('M d, Y') }}
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif

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
    document.querySelectorAll('.delete-reservation-btn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const reservationId = this.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This reservation will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-reservation-form');
                form.setAttribute('action', `/admin/reservations/${reservationId}`);
                form.submit();
            }
        });
    });
});

</script>
<script>
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function() {
            let form = this.closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to approve this reservation.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endpush
