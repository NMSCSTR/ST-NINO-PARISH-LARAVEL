@extends('components.default')

@section('title', 'My Approved Schedule | Calendar View')

@section('content')
<section>
    @include('components.priest.topnav')
    <div class="min-h-screen pt-24 px-4 lg:px-10">

        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('priest.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                ← Back to Dashboard
            </a>
        </div>

        <h2 class="text-2xl font-semibold text-gray-800 mb-2">YOUR APPROVED SCHEDULE THIS MONTH</h2>

        {{-- Instruction --}}
        <p class="mb-4 text-sm text-gray-500">💡 Click on any green button to view full reservation details.</p>

        @php
        $daysInMonth = $startOfMonth->daysInMonth;
        $firstDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday
        @endphp

        {{-- Weekday Headers --}}
        <div class="grid grid-cols-7 gap-2 text-center mb-2">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
            <div class="font-semibold text-gray-700">{{ $day }}</div>
            @endforeach
        </div>

        {{-- Calendar Grid --}}
        <div class="grid grid-cols-7 gap-2">
            {{-- Empty cells for first day offset --}}
            @for($i=0; $i<$firstDayOfWeek; $i++)
            <div class="p-4 border h-32 bg-gray-50"></div>
            @endfor

            {{-- Days of the month --}}
            @for($day=1; $day<=$daysInMonth; $day++)
                @php
                    $date = $startOfMonth->copy()->day($day)->format('Y-m-d');
                    $dayReservations = $reservations[$date] ?? collect();
                    $isToday = \Carbon\Carbon::today()->format('Y-m-d') === $date;
                @endphp
                <div class="p-2 border h-32 flex flex-col gap-1 text-xs rounded-lg
                    @if($isToday) border-blue-500 bg-blue-50 @endif">

                    {{-- Day Number --}}
                    <div class="font-semibold text-gray-700">{{ $day }}</div>

                    {{-- Reservations --}}
                    @if($dayReservations->count())
                        @foreach($dayReservations as $res)
                        <button onclick="openDetailsModal({{ $res->id }})"
                            class="bg-green-100 text-green-800 rounded px-1 py-0.5 truncate text-left text-xs hover:bg-green-200 cursor-pointer">
                            {{ $res->member->user->firstname }}
                            ({{ $res->sacrament->sacrament_type ?? 'N/A' }})
                        </button>

                        {{-- Details Modal --}}
                        <div id="details-modal-{{ $res->id }}" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">📋 Reservation Details</h3>
                                    <button onclick="closeDetailsModal({{ $res->id }})" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">👤 Member Information</h4>
                                        <p><strong>Name:</strong> {{ $res->member->user->firstname }} {{ $res->member->user->lastname }}</p>
                                        <p><strong>Phone:</strong> {{ $res->member->user->phone_number }}</p>
                                        <p><strong>Email:</strong> {{ $res->member->user->email }}</p>
                                        <p><strong>Address:</strong> {{ $res->member->address ?? 'N/A' }}</p>
                                    </div>

                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">🗓️ Reservation Info</h4>
                                        <p><strong>Sacrament:</strong> {{ $res->sacrament->sacrament_type ?? 'N/A' }}</p>
                                        <p><strong>Date:</strong> {{ $res->reservation_date?->format('M d, Y') }}</p>
                                        <p><strong>Fee:</strong> ₱{{ number_format($res->fee, 2) }}</p>
                                        <p><strong>Status:</strong>
                                            <span class="font-semibold text-green-600">
                                                {{ ucfirst(str_replace('_',' ',$res->status)) }}
                                            </span>
                                        </p>
                                    </div>

                                    {{-- Sacrament-specific details --}}
                                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">🕊️ Sacrament Details</h4>
                                        @if($res->sacrament->sacrament_type === 'Baptism')
                                            <p><strong>Child Name:</strong> {{ $res->member->user->firstname }}</p>
                                            <p><strong>Date of Birth:</strong> {{ $res->member->birth_date }}</p>
                                        @elseif($res->sacrament->sacrament_type === 'Wedding')
                                            <p><strong>Groom:</strong> {{ $res->member->user->firstname }}</p>
                                            <p><strong>Bride:</strong> (Bride details here)</p>
                                        @else
                                            <p class="text-gray-500 italic">No additional sacrament data available.</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button onclick="closeDetailsModal({{ $res->id }})" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">Close</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-gray-400 italic mt-1">No events</div>
                    @endif
                </div>
            @endfor
        </div>
    </div>
</section>

<script>
    function openDetailsModal(id) {
        document.getElementById(`details-modal-${id}`).classList.remove('hidden');
        document.getElementById(`details-modal-${id}`).classList.add('flex');
    }
    function closeDetailsModal(id) {
        document.getElementById(`details-modal-${id}`).classList.remove('flex');
        document.getElementById(`details-modal-${id}`).classList.add('hidden');
    }
</script>
@endsection
