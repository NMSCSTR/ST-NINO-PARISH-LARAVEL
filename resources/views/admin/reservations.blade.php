@extends('components.default')

@section('title', 'Reservations | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            <!-- Sidebar -->
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            <!-- Main Content -->
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl shadow-xl">

                    <div class="px-6 py-6">
                        <!-- Breadcrumb -->
                        <nav class="flex px-5 py-3 text-gray-600 border border-gray-200 rounded-lg bg-white"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600">
                                        <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mx-1 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#"
                                            class="text-sm font-medium text-gray-600 hover:text-blue-600">Dashboard</a>
                                    </div>
                                </li>

                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mx-1 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-400">Reservations</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Table -->
                    <div class="relative overflow-x-auto sm:rounded-lg px-6 pb-6">
                        <table id="datatable" class="w-full text-sm text-gray-800">

                            <thead class="bg-white border-b border-gray-200 text-gray-700 text-xs uppercase">
                                <tr>
                                    <th class="px-6 py-3">Member</th>
                                    <th class="px-6 py-3">Sacrament</th>
                                    <th class="px-6 py-3">Fee</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Forwarded Info</th>
                                    <th class="px-6 py-3">Approved By</th>
                                    <th class="px-6 py-3">Reservation Date</th>
                                    <th class="px-6 py-3">Remarks</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>

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

                                    <!-- Status -->
                                    <td class="px-6 py-4">
                                        <span class="
                                            @if($reservation->status=='approved') text-green-600
                                            @elseif($reservation->status=='forwarded_to_priest') text-blue-600
                                            @elseif($reservation->status=='pending') text-yellow-600
                                            @else text-red-600 @endif font-semibold">
                                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                        </span>
                                    </td>

                                    <!-- Forwarded Info -->
                                    <td class="px-6 py-4 text-gray-700">
                                        @if($reservation->forwarded_by)
                                        <div>
                                            <strong>By:</strong> {{ $reservation->forwardedByUser->firstname }}
                                            {{ $reservation->forwardedByUser->lastname }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            @if($reservation->forwarded_at)
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($reservation->forwarded_at)->format('M d, Y g:i
                                                A') }}
                                            </div>
                                            @endif
                                        </div>
                                        @else
                                        <span class="text-gray-400">Not forwarded</span>
                                        @endif
                                    </td>

                                    <!-- Approved By -->
                                    <td class="px-6 py-4">
                                        @if ($reservation->approved_by)
                                        {{ $reservation->approvedBy->firstname }} {{ $reservation->approvedBy->lastname
                                        }}
                                        @else
                                        <span class="text-gray-400">Not yet approved</span>
                                        @endif
                                    </td>

                                    <!-- Reservation Date -->
                                    <td class="px-6 py-4">
                                        {{ $reservation->reservation_date }}
                                    </td>

                                    <!-- Remarks -->
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $reservation->remarks ?? 'No remarks yet' }}
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right space-x-2">

                                        <!-- Payments -->
                                        <button onclick="openPaymentListModal({{ $reservation->id }})"
                                            class="px-3 py-1.5 text-xs bg-gray-700 text-white rounded hover:bg-black">
                                            Payments
                                        </button>

                                        <!-- Documents -->
                                        <button onclick="openDocumentsModal({{ $reservation->id }})"
                                            class="px-3 py-1.5 text-xs bg-purple-600 text-white rounded hover:bg-purple-700">
                                            Documents
                                        </button>

                                        <!-- FORWARD BUTTON (Staff only, if pending) -->
                                        @if(auth()->user()->role === 'staff' && $reservation->status == 'pending')
                                        <form action="{{ route('admin.reservations.forward', $reservation->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                                Forward to Priest
                                            </button>
                                        </form>
                                        @endif

                                        <!-- APPROVE BUTTON (Priest only, if forwarded) -->
                                        @if(auth()->user()->role === 'priest' && $reservation->status ==
                                        'forwarded_to_priest')
                                        <form action="{{ route('admin.reservations.approve', $reservation->id) }}"
                                            method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                                Approve
                                            </button>
                                        </form>
                                        @endif

                                        <!-- Pay Now -->
                                        <button onclick="openPaymentModal({{ $reservation->id }})"
                                            class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Pay Now
                                        </button>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                            class="px-3 py-1.5 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                            Edit
                                        </a>

                                        <!-- Delete -->
                                        <a href="#" data-id="{{ $reservation->id }}"
                                            class="delete-reservation-btn px-3 py-1.5 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                                            Delete
                                        </a>

                                        <form id="delete-reservation-form" method="POST" style="display:none;">
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

    <!-- DOCUMENTS MODAL -->
    <div id="documentsModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl p-6 max-h-[90vh] overflow-auto">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Submitted Documents</h2>
            <p id="documentsReservationInfo" class="text-sm text-gray-600 mb-3"></p>
            <div id="documentsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
            <button onclick="closeDocumentsModal()"
                class="mt-5 px-4 py-2 bg-gray-700 text-white rounded hover:bg-black">
                Close
            </button>
        </div>
    </div>

    <!-- PAYMENTS LIST MODAL -->
    <div id="paymentListModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 overflow-auto max-h-[90vh]">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment History</h2>
            <p id="paymentListReservationInfo" class="text-sm text-gray-600 mb-3"></p>
            <table class="w-full text-sm border rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left">Amount</th>
                        <th class="px-3 py-2 text-left">Method</th>
                        <th class="px-3 py-2 text-left">Status</th>
                        <th class="px-3 py-2 text-left">Receipt</th>
                        <th class="px-3 py-2 text-left">Date</th>
                    </tr>
                </thead>
                <tbody id="paymentListBody"></tbody>
            </table>
            <button onclick="closePaymentListModal()"
                class="mt-5 px-4 py-2 bg-gray-700 text-white rounded hover:bg-black">
                Close
            </button>
        </div>
    </div>

    <!-- RECEIPT MODAL -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-4xl shadow-2xl">
            <h2 class="text-xl font-semibold mb-4">Payment Receipt</h2>
            <img id="receiptImage" class="w-full max-h-[80vh] object-contain rounded-lg shadow-lg border">
            <div class="text-right mt-4">
                <button onclick="closeReceiptModal()" class="px-5 py-2 bg-gray-700 text-white rounded hover:bg-black">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- ADMIN PAY NOW MODAL -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-2xl w-full shadow-2xl">
            <h2 class="text-lg font-semibold mb-4">Upload Payment Receipt</h2>
            <form id="adminPayNowForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="receipt" accept="image/*" required class="w-full border p-2 rounded mb-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Upload Receipt
                </button>
                <button type="button" onclick="closePaymentModal()"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 ml-2">
                    Cancel
                </button>
            </form>
        </div>
    </div>

</section>
@endsection

@push('scripts')
@include('components.alerts')
@include('admin.reservations-js')
@endpush
