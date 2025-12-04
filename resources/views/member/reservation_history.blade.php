@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="p-6">

    {{-- Header with Back Button --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 mt-10 bg-gray-50 p-4 rounded-lg shadow-sm">
        <h2 class="text-3xl font-bold mb-3 md:mb-0 mt-2 text-gray-800">My Reservations</h2>

        <a href="{{ route('member.reservation') }}"
            class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition duration-200 shadow">
            ← Back to Reservation Form
        </a>
    </div>

    {{-- Reservations Table --}}
    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        @if($reservations->isEmpty())
            <p class="text-gray-600 text-center py-6 text-lg">No reservations found.</p>
        @else
        <table class="w-full text-sm text-gray-700 border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-left rounded-tl-lg">Sacrament</th>
                    <th class="p-3 text-left">Reservation Date</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center rounded-tr-lg">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                <tr class="border-b hover:bg-gray-50 transition duration-150">
                    <td class="p-3 text-lg font-medium">{{ ucfirst($res->sacrament->sacrament_type) }}</td>
                    <td class="p-3 text-lg">{{ $res->reservation_date?->format('M d, Y') }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white text-sm font-semibold
                            {{ $res->status == 'approved' ? 'bg-green-600' :
                               ($res->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150 detailBtn text-sm md:text-lg"
                            data-id="{{ $res->id }}">
                            View Details
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

    <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-6 relative animate-fadeIn scale-95">
        <button id="closeModal" class="absolute top-3 right-4 text-3xl hover:text-red-600">&times;</button>

        <h2 class="text-2xl font-bold mb-4 border-b pb-2 flex items-center space-x-2">
            <span class="material-icons text-blue-600">event_note</span>
            <span>Reservation Details</span>
        </h2>

        <div id="modalContent" class="text-gray-800 space-y-4 text-lg">
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

    document.querySelectorAll('.detailBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            modal.classList.remove('hidden');
            modalContent.innerHTML = `<p class="text-center py-6 text-gray-500 text-xl">Loading...</p>`;
            let id = this.dataset.id;
            fetch(`/member/payments/${id}`)
                .then(res => res.ok ? res.json() : Promise.reject("Failed"))
                .then(data => {
                    let html = `
                        <div class="space-y-3">
                            <p class="flex items-center space-x-2"><span class="material-icons text-blue-600">person</span> <strong>Member:</strong> ${data.member}</p>
                            <p class="flex items-center space-x-2"><span class="material-icons text-green-600">church</span> <strong>Sacrament:</strong> ${data.sacrament}</p>
                        </div>
                        <h3 class="mt-6 text-xl font-semibold flex items-center space-x-2">
                            <span class="material-icons text-yellow-600">payment</span>
                            <span>Payments</span>
                        </h3>
                    `;
                    if (data.payments.length > 0) {
                        html += `<div class="space-y-4 mt-4">` +
                            data.payments.map(p => `
                                <div class="p-4 border rounded-lg bg-gray-50 shadow-sm space-y-2">
                                    <p class="flex items-center space-x-2"><span class="material-icons text-green-600">attach_money</span> <strong>Amount:</strong> ₱${p.amount}</p>
                                    <p class="flex items-center space-x-2"><span class="material-icons text-blue-600">credit_card</span> <strong>Method:</strong> ${p.method}</p>
                                    <p class="flex items-center space-x-2"><span class="material-icons text-purple-600">info</span> <strong>Status:</strong> <span class="font-semibold">${p.status}</span></p>
                                    <p class="flex items-center space-x-2"><span class="material-icons text-orange-600">calendar_today</span> <strong>Date:</strong> ${p.date}</p>
                                    ${p.receipt_url ? `<p class="flex flex-col">
                                        <span class="material-icons text-red-600 mb-1">receipt</span>
                                        <img src="${p.receipt_url}" class="w-full rounded-lg border shadow cursor-zoom-in mt-1" onclick="zoomReceipt(this.src)" alt="Receipt">
                                    </p>` : ''}
                                </div>
                            `).join('') +
                        `</div>`;
                    } else {
                        html += `<p class="text-gray-500 mt-4 text-lg">No payments found.</p>`;
                    }
                    modalContent.innerHTML = html;
                })
                .catch(() => {
                    modalContent.innerHTML = `<p class="text-center text-red-600 py-6 text-xl">Error loading details. Please try again.</p>`;
                });
        });
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.add('hidden'); });

    function zoomReceipt(src) {
        receiptImage.src = src;
        receiptModal.classList.remove('hidden');
    }

    receiptModal.addEventListener('click', () => receiptModal.classList.add('hidden'));
</script>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.25s ease-in-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .material-icons {
        font-size: 1.5rem;
    }

    table th, table td {
        transition: background 0.2s;
    }
</style>
@endpush
