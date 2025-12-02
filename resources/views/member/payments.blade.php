@extends('components.default')

@section('title', 'Payments | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-xl shadow-2xl">
                    <div class="px-6 py-6">
                        <h2 class="text-xl font-semibold mb-4">My Payments</h2>

                        @if($payments->isEmpty())
                            <p>No payments found.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-700">
                                    <thead class="bg-gray-200">
                                        <tr>
                                            <th class="px-4 py-2">Sacrament</th>
                                            <th class="px-4 py-2">Fee</th>
                                            <th class="px-4 py-2">Amount Paid</th>
                                            <th class="px-4 py-2">Payment Method</th>
                                            <th class="px-4 py-2">Status</th>
                                            <th class="px-4 py-2">Receipt</th>
                                            <th class="px-4 py-2">Action</th>
                                            <th class="px-4 py-2">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr class="border-b">
                                                <td class="px-4 py-2">
                                                    {{ $payment->reservation->sacrament->sacrament_type ?? 'N/A' }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    ₱{{ number_format($payment->reservation->fee, 2) }}
                                                </td>
                                                <td class="px-4 py-2">
                                                    ₱{{ number_format($payment->amount, 2) }}
                                                </td>
                                                <td class="px-4 py-2">{{ $payment->method ?? '-' }}</td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $payment->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                                        {{ ucfirst($payment->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if($payment->receipt_path)
                                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="text-blue-600 underline">View</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">
                                                    @if($payment->status === 'pending')
                                                        <!-- Button to trigger modal -->
                                                        <button onclick="openUploadModal({{ $payment->id }})"
                                                            class="px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                                                            Pay Now
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2">{{ $payment->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div id="uploadModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
        <h3 class="text-lg font-semibold mb-4">Upload Payment Receipt</h3>
        <form id="uploadForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="receipt" accept="image/*" required class="mb-4 w-full">
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeUploadModal()" class="px-4 py-2 text-sm text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">Upload</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openUploadModal(paymentId) {
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    form.action = `/payments/${paymentId}/pay-now`; // Set the form action dynamically
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeUploadModal() {
    const modal = document.getElementById('uploadModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush
