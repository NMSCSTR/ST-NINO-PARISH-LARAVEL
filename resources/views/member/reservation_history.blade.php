@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="p-6">

    {{-- Header with Back Button --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 mt-10">
        <h2 class="text-2xl font-bold mb-3 md:mb-0">My Reservations</h2>

        <a href="{{ route('member.reservation') }}"
            class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 mt-5">
            ← Back to Reservation Form
        </a>
    </div>

    {{-- Reservations Table --}}
    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">

        @if($reservations->isEmpty())
            <p class="text-gray-600 text-center py-4">No reservations found.</p>
        @else
        <table class="w-full text-sm text-gray-700">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3 text-left">Sacrament</th>
                    <th class="p-3 text-left">Reservation Date</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3">{{ ucfirst($res->sacrament->sacrament_type) }}</td>
                    <td class="p-3">{{ $res->reservation_date?->format('M d, Y') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-white
                            {{ $res->status == 'approved' ? 'bg-green-600' :
                               ($res->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-lg detailBtn shadow"
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

    <div class="bg-white w-full max-w-xl rounded-lg shadow-2xl p-6 relative animate-fadeIn">

        <button id="closeModal" class="absolute top-2 right-3 text-2xl hover:text-red-600">&times;</button>

        <h2 class="text-xl font-bold mb-4 border-b pb-2">Reservation Details</h2>

        <div id="modalContent" class="text-gray-800">
            <p class="text-center py-4 text-gray-500">Loading details...</p>
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
            modalContent.innerHTML = `<p class="text-center py-4 text-gray-500">Loading...</p>`;

            let id = this.dataset.id;

            fetch(`/member/payments/${id}`)
                .then(res => {
                    if(!res.ok) throw new Error("Failed to fetch reservation details.");
                    return res.json();
                })
                .then(data => {
                    let html = `
                        <p><strong>Member:</strong> ${data.member}</p>
                        <p><strong>Sacrament:</strong> ${data.sacrament}</p>

                        <h3 class="mt-4 font-bold">Payments</h3>
                    `;

                    if (data.payments.length > 0) {
                        html += `
                            <div class="space-y-3 mt-3">
                                ${data.payments.map(p => `
                                    <div class="p-3 border rounded-lg bg-gray-50">
                                        <p><strong>Amount:</strong> ₱${p.amount}</p>
                                        <p><strong>Method:</strong> ${p.method}</p>
                                        <p><strong>Status:</strong> <span class="font-semibold">${p.status}</span></p>
                                        <p><strong>Date:</strong> ${p.date}</p>
                                        ${p.receipt_url ?
                                            `<img src="${p.receipt_url}"
                                                  class="w-full mt-2 rounded-lg border shadow cursor-zoom-in"
                                                  onclick="zoomReceipt(this.src)" alt="Receipt">`
                                            : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    } else {
                        html += `<p class="text-gray-500 mt-2">No payments found.</p>`;
                    }

                    modalContent.innerHTML = html;
                })
                .catch(err => {
                    modalContent.innerHTML = `
                        <p class="text-center text-red-600 py-4">
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
</style>
@endpush
