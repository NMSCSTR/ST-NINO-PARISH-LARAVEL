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

                                    <!-- Actions Dropdown -->
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block text-left">
                                            <button type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                                id="menu-button-{{ $reservation->id }}" aria-expanded="true"
                                                aria-haspopup="true">
                                                Actions
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            <!-- Dropdown menu -->
                                            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50"
                                                id="dropdown-{{ $reservation->id }}">
                                                <div class="py-1" role="menu" aria-orientation="vertical"
                                                    aria-labelledby="menu-button-{{ $reservation->id }}">

                                                    <!-- Forward (Staff/Admin only, if pending) -->
                                                    @if(in_array(auth()->user()->role, ['staff', 'admin']) &&
                                                    $reservation->status === 'pending')
                                                    <form
                                                        action="{{ route('admin.reservations.forward', $reservation->id) }}"
                                                        method="POST"
                                                        class="px-4 py-2 text-sm hover:bg-blue-50 flex items-center gap-2 text-blue-600"
                                                        role="menuitem"
                                                        onsubmit="return confirm('Are you sure you want to forward this reservation to the priest?');">
                                                        @csrf
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                        </svg>
                                                        <button type="submit" class="w-full text-left">Forward to
                                                            Priest</button>
                                                    </form>
                                                    @endif

                                                    <!-- Approve (Priest only, if forwarded) -->
                                                    @if(auth()->user()->role === 'priest' && $reservation->status ===
                                                    'forwarded_to_priest')
                                                    <form
                                                        action="{{ route('admin.reservations.approve', $reservation->id) }}"
                                                        method="POST"
                                                        class="px-4 py-2 text-sm hover:bg-green-50 flex items-center gap-2 text-green-600"
                                                        role="menuitem">
                                                        @csrf
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <button type="submit" class="w-full text-left">Approve</button>
                                                    </form>
                                                    @endif

                                                    <!-- Pay Now -->
                                                    <button onclick="openPaymentModal({{ $reservation->id }})"
                                                        class="px-4 py-2 text-sm hover:bg-blue-50 flex items-center gap-2 text-blue-600 w-full text-left">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3-.895-3-2 1.343-2 3-2z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 14v4m0 0l-2-2m2 2l2-2" />
                                                        </svg>
                                                        Pay Now
                                                    </button>

                                                    <!-- Edit -->
                                                    <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                                        class="block px-4 py-2 text-sm hover:bg-green-50 flex items-center gap-2 text-green-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M11 17l-4 4m0 0l4-4m-4 4V13" />
                                                        </svg>
                                                        Edit
                                                    </a>

                                                    <!-- Delete -->
                                                    <button data-id="{{ $reservation->id }}"
                                                        class="delete-reservation-btn block px-4 py-2 text-sm hover:bg-red-50 flex items-center gap-2 text-red-600 w-full text-left">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Delete
                                                    </button>

                                                    <!-- Documents -->
                                                    <button onclick="openDocumentsModal({{ $reservation->id }})"
                                                        class="px-4 py-2 text-sm hover:bg-purple-50 flex items-center gap-2 text-purple-600 w-full text-left">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12h6m2 0a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h10z" />
                                                        </svg>
                                                        Documents
                                                    </button>

                                                    <!-- Payments -->
                                                    <button onclick="openPaymentListModal({{ $reservation->id }})"
                                                        class="px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2 text-gray-700 w-full text-left">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 14l2-2 4 4M7 10h10v10H7V10z" />
                                                        </svg>
                                                        Payments
                                                    </button>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden Delete Form -->
                                        <form id="delete-reservation-form-{{ $reservation->id }}" method="POST"
                                            style="display:none;">
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
                        <th class="px-3 py-2 text-left">Payment Status</th>
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
