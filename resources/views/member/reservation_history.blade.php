@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="max-w-7xl mx-auto p-4 md:p-8 mt-12">

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

    {{-- Reservations Table --}}
    <div class="bg-white shadow-xl shadow-slate-200/60 rounded-2xl overflow-hidden border border-slate-100" data-aos="fade-up">
        @if($reservations->isEmpty())
            <div class="flex flex-col items-center py-20">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <span class="material-icons text-slate-300 text-4xl">event_busy</span>
                </div>
                <p class="text-slate-400 font-bold text-xl">No reservations found.</p>
                <p class="text-slate-400 text-sm">Your booked sacraments will appear here.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-0">
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
                    <tr class="group hover:bg-indigo-50/30 transition-all duration-200">
                        <td class="px-6 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 mr-4 group-hover:scale-110 transition-transform">
                                    <span class="material-icons text-2xl">church</span>
                                </div>
                                <span class="font-bold text-slate-700 text-lg">{{ ucfirst($res->sacrament->sacrament_type) }}</span>
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

{{-- MODERN MODAL DESIGN --}}
<div id="detailsModal"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">

    <div class="bg-white w-full max-w-5xl rounded-3xl shadow-2xl relative animate-slideUp max-h-[85vh] flex flex-col overflow-hidden">

        {{-- Modal Header --}}
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h2 class="text-2xl font-black text-slate-800 flex items-center">
                <span class="material-icons text-indigo-600 mr-3">receipt_long</span>
                Reservation Summary
            </h2>
            <button id="closeModal" class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-rose-100 hover:text-rose-600 transition-colors">
                <span class="material-icons">close</span>
            </button>
        </div>

        {{-- Modal Body --}}
        <div id="modalContent" class="p-8 overflow-y-auto flex-1">
            <div class="flex flex-col items-center justify-center py-20">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                <p class="mt-4 text-slate-500 font-bold tracking-widest uppercase text-xs">Fetching Records...</p>
            </div>
        </div>
    </div>
</div>

{{-- ZOOM MODAL --}}
<div id="receiptModal"
    class="fixed inset-0 bg-slate-950/90 hidden flex items-center justify-center p-8 z-[60] cursor-zoom-out">
    <img id="receiptImage" src="" class="max-w-full max-h-full rounded-lg shadow-2xl ring-4 ring-white/10" alt="Receipt Preview">
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
            modalContent.innerHTML = `
                <div class="flex flex-col items-center justify-center py-20 italic text-slate-400">
                    <div class="animate-pulse bg-slate-100 h-8 w-64 rounded-lg"></div>
                </div>`;

            let id = this.dataset.id;

            fetch(`/member/payments/${id}`)
                .then(res => res.ok ? res.json() : Promise.reject("Failed"))
                .then(data => {
                    let html = `
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <div class="lg:col-span-1 space-y-6">
                                <div class="p-6 bg-indigo-50 rounded-2xl border border-indigo-100">
                                    <h4 class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-4">Member Info</h4>
                                    <div class="space-y-4">
                                        <div class="flex items-center">
                                            <span class="material-icons-outlined text-indigo-600 mr-3 text-xl">account_circle</span>
                                            <div>
                                                <p class="text-xs text-slate-400 uppercase font-bold">Name</p>
                                                <p class="font-black text-slate-700">${data.member}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="material-icons-outlined text-indigo-600 mr-3 text-xl">church</span>
                                            <div>
                                                <p class="text-xs text-slate-400 uppercase font-bold">Sacrament</p>
                                                <p class="font-black text-slate-700">${data.sacrament}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="docSection" class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Required Documents</h4>
                                    <div id="docList" class="space-y-3 italic text-slate-400 text-sm">Loading documents...</div>
                                </div>
                            </div>

                            <div class="lg:col-span-2 space-y-4">
                                <h3 class="text-xl font-black text-slate-800 flex items-center">
                                    <span class="material-icons text-emerald-500 mr-2">payments</span>
                                    Payment History
                                </h3>
                                ${data.payments.length > 0 ? `
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        ${data.payments.map(p => `
                                            <div class="p-5 border border-slate-100 rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                                                <div class="flex justify-between items-start mb-3">
                                                    <span class="text-2xl font-black text-slate-800">₱${p.amount}</span>
                                                    <span class="px-2 py-1 bg-slate-100 text-[10px] font-black rounded uppercase">${p.status}</span>
                                                </div>
                                                <div class="space-y-1 text-sm text-slate-500 mb-4">
                                                    <p class="flex items-center"><span class="material-icons text-xs mr-2">credit_card</span> ${p.method}</p>
                                                    <p class="flex items-center"><span class="material-icons text-xs mr-2">event</span> ${p.date}</p>
                                                </div>
                                                ${p.receipt_url ? `
                                                    <button onclick="zoomReceipt('${p.receipt_url}')" class="w-full h-32 overflow-hidden rounded-xl border relative group">
                                                        <img src="${p.receipt_url}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <span class="material-icons text-white">zoom_in</span>
                                                        </div>
                                                    </button>
                                                ` : ''}
                                            </div>
                                        `).join('')}
                                    </div>
                                ` : `<div class="p-10 border-2 border-dashed border-slate-100 rounded-3xl text-center text-slate-400 font-bold">No payments found.</div>`}
                            </div>
                        </div>
                    `;

                    modalContent.innerHTML = html;

                    // Fetch Documents Secondarily
                    fetch(`/member/reservations/${id}/documents`)
                        .then(res => res.json())
                        .then(docData => {
                            const docContainer = document.getElementById('docList');
                            if (docData.documents.length > 0) {
                                docContainer.innerHTML = docData.documents.map(doc => `
                                    <a href="${doc.url}" target="_blank" class="flex items-center p-3 bg-white border border-slate-200 rounded-xl hover:text-indigo-600 hover:border-indigo-600 transition-all">
                                        <span class="material-icons text-indigo-500 mr-3">file_present</span>
                                        <span class="truncate font-bold text-sm">View Document</span>
                                    </a>
                                `).join('');
                            } else {
                                docContainer.innerHTML = 'No documents found.';
                            }
                        });
                });
        });
    });

    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
    function zoomReceipt(src) {
        receiptImage.src = src;
        receiptModal.classList.remove('hidden');
    }
    receiptModal.addEventListener('click', () => receiptModal.classList.add('hidden'));
</script>

<style>
    .animate-slideUp {
        animation: slideUp 0.3s ease-out forwards;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    /* Hide scrollbar but keep functionality for cleaner look */
    #modalContent::-webkit-scrollbar { width: 6px; }
    #modalContent::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endpush
