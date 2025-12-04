@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="p-6">

    {{-- Header with Back Button --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 mt-10 bg-gray-50 p-4 rounded-lg shadow-sm">
        <h2 class="text-3xl font-extrabold mb-3 md:mb-0 mt-2 text-gray-800">My Reservations</h2>

        <a href="{{ route('member.reservation') }}"
            class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition duration-200 shadow font-semibold">
            ← Back to Reservation Form
        </a>
    </div>

    {{-- Reservations Table --}}
    <div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
        @if($reservations->isEmpty())
            <p class="text-gray-600 text-center py-6 text-lg">No reservations found.</p>
        @else
        <table class="w-full text-sm md:text-base text-gray-700 border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-3 text-left rounded-tl-lg font-bold text-lg">Sacrament</th>
                    <th class="p-3 text-left font-bold text-lg">Reservation Date</th>
                    <th class="p-3 text-left font-bold text-lg">Status</th>
                    <th class="p-3 text-center rounded-tr-lg font-bold text-lg">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                <tr class="border-b hover:bg-gray-50 transition duration-150">
                    <td class="p-3 text-lg font-semibold">{{ ucfirst($res->sacrament->sacrament_type) }}</td>
                    <td class="p-3 text-lg font-semibold">{{ $res->reservation_date?->format('M d, Y') }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-white text-base font-bold
                            {{ $res->status == 'approved' ? 'bg-green-600' :
                               ($res->status == 'pending' ? 'bg-yellow-500' : 'bg-red-600') }}">
                            {{ ucfirst($res->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-center">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150 detailBtn text-base font-semibold"
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
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center p-4 z-50">

    <div class="bg-white w-full max-w-6xl rounded-xl shadow-2xl relative animate-fadeIn max-h-[90vh] flex flex-col">

        {{-- Close Button --}}
        <button id="closeModal" class="absolute top-4 right-4 text-3xl hover:text-red-600 z-10">&times;</button>

        {{-- Scrollable Content --}}
        <div class="p-8 overflow-y-auto flex-1 space-y-8">
            <h2 class="text-3xl font-extrabold border-b pb-3 flex items-center space-x-3">
                <span class="material-icons text-blue-600 text-3xl">event_note</span>
                <span>Reservation Details</span>
            </h2>

            <div id="modalContent" class="text-gray-800 text-lg">
                <p class="text-center py-10 text-gray-500 text-xl">Loading details...</p>
            </div>
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
            modalContent.innerHTML = `<p class="text-center py-10 text-gray-500 text-xl">Loading...</p>`;
            let id = this.dataset.id;

            // Fetch reservation details
            fetch(`/member/payments/${id}`)
                .then(res => res.ok ? res.json() : Promise.reject("Failed"))
                .then(data => {
                    let html = `
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-lg">
                            <div class="space-y-4">
                                <p class="font-bold text-xl flex items-center space-x-3"><span class="material-icons text-blue-600 text-2xl">person</span> <span>Member:</span> <span class="font-semibold text-xl">${data.member}</span></p>
                                <p class="font-bold text-xl flex items-center space-x-3"><span class="material-icons text-green-600 text-2xl">church</span> <span>Sacrament:</span> <span class="font-semibold text-xl">${data.sacrament}</span></p>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-2xl font-bold flex items-center space-x-3">
                                    <span class="material-icons text-yellow-600 text-2xl">payment</span>
                                    <span>Payments</span>
                                </h3>
                                ${data.payments.length > 0 ? `<div class="space-y-5">` +
                                    data.payments.map(p => `
                                        <div class="p-5 border rounded-lg bg-gray-50 shadow-sm space-y-3">
                                            <p class="font-bold text-lg flex items-center space-x-2"><span class="material-icons text-green-600">attach_money</span> <span>Amount:</span> <span class="font-semibold text-lg">₱${p.amount}</span></p>
                                            <p class="font-bold text-lg flex items-center space-x-2"><span class="material-icons text-blue-600">credit_card</span> <span>Method:</span> <span class="font-semibold text-lg">${p.method}</span></p>
                                            <p class="font-bold text-lg flex items-center space-x-2"><span class="material-icons text-purple-600">info</span> <span>Status:</span> <span class="font-semibold text-lg">${p.status}</span></p>
                                            <p class="font-bold text-lg flex items-center space-x-2"><span class="material-icons text-orange-600">calendar_today</span> <span>Date:</span> <span class="font-semibold text-lg">${p.date}</span></p>
                                            ${p.receipt_url ? `<p class="flex flex-col">
                                                <span class="material-icons text-red-600 mb-1">receipt</span>
                                                <img src="${p.receipt_url}" class="w-full rounded-lg border shadow cursor-zoom-in mt-2" onclick="zoomReceipt(this.src)" alt="Receipt">
                                            </p>` : ''}
                                        </div>
                                    `).join('') +
                                `</div>` : `<p class="text-gray-500 mt-2 font-semibold text-lg">No payments found.</p>`}
                            </div>
                        </div>
                    `;

                    modalContent.innerHTML = html;

                    // Fetch reservation documents
                    fetch(`/member/reservations/${id}/documents`)
                        .then(res => res.ok ? res.json() : Promise.reject("Failed to fetch documents"))
                        .then(docData => {
                            if (docData.documents.length > 0) {
                                let docHtml = `
                                    <h3 class="mt-8 text-2xl font-bold flex items-center space-x-3">
                                        <span class="material-icons text-purple-600 text-2xl">description</span>
                                        <span>Submitted Documents</span>
                                    </h3>
                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                        ${docData.documents.map(doc => `
                                            <a href="${doc.url}" target="_blank" class="p-5 border rounded-lg shadow-sm hover:bg-gray-50 flex items-center space-x-3 transition font-semibold text-lg">
                                                <span class="material-icons text-blue-600 text-2xl">insert_drive_file</span>
                                                <span class="truncate">Document #${doc.id}</span>
                                            </a>
                                        `).join('')}
                                    </div>
                                `;
                                modalContent.innerHTML += docHtml;
                            } else {
                                modalContent.innerHTML += `<p class="text-gray-500 mt-4 font-semibold text-lg">No documents uploaded.</p>`;
                            }
                        })
                        .catch(err => {
                            modalContent.innerHTML += `<p class="text-center text-red-600 py-4 font-bold text-lg">Failed to load documents.</p>`;
                        });
                })
                .catch(() => {
                    modalContent.innerHTML = `<p class="text-center text-red-600 py-10 font-bold text-xl">Error loading details. Please try again.</p>`;
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
        font-size: 1.8rem;
    }

    table th, table td {
        transition: background 0.2s;
    }

    /* Scrollbar styling for modal */
    #detailsModal .flex-1::-webkit-scrollbar {
        width: 10px;
    }

    #detailsModal .flex-1::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.3);
        border-radius: 5px;
    }
</style>
@endpush
