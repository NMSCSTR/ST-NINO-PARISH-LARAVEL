@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="flex flex-col items-center mt-10 px-4">

    {{-- Header with Back Button --}}
    <div class="w-full max-w-4xl flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-3xl font-bold mb-3 md:mb-0 mt-2 flex items-center space-x-2">
            <span class="material-icons text-blue-600 text-4xl">event_note</span>
            <span>My Reservations</span>
        </h2>

        <a href="{{ route('member.reservation') }}"
            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 mt-4 md:mt-0 flex items-center space-x-1">
            <span class="material-icons text-white">arrow_back</span>
            <span>Back to Reservation Form</span>
        </a>
    </div>

    {{-- Reservations Table --}}
    <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-4xl overflow-x-auto">

        @if($reservations->isEmpty())
            <p class="text-gray-600 text-center py-6 text-lg">No reservations found.</p>
        @else
        <table class="w-full text-lg text-gray-700 table-auto">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-4 text-left flex items-center space-x-1"><span class="material-icons text-blue-600">church</span>Sacrament</th>
                    <th class="p-4 text-left flex items-center space-x-1"><span class="material-icons text-green-600">calendar_today</span>Reservation Date</th>
                    <th class="p-4 text-left flex items-center space-x-1"><span class="material-icons text-yellow-600">info</span>Status</th>
                    <th class="p-4 text-center"><span class="material-icons text-purple-600">visibility</span>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4 text-lg">{{ ucfirst($res->sacrament->sacrament_type) }}</td>
                    <td class="p-4 text-lg">{{ $res->reservation_date?->format('M d, Y') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded text-white text-lg
                            {{ $res->status == 'approved' ? 'bg-green-600' :
                               ($res->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg detailBtn shadow text-lg flex items-center justify-center space-x-1"
                            data-id="{{ $res->id }}">
                            <span class="material-icons text-white">visibility</span>
                            <span>View Details</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

</div>

{{-- RESERVATION DETAILS MODAL --}}
<div id="detailsModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50 overflow-y-auto">

    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-6 relative animate-fadeIn">

        <button id="closeModal" class="absolute top-3 right-4 text-3xl hover:text-red-600">&times;</button>

        <h2 class="text-2xl font-bold mb-6 border-b pb-2 flex items-center space-x-3">
            <span class="material-icons text-blue-600 text-4xl">event_note</span>
            <span>Reservation Details</span>
        </h2>

        <div id="modalContent" class="text-gray-800 space-y-6 text-lg">
            <p class="text-center py-6 text-gray-500 text-xl">Loading details...</p>
        </div>

    </div>
</div>

{{-- RECEIPT IMAGE ZOOM MODAL --}}
<div id="receiptModal"
    class="fixed inset-0 bg-black bg-opacity-80 hidden flex items-center justify-center p-4 z-50 cursor-zoom-out overflow-auto">
    <img id="receiptImage" src="" class="max-w-full max-h-full rounded-lg shadow-lg" alt="Receipt Image">
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');
    const modalContent = document.getElementById('modalContent');

    const receiptModal = document.getElementById('receiptModal');
    const receiptImage = document.getElementById('receiptImage');

    // OPEN RESERVATION DETAILS MODAL
    document.querySelectorAll('.detailBtn').forEach(btn => {
        btn.addEventListener('click', function () {

            modal.classList.remove('hidden');
            modalContent.innerHTML = `<p class="text-center py-6 text-gray-500 text-xl">Loading...</p>`;

            let id = this.dataset.id;

            fetch(`/member/payments/${id}`)
                .then(res => {
                    if(!res.ok) throw new Error("Failed to fetch reservation details.");
                    return res.json();
                })
                .then(data => {
                    let html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3 p-4 border rounded-xl bg-gray-50 shadow-sm">
                                <p class="flex items-center space-x-2"><span class="material-icons text-blue-600">person</span> <strong>Member:</strong> ${data.member}</p>
                                <p class="flex items-center space-x-2"><span class="material-icons text-green-600">church</span> <strong>Sacrament:</strong> ${data.sacrament}</p>
                            </div>

                            <div class="space-y-3 p-4 border rounded-xl bg-gray-50 shadow-sm">
                                <h3 class="text-xl font-semibold flex items-center space-x-2 mb-2">
                                    <span class="material-icons text-yellow-600">payment</span>
                                    <span>Payments</span>
                                </h3>
                    `;

                    if (data.payments.length > 0) {
                        html += `
                            <div class="space-y-4 mt-2">
                                ${data.payments.map(p => `
                                    <div class="p-4 border rounded-lg bg-white shadow-sm space-y-2">
                                        <p class="flex items-center space-x-2"><span class="material-icons text-green-600">attach_money</span> <strong>Amount:</strong> ₱${p.amount}</p>
                                        <p class="flex items-center space-x-2"><span class="material-icons text-blue-600">credit_card</span> <strong>Method:</strong> ${p.method}</p>
                                        <p class="flex items-center space-x-2"><span class="material-icons text-purple-600">info</span> <strong>Status:</strong> <span class="font-semibold">${p.status}</span></p>
                                        <p class="flex items-center space-x-2"><span class="material-icons text-orange-600">calendar_today</span> <strong>Date:</strong> ${p.date}</p>
                                        ${p.receipt_url ?
                                            `<p class="flex flex-col">
                                                <span class="material-icons text-red-600 mb-1">receipt</span>
                                                <img src="${p.receipt_url}"
                                                    class="w-full rounded-lg border shadow cursor-zoom-in mt-1"
                                                    onclick="zoomReceipt(this.src)" alt="Receipt">
                                            </p>` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    } else {
                        html += `<p class="text-gray-500 mt-2 text-lg">No payments found.</p>`;
                    }

                    html += `</div></div>`; // Close grid columns

                    modalContent.innerHTML = html;
                })
                .catch(err => {
                    modalContent.innerHTML = `
                        <p class="text-center text-red-600 py-6 text-xl">
                            Error loading details. Please try again.
                        </p>`;
                });
        });
    });

    // CLOSE RESERVATION MODAL
    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.add('hidden'); });

    // OPEN RECEIPT IMAGE MODAL
    function zoomReceipt(src) {
        receiptImage.src = src;
        receiptModal.classList.remove('hidden');
    }

    // CLOSE RECEIPT IMAGE MODAL
    receiptModal.addEventListener('click', () => receiptModal.classList.add('hidden'));
</script>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.25s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .material-icons {
        font-size: 1.6rem;
    }
</style>
@endpush
