@extends('components.default')

@section('title', 'My Approved Schedule | Calendar View')

@section('content')
<section class="bg-gray-50 min-h-screen">
    @include('components.priest.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">

        {{-- Header & Navigation --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <a href="{{ route('priest.dashboard') }}" class="text-sm text-blue-600 font-bold flex items-center gap-1 mb-2 hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                    Back to Dashboard
                </a>
                <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">
                    {{ $startOfMonth->format('F Y') }}
                </h2>
            </div>

            <div class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border">
                {{-- These routes assume you have a method to handle month offsets --}}
                <a href="?month={{ $startOfMonth->copy()->subMonth()->format('Y-m') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="px-4 text-sm font-bold text-gray-700">Today</span>
                <a href="?month={{ $startOfMonth->copy()->addMonth()->format('Y-m') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase">
                <span class="w-3 h-3 bg-blue-500 rounded-full"></span> Baptism
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase">
                <span class="w-3 h-3 bg-amber-500 rounded-full"></span> Wedding
            </div>
            <div class="flex items-center gap-2 text-xs font-bold text-gray-500 uppercase">
                <span class="w-3 h-3 bg-purple-500 rounded-full"></span> Funeral
            </div>
        </div>

        {{-- Calendar Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Weekday Headers --}}
            <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50">
                @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                <div class="py-4 text-center text-xs font-black text-gray-400 uppercase tracking-widest">{{ $day }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            <div class="grid grid-cols-7 auto-rows-[minmax(120px,_auto)]">
                @php
                    $daysInMonth = $startOfMonth->daysInMonth;
                    $firstDayOfWeek = $startOfMonth->dayOfWeek;
                @endphp

                @for($i=0; $i<$firstDayOfWeek; $i++)
                    <div class="border-r border-b border-gray-50 bg-gray-50/50"></div>
                @endfor

                @for($day=1; $day<=$daysInMonth; $day++)
                    @php
                        $dateString = $startOfMonth->copy()->day($day)->format('Y-m-d');
                        $dayReservations = $reservations[$dateString] ?? collect();
                        $isToday = \Carbon\Carbon::today()->format('Y-m-d') === $dateString;
                    @endphp

                    <div class="p-3 border-r border-b border-gray-100 flex flex-col gap-2 transition hover:bg-gray-50 {{ $isToday ? 'bg-blue-50/30' : '' }}">
                        <div class="flex justify-between items-start">
                            <span class="inline-flex items-center justify-center w-7 h-7 text-sm font-bold rounded-full {{ $isToday ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400' }}">
                                {{ $day }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-1 overflow-y-auto max-h-24 custom-scrollbar">
                            @foreach($dayReservations as $res)
                                @php
                                    $type = $res->sacrament->sacrament_type ?? 'Other';
                                    $colorClass = match($type) {
                                        'Baptism' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Wedding' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'Funeral' => 'bg-purple-100 text-purple-700 border-purple-200',
                                        default   => 'bg-gray-100 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <button onclick="openDetailsModal({{ $res->id }})"
                                    class="text-[10px] font-bold py-1 px-2 rounded-lg border {{ $colorClass }} truncate text-left transition transform hover:scale-95 active:scale-90">
                                    {{ $res->reservation_date?->format('H:i') }} | {{ $res->member->user->firstname }}
                                </button>

                                {{-- Details Modal Moved to End of File for better DOM structure --}}
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

{{-- Modals Container --}}
@foreach($reservations->flatten() as $res)
    <div id="details-modal-{{ $res->id }}" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="bg-gray-900 px-8 py-5 flex justify-between items-center text-white">
                <h3 class="font-bold uppercase tracking-widest text-sm text-gray-300">Schedule Details</h3>
                <button onclick="closeDetailsModal({{ $res->id }})" class="hover:text-white">✕</button>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-[10px] font-black text-blue-600 uppercase mb-3">Service Info</h4>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-xl font-black text-gray-900">{{ $res->sacrament->sacrament_type }}</p>
                            <p class="text-sm font-bold text-blue-600 mt-1">{{ $res->reservation_date?->format('l, F d @ h:i A') }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[10px] font-black text-blue-600 uppercase mb-3">Contact Person</h4>
                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-sm font-bold text-gray-900">{{ $res->member->user->firstname }} {{ $res->member->user->lastname }}</p>
                            <p class="text-xs text-gray-500">{{ $res->member->user->phone_number }}</p>
                        </div>
                    </div>
                </div>

                @if($res->remarks)
                <div class="mt-6">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase mb-3">Note for Priest</h4>
                    <p class="text-sm text-gray-600 italic bg-amber-50 p-4 rounded-2xl border border-amber-100">"{{ $res->remarks }}"</p>
                </div>
                @endif
            </div>

            <div class="bg-gray-50 px-8 py-5 flex justify-end">
                <button onclick="closeDetailsModal({{ $res->id }})" class="bg-gray-900 text-white px-8 py-2 rounded-xl text-sm font-bold hover:bg-black transition">Close</button>
            </div>
        </div>
    </div>
@endforeach

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 10px; }
</style>

@endsection
