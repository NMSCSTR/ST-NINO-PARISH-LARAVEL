@extends('components.default')

@section('title', 'Payments | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24 bg-gray-50">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-8 gap-6">
            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    {{-- Page Header --}}
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">My Payments</h2>
                            <p class="text-sm text-gray-500 mt-1">Settle your fees for approved church reservations.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($payments->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                                <p class="mt-1 text-sm text-gray-500">Payments appear here once the Priest approves your reservation.</p>
                            </div>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-100">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sacrament</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fee</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Receipt</th>
                                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100 text-sm">
                                        @foreach ($payments as $payment)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                                    {{ $payment->reservation->sacrament->sacrament_type ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                    ₱{{ number_format($payment->reservation->fee, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->status === 'paid')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                            Paid
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->receipt_path)
                                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="text-blue-600 hover:underline font-medium flex items-center gap-1">
                                                            View
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400 italic">No receipt</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    @if($payment->status === 'pending')
                                                        <button onclick="openUploadModal({{ $payment->id }})"
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 rounded-lg text-xs font-bold text-white uppercase hover:bg-blue-700 transition shadow-md">
                                                            Pay Now
                                                        </button>
                                                    @else
                                                        <span class="text-green-500 font-bold flex items-center justify-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                            Completed
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                                    {{ $payment->created_at->format('M d, Y') }}
                                                </td>
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

<div id="uploadModal" class="fixed inset-0 hidden items-center justify-center bg-gray-900 bg-opacity-75 z-50 p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center text-white">
            <h3 class="text-lg font-bold">Upload Payment Receipt</h3>
            <button onclick="closeUploadModal()" class="text-blue-100 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6">
            {{-- GCash Payment Details Section --}}
            <div class="mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100 text-center">
                <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Scan to Pay via GCash</p>

                {{-- QR Code Image --}}
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/parishpayqr.jpg') }}" alt="GCash QR Code" class="w-40 h-40 object-contain rounded-lg border-2 border-white shadow-sm bg-white">
                </div>

                {{-- Account Info --}}
                <div class="space-y-1">
                    <p class="text-sm font-bold text-gray-900">Account Name: <span class="text-blue-700">SANTO NIÑO PARISH</span></p>
                    <p class="text-sm font-bold text-gray-900">Account Number: <span class="text-blue-700">09754812059</span></p>
                </div>
            </div>

            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Requirement: Transaction Screenshot</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition cursor-pointer">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none transition">
                                    <span>Choose file</span>
                                    <input id="receipt" name="receipt" type="file" class="sr-only" accept="image/*" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    <p id="file-name-display" class="mt-2 text-sm text-blue-600 font-medium text-center"></p>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                        Submit Receipt
                    </button>
                    <button type="button" onclick="closeUploadModal()" class="w-full inline-flex justify-center rounded-xl bg-gray-100 px-4 py-3 text-sm font-bold text-gray-700 hover:bg-gray-200 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const modal = document.getElementById('uploadModal');
const form = document.getElementById('uploadForm');
const fileInput = document.getElementById('receipt');
const fileNameDisplay = document.getElementById('file-name-display');

fileInput.onchange = () => {
    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = `Selected: ${fileInput.files[0].name}`;
    }
}

function openUploadModal(paymentId) {
    form.action = `/member/payments/${paymentId}/pay-now`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeUploadModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    fileNameDisplay.textContent = ''; // Reset file name on close
}
</script>
@endpush
