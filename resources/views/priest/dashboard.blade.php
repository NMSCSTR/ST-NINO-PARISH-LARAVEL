@extends('components.default')

@section('title', 'Priest Dashboard | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24 bg-gray-50">
        @include('components.admin.bg')
        @include('components.priest.topnav')

        <div class="px-4 lg:px-10 pb-10">
            {{-- Quick Stats Header --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Awaiting Decision</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $reservations->where('status', 'forwarded_to_priest')->count() }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-green-500">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Approved Today</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $reservations->where('status', 'approved')->where('reservation_date', now()->today())->count() }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 border-l-4 border-l-gray-400">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Handled</p>
                    <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $reservations->count() }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                {{-- Toolbar --}}
                <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Forwarded Reservations</h2>
                        <p class="text-sm text-gray-500">Review member details and requirements before approval.</p>
                    </div>
                    <a href="{{ route('priest.schedule.calendar') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        View My Calendar
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider text-xs">
                            <tr>
                                <th class="px-6 py-4">Member</th>
                                <th class="px-6 py-4">Sacrament</th>
                                <th class="px-6 py-4">Phone</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Forwarded Info</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reservations as $reservation)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}</div>
                                    <div class="text-xs text-gray-400">{{ $reservation->reservation_date?->format('M d, Y h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-xs uppercase">
                                        {{ $reservation->sacrament->sacrament_type ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">
                                    {{ $reservation->member->user->phone_number }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'approved' => 'text-green-600 bg-green-50',
                                            'forwarded_to_priest' => 'text-blue-600 bg-blue-50',
                                            'pending' => 'text-amber-600 bg-amber-50',
                                            'rejected' => 'text-red-600 bg-red-50',
                                        ];
                                        $class = $statusClasses[$reservation->status] ?? 'text-gray-600 bg-gray-50';
                                    @endphp
                                    <span class="{{ $class }} px-2.5 py-1 rounded-lg font-bold text-xs uppercase tracking-tight">
                                        {{ str_replace('_', ' ', $reservation->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($reservation->forwarded_by)
                                        <div class="text-xs font-bold text-gray-700">By: {{ $reservation->forwardedByUser->firstname }}</div>
                                        <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($reservation->forwarded_at)->format('M d, g:i A') }}</div>
                                    @else
                                        <span class="text-gray-300 italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="openDetailsModal({{ $reservation->id }})"
                                                class="px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 transition">
                                            Details
                                        </button>

                                        {{-- RESCHEDULE BUTTON --}}
                                        <button onclick="openRescheduleModal({{ $reservation->id }}, '{{ $reservation->reservation_date?->format('Y-m-d\TH:i') }}')"
                                                class="px-3 py-1.5 rounded-lg border border-amber-200 text-xs font-bold text-amber-600 hover:bg-amber-50 transition">
                                            Reschedule
                                        </button>

                                        @if($reservation->status === 'forwarded_to_priest')
                                        <button onclick="openActionModal({{ $reservation->id }})"
                                                class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-xs font-bold hover:bg-black transition shadow-sm">
                                            Decide
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- DECISION MODAL --}}
                            <div id="modal-{{ $reservation->id }}" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-200">
                                    <div class="bg-gray-900 px-6 py-4 flex justify-between items-center text-white">
                                        <h3 class="font-bold uppercase tracking-widest text-sm text-gray-300">Final Decision</h3>
                                        <button onclick="closeActionModal({{ $reservation->id }})" class="hover:text-gray-400">✕</button>
                                    </div>
                                    <div class="p-6 space-y-6">
                                        <form action="{{ route('priest.reservations.approve', $reservation->id) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <label class="text-xs font-bold text-gray-500 uppercase">Approval Remarks (Optional)</label>
                                            <textarea name="remarks" class="w-full border-gray-200 rounded-xl text-sm focus:ring-green-500 focus:border-green-500" rows="2" placeholder="e.g., Date is confirmed..."></textarea>
                                            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-xl hover:bg-green-700 shadow-lg shadow-green-100 transition">
                                                Confirm & Approve
                                            </button>
                                        </form>
                                        <div class="relative flex py-2 items-center">
                                            <div class="flex-grow border-t border-gray-100"></div>
                                            <span class="flex-shrink mx-4 text-gray-300 text-xs font-bold uppercase">OR</span>
                                            <div class="flex-grow border-t border-gray-100"></div>
                                        </div>
                                        <form action="{{ route('priest.reservations.reject', $reservation->id) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <textarea name="remarks" class="w-full border-gray-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" rows="2" placeholder="Reason for rejection..."></textarea>
                                            <button type="submit" class="w-full bg-white border border-red-200 text-red-600 font-bold py-3 rounded-xl hover:bg-red-50 transition">
                                                Reject Request
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- FULL DETAILS MODAL --}}
                            <div id="details-modal-{{ $reservation->id }}" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
                                <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-300">
                                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter">Review Reservation</h3>
                                        <button onclick="closeDetailsModal({{ $reservation->id }})" class="text-gray-400 hover:text-gray-900">✕</button>
                                    </div>
                                    <div class="p-8 overflow-y-auto max-h-[75vh]">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <div class="space-y-4">
                                                <h4 class="text-xs font-black text-blue-600 uppercase">Personal Details</h4>
                                                <div class="bg-gray-50 p-4 rounded-2xl">
                                                    <p class="text-sm font-bold text-gray-900">{{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}</p>
                                                    <p class="text-xs text-gray-500">{{ $reservation->member->user->email }}</p>
                                                    <p class="text-xs text-gray-500 mt-2 italic">{{ $reservation->member->address ?? 'No address provided' }}</p>
                                                </div>
                                            </div>
                                            <div class="space-y-4">
                                                <h4 class="text-xs font-black text-blue-600 uppercase">Sacrament Details</h4>
                                                <div class="bg-gray-50 p-4 rounded-2xl">
                                                    <p class="text-sm font-bold text-gray-900">{{ $reservation->sacrament->sacrament_type }}</p>
                                                    <p class="text-xs text-blue-600 font-bold">{{ $reservation->reservation_date?->format('F d, Y @ h:i A') }}</p>
                                                    <p class="text-xs text-gray-500 mt-2 font-bold">Fee: ₱{{ number_format($reservation->fee, 2) }}</p>
                                                </div>
                                            </div>
                                            <div class="md:col-span-2 space-y-4">
                                                <h4 class="text-xs font-black text-blue-600 uppercase">Requirements / Documents</h4>
                                                @if($reservation->documents->count())
                                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                                        @foreach($reservation->documents as $doc)
                                                            <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="group relative block rounded-xl overflow-hidden border border-gray-100 aspect-square bg-gray-100">
                                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">View Full</div>
                                                                <img src="{{ asset('storage/'.$doc->file_path) }}" class="w-full h-full object-cover">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="p-4 rounded-xl border border-dashed border-gray-200 text-center text-xs text-gray-400 italic">No documents uploaded.</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-8 py-5 flex justify-end gap-3">
                                        <button onclick="closeDetailsModal({{ $reservation->id }})" class="px-6 py-2 text-sm font-bold text-gray-500 hover:text-gray-900 transition">Dismiss</button>
                                        @if($reservation->status === 'forwarded_to_priest')
                                            <button onclick="closeDetailsModal({{ $reservation->id }}); openActionModal({{ $reservation->id }});" class="bg-blue-600 text-white px-6 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition">Take Action</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- UNIVERSAL RESCHEDULE MODAL --}}
<div id="priestRescheduleModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-[60] p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 animate-in fade-in slide-in-from-top-4 duration-300">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h2 class="text-2xl font-black text-gray-800">Change Date</h2>
        </div>

        <form id="priestRescheduleForm" method="POST">
            @csrf
            <div class="mb-8">
                <label class="block text-xs font-bold uppercase text-gray-400 mb-2">New Scheduled Date & Time</label>
                <input type="datetime-local" name="reservation_date" id="priestRescheduleInput"
                    class="w-full border-gray-200 rounded-xl focus:ring-amber-500 focus:border-amber-500 p-3 font-bold text-gray-700 bg-gray-50" required>
                <p class="mt-3 text-xs text-gray-500 italic">This will update the schedule and notify the member immediately.</p>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeRescheduleModal()"
                    class="flex-1 px-4 py-3 text-gray-500 font-bold hover:bg-gray-100 rounded-xl transition">Cancel</button>
                <button type="submit"
                    class="flex-1 bg-amber-600 text-white px-4 py-3 rounded-xl font-bold hover:bg-amber-700 transition shadow-lg shadow-amber-100">Update Schedule</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
@include('components.alerts')
<script>
    function openDetailsModal(id) {
        document.getElementById(`details-modal-${id}`).classList.remove('hidden');
        document.getElementById(`details-modal-${id}`).classList.add('flex');
    }
    function closeDetailsModal(id) {
        document.getElementById(`details-modal-${id}`).classList.add('hidden');
        document.getElementById(`details-modal-${id}`).classList.remove('flex');
    }
    function openActionModal(id) {
        document.getElementById(`modal-${id}`).classList.remove('hidden');
        document.getElementById(`modal-${id}`).classList.add('flex');
    }
    function closeActionModal(id) {
        document.getElementById(`modal-${id}`).classList.add('hidden');
        document.getElementById(`modal-${id}`).classList.remove('flex');
    }

    // NEW RESCHEDULE LOGIC
    function openRescheduleModal(id, currentDate) {
        const form = document.getElementById('priestRescheduleForm');
        const baseUrl = "{{ url('/') }}";
        form.action = baseUrl.replace(/\/$/, "") + "/priest/reservations/" + id + "/reschedule";

        document.getElementById('priestRescheduleInput').value = currentDate;
        document.getElementById('priestRescheduleModal').classList.remove('hidden');
        document.getElementById('priestRescheduleModal').classList.add('flex');
    }

    function closeRescheduleModal() {
        document.getElementById('priestRescheduleModal').classList.add('hidden');
        document.getElementById('priestRescheduleModal').classList.remove('flex');
    }
</script>
@endpush
