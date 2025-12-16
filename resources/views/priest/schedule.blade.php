@extends('components.default')

@section('title', 'My Approved Schedule | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24 px-4 lg:px-10">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">YOUR APPROVED SCHEDULE THIS MONTH</h2>

        @if($reservations->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-gray-800">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Member</th>
                        <th class="px-4 py-2">Sacrament</th>
                        <th class="px-4 py-2">Fee</th>
                        <th class="px-4 py-2">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reservations as $reservation)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $reservation->reservation_date->format('M d, Y') }}</td>
                        <td class="px-4 py-2">{{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}</td>
                        <td class="px-4 py-2">{{ $reservation->sacrament->sacrament_type ?? 'N/A' }}</td>
                        <td class="px-4 py-2">₱{{ number_format($reservation->fee, 2) }}</td>
                        <td class="px-4 py-2">{{ $reservation->remarks ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 italic">No approved reservations for this month.</p>
        @endif
    </div>
</section>
@endsection
