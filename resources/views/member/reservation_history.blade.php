@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="max-w-12xl mx-auto p-10 md:p-8 pt-20 md:pt-28">

    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4" data-aos="fade-down">
        <div>
            <h2 class="text-4xl font-black text-slate-800 tracking-tight">My Reservations</h2>
            <p class="text-slate-500 font-medium">Manage and track your sacrament schedules and payments.</p>
        </div>

        <a href="{{ route('member.reservation') }}"
            class="flex items-center px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all duration-300 shadow-lg shadow-indigo-200 font-bold group">
            <span class="material-icons text-sm mr-2 transition-transform group-hover:-translate-x-1">arrow_back</span>
            Reservation Form
        </a>
    </div>

    {{-- Filter Toggle --}}
    <div class="flex items-center space-x-2 mb-6 overflow-x-auto pb-2 no-scrollbar" data-aos="fade-right">
        <button onclick="filterTable('all')" class="filter-btn active-filter px-5 py-2 rounded-full text-sm font-bold transition-all whitespace-nowrap">
            All Reservations
        </button>
        <button onclick="filterTable('pending')" class="filter-btn px-5 py-2 rounded-full text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all whitespace-nowrap">
            Pending
        </button>
        <button onclick="filterTable('approved')" class="filter-btn px-5 py-2 rounded-full text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all whitespace-nowrap">
            Approved
        </button>
        <button onclick="filterTable('rejected')" class="filter-btn px-5 py-2 rounded-full text-sm font-bold text-slate-500 hover:bg-slate-100 transition-all whitespace-nowrap">
            Rejected
        </button>
    </div>

    {{-- Reservations Table --}}
    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-2xl overflow-hidden border border-slate-100" data-aos="fade-up">
        @if($reservations->isEmpty())
            <div class="flex flex-col items-center py-20">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <span class="material-icons text-slate-300 text-4xl">event_busy</span>
                </div>
                <p class="text-slate-400 font-bold text-xl">No reservations found.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0" id="reservationsTable">
                <thead>
                    <tr class="bg-slate-50/80">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Sacrament</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Reservation Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach ($reservations as $res)
                    <tr class="reservation-row group hover:bg-indigo-50/30 transition-all duration-200" data-status="{{ strtolower($res->status) }}">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4 group-hover:scale-110 transition-transform">
                                    <span class="material-icons text-2xl">church</span>
                                </div>
                                <span class="font-bold text-slate-700 text-lg text-type">{{ ucfirst($res->sacrament->sacrament_type) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-600">{{ $res->reservation_date?->format('M d, Y') }}</span>
                                <span class="text-xs text-slate-400">Scheduled Date</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $statusClasses = [
                                    'approved' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                    'rejected' => 'bg-rose-100 text-rose-700 border-rose-200'
                                ];
                                $currentClass = $statusClasses[strtolower($res->status)] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-tighter border {{ $currentClass }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button
                                class="inline-flex items-center bg-white border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 text-slate-600 px-4 py-2 rounded-xl shadow-sm transition-all duration-200 detailBtn font-bold text-sm"
                                data-id="{{ $res->id }}">
                                <span class="material-icons text-base mr-2">visibility</span>
                                Details
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- DETAILS MODAL --}}
<div id="detailsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl relative animate-slideUp max-h-[85vh] flex flex-col overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-2xl font-black text-slate-800 flex items-center">
                <span class="material-icons text-indigo-600 mr-3">receipt_long</span>
                Reservation Summary
            </h2>
            <button id="closeModal" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-rose-100 hover:text-rose-600">
                <span class="material-icons">close</span>
            </button>
        </div>
        <div id="modalContent" class="p-8 overflow-y-auto flex-1">
            {{-- Dynamically loaded content --}}
        </div>
    </div>
</div>

{{-- IN-PAGE DOCUMENT VIEWER MODAL --}}
<div id="docViewerModal" class="fixed inset-0 bg-slate-950/95 hidden flex flex-col z-[70] animate-fadeIn">
    <div class="p-4 flex justify-between items-center text-white bg-slate-900">
        <span id="docTitle" class="font-bold truncate max-w-md">Document Viewer</span>
        <button id="closeDocViewer" class="px-4 py-2 bg-rose-600 rounded-lg font-bold text-sm hover:bg-rose-700 transition-colors">
            Close Viewer
        </button>
    </div>
    <div class="flex-1 w-full h-full bg-slate-800 flex items-center justify-center">
        <iframe id="docFrame" src="" class="w-full h-full border-none shadow-2xl" allow="autoplay"></iframe>
        <img id="docImg" src="" class="hidden max-w-full max-h-full object-contain" />
    </div>
</div>

{{-- RECEIPT ZOOM (For images only) --}}
<div id="receiptModal" class="fixed inset-0 bg-slate-950/90 hidden flex items-center justify-center p-8 z-[80] cursor-zoom-out">
    <img id="receiptImage" src="" class="max-w-full max-h-full rounded-lg shadow-2xl" alt="Receipt Preview">
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');
    const modalContent = document.getElementById('modalContent');
    const docViewerModal = document.getElementById('docViewerModal');
    const closeDocViewer = document.getElementById('closeDocViewer');
    const docFrame = document.getElementById('docFrame');
    const docImg = document.getElementById('docImg');
    const receiptModal = document.getElementById('receiptModal');
    const receiptImage = document.getElementById('receiptImage');

    // Filter Logic
    function filterTable(status) {
        const rows = document.querySelectorAll('.reservation-row');
        const buttons = document.querySelectorAll('.filter-btn');

        buttons.forEach(btn => {
            btn.classList.remove('active-filter', 'bg-indigo-600', 'text-white');
            btn.classList.add('text-slate-500');
        });

        event.target.classList.add('active-filter', 'bg-indigo-600', 'text-white');
        event.target.classList.remove('text-slate-500');

        rows.forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Detail Modal Logic
    document.querySelectorAll('.detailBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            modal.classList.remove('hidden');
            modalContent.innerHTML = `<div class="flex justify-center py-20"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-600"></div></div>`;

            let id = this.dataset.id;

            fetch(`/member/payments/${id}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-1 space-y-6">
                                <div class="p-6 bg-indigo-50 rounded-2xl border border-indigo-100">
                                    <h4 class="text-xs font-black text-indigo-400 uppercase mb-4 tracking-widest">Member Info</h4>
                                    <div class="space-y-4 font-bold text-slate-700">
                                        <p class="text-sm uppercase text-slate-400 mb-1 font-black tracking-tight">Name</p>
                                        <p class="mb-4">${data.member}</p>
                                        <p class="text-sm uppercase text-slate-400 mb-1 font-black tracking-tight">Sacrament</p>
                                        <p>${data.sacrament}</p>
                                    </div>
                                </div>
                                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                    <h4 class="text-xs font-black text-slate-400 uppercase mb-4 tracking-widest">Documents</h4>
                                    <div id="docList" class="space-y-3 font-bold text-sm text-slate-400 italic">Checking documents...</div>
                                </div>
                            </div>
                            <div class="lg:col-span-2">
                                <h3 class="text-xl font-black text-slate-800 mb-4">Payment History</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    ${data.payments.map(p => `
                                        <div class="p-5 border border-slate-100 rounded-2xl bg-white shadow-sm">
                                            <div class="flex justify-between mb-2">
                                                <span class="text-2xl font-black text-slate-800">₱${p.amount}</span>
                                                <span class="text-[10px] font-black uppercase text-slate-400">${p.status}</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mb-4">${p.date} • ${p.method}</p>
                                            ${p.receipt_url ? `
                                                <button onclick="viewFile('${p.receipt_url}', 'Payment Receipt')" class="w-full h-24 bg-slate-100 rounded-xl flex items-center justify-center hover:bg-slate-200 transition-colors">
                                                    <span class="material-icons text-slate-400 mr-2">image</span>
                                                    <span class="text-xs font-black text-slate-500">View Receipt</span>
                                                </button>
                                            ` : ''}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                    modalContent.innerHTML = html;

                    fetch(`/member/reservations/${id}/documents`)
                        .then(res => res.json())
                        .then(docData => {
                            const docContainer = document.getElementById('docList');
                            if (docData.documents.length > 0) {
                                docContainer.innerHTML = docData.documents.map(doc => `
                                    <button onclick="viewFile('${doc.url}', 'Document Viewer')" class="w-full flex items-center p-3 bg-white border border-slate-200 rounded-xl hover:border-indigo-600 hover:text-indigo-600 transition-all text-left">
                                        <span class="material-icons text-indigo-500 mr-3">file_present</span>
                                        <span class="truncate font-bold text-sm">View Document</span>
                                    </button>
                                `).join('');
                            } else {
                                docContainer.innerHTML = 'No documents attached.';
                            }
                        });
                });
        });
    });

    // In-Page Document Viewer
    function viewFile(url, title) {
        const isPdf = url.toLowerCase().endsWith('.pdf');
        document.getElementById('docTitle').innerText = title;

        if (isPdf) {
            docFrame.src = url;
            docFrame.classList.remove('hidden');
            docImg.classList.add('hidden');
        } else {
            docImg.src = url;
            docImg.classList.remove('hidden');
            docFrame.classList.add('hidden');
            docFrame.src = "";
        }

        docViewerModal.classList.remove('hidden');
    }

    closeDocViewer.addEventListener('click', () => {
        docViewerModal.classList.add('hidden');
        docFrame.src = ""; // Stop PDF loading
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    receiptModal.addEventListener('click', () => receiptModal.classList.add('hidden'));

</script>

<style>
    .active-filter {
        background-color: #4f46e5;
        color: white;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }
    .animate-slideUp { animation: slideUp 0.3s ease-out forwards; }
    .animate-fadeIn { animation: fadeIn 0.2s ease-in forwards; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endpush
