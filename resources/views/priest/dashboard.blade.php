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
                                    <th class="px-4 py-2">Phone Number</th>
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

                                    {{-- Phone Number --}}
                                    <td class="px-4 py-2">{{ $reservation->member->user->phone_number }}</td>

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
                                        <button
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            onclick="openModal({{ $reservation->id }})">
                                            Actions
                                            <svg class="h-5 w-5 -mr-1 ml-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <button
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-blue-300 text-sm font-medium text-blue-700 hover:bg-blue-50 mr-2"
                                            onclick="openDetailsModal({{ $reservation->id }})">
                                            View Details
                                        </button>


                                        {{-- Modal --}}
                                        <div id="modal-{{ $reservation->id }}"
                                            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                                            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 relative">
                                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Approve / Reject
                                                    Reservation</h3>

                                                {{-- Remarks Form --}}
                                                <form
                                                    action="{{ route('priest.reservations.approve', $reservation->id) }}"
                                                    method="POST" class="mb-3">
                                                    @csrf
                                                    <textarea name="remarks" placeholder="Add remarks (optional)"
                                                        class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 mb-2"
                                                        rows="3"></textarea>
                                                    <button type="submit"
                                                        class="w-full flex items-center justify-center gap-2 text-green-600 font-medium hover:bg-green-50 rounded px-3 py-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Approve
                                                    </button>
                                                </form>

                                                <form
                                                    action="{{ route('priest.reservations.reject', $reservation->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <textarea name="remarks" placeholder="Add remarks (optional)"
                                                        class="w-full border px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 mb-2"
                                                        rows="3"></textarea>
                                                    <button type="submit"
                                                        class="w-full flex items-center justify-center gap-2 text-red-600 font-medium hover:bg-red-50 rounded px-3 py-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        Reject
                                                    </button>
                                                </form>

                                                {{-- Close Button --}}
                                                <button type="button" onclick="closeModal({{ $reservation->id }})"
                                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Modal Script --}}
                                        <script>
                                            function openModal(id) {
                                                document.getElementById(`modal-${id}`).classList.remove('hidden');
                                                document.getElementById(`modal-${id}`).classList.add('flex');
                                            }

                                            function closeModal(id) {
                                                document.getElementById(`modal-${id}`).classList.remove('flex');
                                                document.getElementById(`modal-${id}`).classList.add('hidden');
                                            }

                                            // Close modal when clicking outside
                                            document.addEventListener('click', function (event) {
                                                const modal = document.getElementById(`modal-{{ $reservation->id }}`);
                                                if (modal && !modal.firstElementChild.contains(event.target) && !event.target.closest('button')) {
                                                    closeModal({{ $reservation->id }});
                                                }
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

    <div id="details-modal-{{ $reservation->id }}"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">

        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            Reservation Details
        </h3>

        <div class="space-y-3 text-sm text-gray-700">
            <div>
                <strong>Member Name:</strong>
                {{ $reservation->member->user->firstname }}
                {{ $reservation->member->user->lastname }}
            </div>

            <div>
                <strong>Phone Number:</strong>
                {{ $reservation->member->user->phone_number }}
            </div>

            <div>
                <strong>Email:</strong>
                {{ $reservation->member->user->email }}
            </div>

            <div>
                <strong>Sacrament:</strong>
                {{ $reservation->sacrament->sacrament_type ?? 'N/A' }}
            </div>

            <div>
                <strong>Reservation Date:</strong>
                {{ $reservation->reservation_date?->format('M d, Y') ?? 'N/A' }}
            </div>

            <div>
                <strong>Fee:</strong>
                ₱{{ number_format($reservation->fee, 2) }}
            </div>

            <div>
                <strong>Status:</strong>
                {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
            </div>

            @if($reservation->remarks)
            <div>
                <strong>Remarks:</strong>
                <p class="text-gray-600">{{ $reservation->remarks }}</p>
            </div>
            @endif

            @if($reservation->forwarded_by)
            <div>
                <strong>Forwarded By:</strong>
                {{ $reservation->forwardedByUser->firstname }}
                {{ $reservation->forwardedByUser->lastname }}
                <div class="text-xs text-gray-500">
                    {{ $reservation->forwarded_at->format('M d, Y g:i A') }}
                </div>
            </div>
            @endif
        </div>

        {{-- Close Button --}}
        <button type="button"
            onclick="closeDetailsModal({{ $reservation->id }})"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            ✕
        </button>
    </div>
</div>

</section>

@endsection

@push('scripts')
@include('components.alerts')
<script>
    function openDetailsModal(id) {
        const modal = document.getElementById(`details-modal-${id}`);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDetailsModal(id) {
        const modal = document.getElementById(`details-modal-${id}`);
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>


@endpush
