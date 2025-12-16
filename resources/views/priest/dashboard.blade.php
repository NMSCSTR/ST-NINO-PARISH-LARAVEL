@extends('components.default')

@section('title', 'Priest Dashboard | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        @include('components.priest.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Reservations Forwarded to You</h2>

                    <div class="overflow-x-auto">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('priest.schedule.calendar') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                📅 View My Approved Schedule
                            </a>
                        </div>

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
                                    <td class="px-4 py-2 font-medium text-gray-900">
                                        {{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}
                                    </td>
                                    <td class="px-4 py-2">{{ $reservation->sacrament->sacrament_type ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">₱{{ number_format($reservation->fee, 2) }}</td>
                                    <td class="px-4 py-2">{{ $reservation->member->user->phone_number }}</td>
                                    <td class="px-4 py-2">
                                        <span class="@if($reservation->status=='approved') text-green-600
                                                    @elseif($reservation->status=='forwarded_to_priest') text-blue-600
                                                    @elseif($reservation->status=='pending') text-yellow-600
                                                    @else text-red-600 @endif font-semibold">
                                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-gray-700">
                                        @if($reservation->forwarded_by)
                                        <div>
                                            <strong>By:</strong> {{ $reservation->forwardedByUser->firstname }} {{ $reservation->forwardedByUser->lastname }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($reservation->forwarded_at)->format('M d, Y g:i A') }}
                                        </div>
                                        @else
                                        <span class="text-gray-400">Not forwarded</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        @if($reservation->status === 'forwarded_to_priest')
                                        <button onclick="openDetailsModal({{ $reservation->id }})"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-blue-300 text-sm font-medium text-blue-700 hover:bg-blue-50 mr-2">
                                            View Details
                                        </button>
                                        <button onclick="openModal({{ $reservation->id }})"
                                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                            Actions
                                        </button>

                                        <!-- Approve/Reject Modal -->
                                        <div id="modal-{{ $reservation->id }}" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">
                                            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative animate-fadeIn">
                                                <div class="flex justify-between items-center border-b border-gray-200 pb-3 mb-4">
                                                    <h3 class="text-lg font-semibold text-gray-800">Approve / Reject Reservation</h3>
                                                    <button type="button" onclick="closeModal({{ $reservation->id }})" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
                                                </div>

                                                <div class="space-y-4">
                                                    <form action="{{ route('priest.reservations.approve', $reservation->id) }}" method="POST">
                                                        @csrf
                                                        <textarea name="remarks" placeholder="Add remarks (optional)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-300" rows="3"></textarea>
                                                        <button type="submit" class="w-full mt-2 bg-green-600 text-white font-medium rounded-lg px-3 py-2 hover:bg-green-700 transition">
                                                            ✅ Approve
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('priest.reservations.reject', $reservation->id) }}" method="POST">
                                                        @csrf
                                                        <textarea name="remarks" placeholder="Add remarks (optional)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-300" rows="3"></textarea>
                                                        <button type="submit" class="w-full mt-2 bg-red-600 text-white font-medium rounded-lg px-3 py-2 hover:bg-red-700 transition">
                                                            ❌ Reject
                                                        </button>
                                                    </form>
                                                </div>

                                                <button type="button" onclick="closeModal({{ $reservation->id }})" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-lg">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Details Modal -->
                                        <div id="details-modal-{{ $reservation->id }}" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">
                                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh] animate-fadeIn">
                                                <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-3">
                                                    <h3 class="text-xl font-semibold text-gray-800 flex items-center gap-2">📋 Reservation Details</h3>
                                                    <button onclick="closeDetailsModal({{ $reservation->id }})" class="text-gray-400 hover:text-gray-600 text-xl font-bold">✕</button>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                                    <div class="bg-gray-50 rounded-xl p-4">
                                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">👤 Member Information</h4>
                                                        <p><strong>Name:</strong> {{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}</p>
                                                        <p><strong>Phone:</strong> {{ $reservation->member->user->phone_number }}</p>
                                                        <p><strong>Email:</strong> {{ $reservation->member->user->email }}</p>
                                                        <p><strong>Address:</strong> {{ $reservation->member->address ?? 'N/A' }}</p>
                                                    </div>

                                                    <div class="bg-gray-50 rounded-xl p-4">
                                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">🗓️ Reservation Info</h4>
                                                        <p><strong>Sacrament:</strong> {{ $reservation->sacrament->sacrament_type ?? 'N/A' }}</p>
                                                        <p><strong>Date:</strong> {{ $reservation->reservation_date?->format('M d, Y') }}</p>
                                                        <p><strong>Fee:</strong> ₱{{ number_format($reservation->fee, 2) }}</p>
                                                        <p><strong>Status:</strong>
                                                            <span class="font-semibold @if($reservation->status=='approved') text-green-600 @elseif($reservation->status=='forwarded_to_priest') text-blue-600 @else text-yellow-600 @endif">
                                                                {{ ucfirst(str_replace('_',' ',$reservation->status)) }}
                                                            </span>
                                                        </p>
                                                    </div>

                                                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">🕊️ Sacrament Details</h4>
                                                        @if($reservation->sacrament->sacrament_type === 'Baptism')
                                                            <p><strong>Child Name:</strong> {{ $reservation->member->user->firstname }}</p>
                                                            <p><strong>Date of Birth:</strong> {{ $reservation->member->birth_date }}</p>
                                                        @elseif($reservation->sacrament->sacrament_type === 'Wedding')
                                                            <p><strong>Groom:</strong> {{ $reservation->member->user->firstname }}</p>
                                                            <p><strong>Bride:</strong> (Bride details here)</p>
                                                        @else
                                                            <p class="text-gray-500 italic">No additional sacrament data available.</p>
                                                        @endif
                                                    </div>

                                                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">📄 Uploaded Documents</h4>
                                                        @if($reservation->documents->count())
                                                            <ul class="space-y-2">
                                                                @foreach($reservation->documents as $doc)
                                                                    <li class="flex items-center justify-between bg-white border rounded-lg px-3 py-2">
                                                                        <span>📎 {{ $doc->document_type ?? 'Document' }}</span>
                                                                        <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm">View</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p class="text-gray-500 italic">No documents uploaded.</p>
                                                        @endif
                                                    </div>

                                                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                                        <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">🧾 Payment History</h4>
                                                        @if($reservation->payments->count())
                                                            <table class="w-full text-xs">
                                                                <thead class="text-gray-500 border-b">
                                                                    <tr>
                                                                        <th class="py-2 text-left">Date</th>
                                                                        <th class="py-2 text-left">Amount</th>
                                                                        <th class="py-2 text-left">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($reservation->payments as $payment)
                                                                    <tr class="border-b">
                                                                        <td class="py-2">{{ $payment->created_at->format('M d, Y') }}</td>
                                                                        <td class="py-2">₱{{ number_format($payment->amount,2) }}</td>
                                                                        <td class="py-2 text-green-600 font-medium">{{ ucfirst($payment->status) }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <p class="text-gray-500 italic">No payments recorded.</p>
                                                        @endif
                                                    </div>

                                                    @if($reservation->remarks)
                                                    <div class="bg-gray-50 rounded-xl p-4 md:col-span-2">
                                                        <h4 class="font-semibold text-gray-700 mb-2 flex items-center gap-2">📝 Remarks</h4>
                                                        <p class="text-gray-600">{{ $reservation->remarks }}</p>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="mt-6 flex justify-end gap-3">
                                                    <button onclick="closeDetailsModal({{ $reservation->id }})" class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">Close</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Scripts -->
                                        <script>
                                            function openModal(id) {
                                                const modal = document.getElementById(`modal-${id}`);
                                                modal.classList.remove('hidden');
                                                modal.classList.add('flex');
                                            }
                                            function closeModal(id) {
                                                const modal = document.getElementById(`modal-${id}`);
                                                modal.classList.remove('flex');
                                                modal.classList.add('hidden');
                                            }
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
