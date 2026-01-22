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
                    <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">My Payments</h2>
                            <p class="text-sm text-gray-500 mt-1">Manage and settle your fees for approved reservations.</p>
                        </div>
                        <div class="hidden md:block">
                            <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">Financial Records</span>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($payments->isEmpty())
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                                <p class="mt-1 text-sm text-gray-500">Payments will appear here once your reservation is approved by the Priest.</p>
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
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach ($payments as $payment)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="font-semibold text-gray-900">{{ $payment->reservation->sacrament->sacrament_type ?? 'N/A' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    ₱{{ number_format($payment->reservation->fee, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->status === 'paid')
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                                                            Paid
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                                            <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-amber-500"></span>
                                                            Awaiting Payment
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->receipt_path)
                                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                            View
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400 text-sm">No receipt</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    @if($payment->status === 'pending')
                                                        <button onclick="openUploadModal({{ $payment->id }})"
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-md shadow-blue-200">
                                                            Settle Now
                                                        </button>
                                                    @else
                                                        <span class="text-green-500">
                                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 uppercase">
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
        <div class="bg-blue-600 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Upload Payment Receipt</h3>
            <button onclick="closeUploadModal()" class="text-blue-100 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="uploadForm" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Requirement: Transaction Screenshot</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-blue-400 transition">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        <div class="flex text-sm text-gray-600">
                            <label class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Choose file</span>
                                <input id="receipt" name="receipt" type="file" class="sr-only" accept="image/*" required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                    </div>
                </div>
                <p id="file-name" class="mt-2 text-sm text-blue-600 font-medium"></p>
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
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('uploadModal');
    const form = document.getElementById('uploadForm');
    const fileInput = document.getElementById('receipt');
    const fileNameDisplay = document.getElementById('file-name');

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
    }
</script>
@endpush
