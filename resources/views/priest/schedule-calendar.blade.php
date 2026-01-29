@extends('components.default')

@section('title', "Approved Schedule | Year $year")

@section('content')
<section class="bg-gray-50 min-h-screen">
    @include('components.priest.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">

        {{-- Header & Year Navigation --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <a href="{{ route('priest.dashboard') }}" class="text-sm text-blue-600 font-bold flex items-center gap-1 mb-2 hover:underline transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Back to Dashboard
                </a>
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">
                    Yearly Schedule: {{ $year }}
                </h2>
            </div>

            {{-- Year Selection Navigation --}}
            <div class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border border-gray-200">
                <a href="?year={{ $year - 1 }}" class="p-2 hover:bg-gray-100 rounded-lg transition text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="px-4 text-sm font-black text-blue-600">{{ $year }}</span>
                <a href="?year={{ $year + 1 }}" class="p-2 hover:bg-gray-100 rounded-lg transition text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Months Grid --}}
        <div class="space-y-16">
            @for ($m = 1; $m <= 12; $m++)
                @php
                    $startOfMonth = \Carbon\Carbon::createFromDate($year, $m, 1);
                    $daysInMonth = $startOfMonth->daysInMonth;
                    $firstDayOfWeek = $startOfMonth->dayOfWeek;
                @endphp

                <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                    {{-- Month Label --}}
                    <div class="bg-gray-900 px-6 py-4">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">
                            {{ $startOfMonth->format('F') }}
                        </h3>
                    </div>

                    {{-- Weekday Headers --}}
                    <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50">
                        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $dayName)
                            <div class="py-4 text-center text-xs font-black text-gray-400 uppercase tracking-widest">{{ $dayName }}</div>
                        @endforeach
                    </div>

                    {{-- Grid Cells --}}
                    <div class="grid grid-cols-7 auto-rows-[minmax(100px,_auto)]">
                        {{-- Blank days at start --}}
                        @for($i=0; $i<$firstDayOfWeek; $i++)
                            <div class="border-r border-b border-gray-50 bg-gray-50/30"></div>
                        @endfor

                        {{-- Actual days --}}
                        @for($day=1; $day<=$daysInMonth; $day++)
                            @php
                                $dateObj = \Carbon\Carbon::createFromDate($year, $m, $day);
                                $dateString = $dateObj->format('Y-m-d');
                                $dayReservations = $reservations[$dateString] ?? collect();
                                $isToday = now()->format('Y-m-d') === $dateString;
                            @endphp

                            <div class="p-2 border-r border-b border-gray-100 flex flex-col gap-2 transition hover:bg-gray-50/80 {{ $isToday ? 'bg-blue-50/50' : '' }}">
                                <div class="flex justify-between items-start">
                                    <span class="inline-flex items-center justify-center w-7 h-7 text-xs font-black rounded-full {{ $isToday ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-400' }}">
                                        {{ $day }}
                                    </span>
                                </div>

                                {{-- Event List --}}
                                <div class="flex flex-col gap-1 overflow-y-auto max-h-24 custom-scrollbar">
                                    @foreach($dayReservations as $res)
                                        @php
                                            $type = $res->sacrament->sacrament_type ?? 'Other';
                                            $color = match($type) {
                                                'Baptism' => 'bg-blue-50 text-blue-700 border-blue-100 hover:bg-blue-100',
                                                'Wedding' => 'bg-amber-50 text-amber-700 border-amber-100 hover:bg-amber-100',
                                                'Funeral' => 'bg-purple-50 text-purple-700 border-purple-100 hover:bg-purple-100',
                                                default   => 'bg-gray-50 text-gray-700 border-gray-100 hover:bg-gray-100'
                                            };
                                        @endphp
                                        <button type="button" onclick="openCalModal({{ $res->id }})"
                                            class="text-[9px] font-bold py-1 px-1.5 rounded border {{ $color }} truncate text-left transition transform active:scale-95">
                                            {{ $res->reservation_date?->format('h:i A') }} | {{ $res->member->user->firstname }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>

{{-- MODALS SECTION --}}
<div id="modal-container">
    @foreach($reservations->flatten() as $res)
        <div id="details-modal-{{ $res->id }}" class="fixed inset-0 bg-gray-900/70 backdrop-blur-md hidden items-center justify-center z-[100] p-4 transition-all duration-300">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all scale-95 opacity-0 modal-content-inner">
                {{-- Modal Header --}}
                <div class="bg-gray-900 px-8 py-5 flex justify-between items-center text-white">
                    <div>
                        <h3 class="font-bold uppercase tracking-widest text-xs text-gray-400">Appointment Details</h3>
                        <p class="text-lg font-black">{{ $res->sacrament->sacrament_type }}</p>
                    </div>
                    <button onclick="closeCalModal({{ $res->id }})" class="p-2 hover:bg-white/10 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">Schedule</h4>
                            <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100">
                                <p class="text-lg font-black text-blue-900">{{ $res->reservation_date?->format('F d, Y') }}</p>
                                <p class="text-sm font-bold text-blue-600">{{ $res->reservation_date?->format('l @ h:i A') }}</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-3">Member Details</h4>
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                <p class="text-sm font-bold text-gray-900">{{ $res->member->user->firstname }} {{ $res->member->user->lastname }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $res->member->user->phone_number }}</p>
                                <p class="text-xs text-gray-500 italic">{{ $res->member->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    @if($res->remarks)
                    <div>
                        <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Special Remarks</h4>
                        <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100 text-sm text-gray-700 italic">
                            "{{ $res->remarks }}"
                        </div>
                    </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-8 py-5 flex justify-end">
                    <button onclick="closeCalModal({{ $res->id }})" class="bg-gray-900 text-white px-10 py-3 rounded-xl text-sm font-bold hover:bg-black transition shadow-lg shadow-gray-200">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

    .modal-active .modal-content-inner {
        transform: scale(1);
        opacity: 1;
    }
</style>
@endsection

@push('scripts')
<script>
    function openCalModal(id) {
        const modal = document.getElementById(`details-modal-${id}`);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add('modal-active');
        }, 10);
    }

    function closeCalModal(id) {
        const modal = document.getElementById(`details-modal-${id}`);
        modal.classList.remove('modal-active');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }

    window.onclick = function(event) {
        if (event.target.id.startsWith('details-modal-')) {
            const id = event.target.id.replace('details-modal-', '');
            closeCalModal(id);
        }
    }
</script>
@endpush
