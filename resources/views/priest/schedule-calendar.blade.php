@extends('components.default')

@section('title', 'My Approved Schedule | Calendar View')

@section('content')
<section>
    @include('components.admin.bg')
    @include('components.priest.topnav')
    <div class="min-h-screen pt-24 px-4 lg:px-10">

        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('priest.schedule') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                ← Back to Schedule
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
                        @endforeach
                    @else
                        <div class="text-gray-400 italic mt-1">No events</div>
                    @endif
                </div>
            @endfor
        </div>
    </div>
</section>

{{-- Details Modal Script --}}
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
