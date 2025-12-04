@extends('components.default')

@section('title', 'Priest Dashboard | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        {{-- Include Top Navigation --}}
        @include('components.priest.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            {{-- Main Content --}}
            <div class="w-full">

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Reservations Forwarded to You</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-gray-800">
                            <thead class="bg-gray-50 border-b border-gray-200 text-gray-700 text-xs uppercase">
                                <tr>
                                    <th class="px-4 py-2">Member</th>
                                    <th class="px-4 py-2">Sacrament</th>
                                    <th class="px-4 py-2">Fee</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Forwarded Info</th>
                                    <th class="px-4 py-2 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($reservations as $reservation)
                                <tr class="hover:bg-gray-50 transition">
                                    {{-- Member --}}
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        {{ $reservation->member->user->firstname }}
                                        {{ $reservation->member->user->lastname }}
                                    </td>

                                    {{-- Sacrament --}}
                                    <td class="px-4 py-2">{{ $reservation->sacrament->sacrament_type ?? 'N/A' }}</td>

                                    {{-- Fee --}}
                                    <td class="px-4 py-2">₱{{ number_format($reservation->fee, 2) }}</td>

                                    {{-- Status --}}
                                    <td class="px-4 py-2">
                                        <span class="
                                                @if($reservation->status=='approved') text-green-600
                                                @elseif($reservation->status=='forwarded_to_priest') text-blue-600
                                                @elseif($reservation->status=='pending') text-yellow-600
                                                @else text-red-600 @endif font-semibold">
                                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                        </span>
                                    </td>

                                    {{-- Forwarded Info --}}
                                    <td class="px-4 py-2 text-gray-700">
                                        @if($reservation->forwarded_by)
                                        <div>
                                            <strong>By:</strong> {{ $reservation->forwardedByUser->firstname }}
                                            {{ $reservation->forwardedByUser->lastname }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($reservation->forwarded_at)->format('M d, Y g:i A')
                                            }}
                                        </div>
                                        @else
                                        <span class="text-gray-400">Not forwarded</span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-4 py-2 text-right">
                                        @if($reservation->status === 'forwarded_to_priest')
                                        <div class="relative inline-block text-left">
                                            <button type="button"
                                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1.5 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                                id="priest-menu-button-{{ $reservation->id }}">
                                                Actions
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            <div class="origin-top-right absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-50"
                                                id="priest-dropdown-{{ $reservation->id }}">
                                                <div class="py-2 px-3">

                                                    {{-- Approve with remarks --}}
                                                    <form
                                                        action="{{ route('priest.reservations.approve', $reservation->id) }}"
                                                        method="POST" class="mb-2">
                                                        @csrf
                                                        <textarea name="remarks" placeholder="Add remarks (optional)"
                                                            rows="2"
                                                            class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 text-sm mb-2"></textarea>
                                                        <button type="submit"
                                                            class="w-full flex items-center justify-center gap-2 text-green-600 font-medium hover:bg-green-50 rounded px-2 py-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Approve
                                                        </button>
                                                    </form>

                                                    {{-- Reject with remarks --}}
                                                    <form
                                                        action="{{ route('priest.reservations.reject', $reservation->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <textarea name="remarks" placeholder="Add remarks (optional)"
                                                            rows="2"
                                                            class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 text-sm mb-2"></textarea>
                                                        <button type="submit"
                                                            class="w-full flex items-center justify-center gap-2 text-red-600 font-medium hover:bg-red-50 rounded px-2 py-1">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            const priestBtn{{ $reservation->id }} = document.getElementById('priest-menu-button-{{ $reservation->id }}');
        const priestDropdown{{ $reservation->id }} = document.getElementById('priest-dropdown-{{ $reservation->id }}');

        priestBtn{{ $reservation->id }}.addEventListener('click', (e) => {
            e.stopPropagation();
            priestDropdown{{ $reservation->id }}.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            priestDropdown{{ $reservation->id }}.classList.add('hidden');
        });
                                        </script>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@include('components.alerts')
@endpush
