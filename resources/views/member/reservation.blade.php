@extends('components.default')

@section('title', 'Reservations | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24 bg-gray-100">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-6 gap-6">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
                    <div class="px-6 py-6">

                        {{-- Breadcrumb --}}
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-xl bg-gray-50"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Member
                                    </a>
                                </li>

                                <li class="text-gray-400">/</li>

                                <li>
                                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                                        Dashboard
                                    </a>
                                </li>

                                <li class="text-gray-400">/</li>

                                <li>
                                    <span class="text-sm font-medium text-gray-500">
                                        Make Reservation
                                    </span>
                                </li>
                            </ol>
                        </nav>

                        {{-- Action Button --}}
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('member.reservations.history') }}" class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white
                                       hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition">
                                My Reservation History
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    {{-- Modernized Form Card --}}
                    <div
                        class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-blue-600 px-8 py-4 text-white">
                            <h3 class="text-lg font-semibold">New Reservation Request</h3>
                            <p class="text-blue-100 text-xs">Fill out the details below. Payment is required only after
                                approval.</p>
                        </div>

                        <form method="POST" action="{{ route('member.makeReservation') }}" class="p-8 space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Sacrament Selection --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sacrament Type</label>
                                    <div class="relative">
                                        <select id="sacrament_id" name="sacrament_id" required
                                            class="appearance-none w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                                            <option value="">Select a service...</option>
                                            @foreach ($sacraments as $sacrament)
                                            <option value="{{ $sacrament->id }}">{{ ucfirst($sacrament->sacrament_type)
                                                }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Fee Info Box (Auto-updated) --}}
                                <div
                                    class="md:col-span-2 bg-blue-50 rounded-xl p-4 flex items-center justify-between border border-blue-100">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-500 rounded-lg text-white">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-600 font-medium uppercase tracking-wider">
                                                Estimated Fee</p>
                                            <input type="text" id="fee_display" readonly
                                                class="bg-transparent font-bold text-blue-900 outline-none text-xl"
                                                value="₱ 0.00">
                                            <input type="hidden" name="fee" id="fee_input">
                                        </div>
                                    </div>
                                </div>

                                {{-- Date & Submission Method --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Preferred Date</label>
                                    <input type="date" name="reservation_date"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Submission
                                        Method</label>
                                    <select name="submission_method"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition">
                                        <option value="walkin">Walk-in</option>
                                        <option value="online">Online Upload</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                                    <textarea name="remarks" rows="3"
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition"
                                        placeholder="Any special requests?"></textarea>
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-200 transition-all transform hover:-translate-y-1">
                                    Submit for Approval
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@include('components.alerts')

<script>
    const sacraments = @json($sacraments);

    const feeDisplay = document.getElementById('fee_display');
    const feeInput = document.getElementById('fee_input');

    document.getElementById('sacrament_id').addEventListener('change', function () {
        const found = sacraments.find(item => item.id == this.value);
        if (found) {
            feeDisplay.value = `₱ ${parseFloat(found.fee).toFixed(2)}`;
            feeInput.value = parseFloat(found.fee).toFixed(2);
        } else {
            feeDisplay.value = '';
            feeInput.value = '';
        }
    });

    const paymentSelect = document.getElementById('payment_option');
    const receiptDiv = document.getElementById('receipt_upload_div');
    paymentSelect.addEventListener('change', () => {
        receiptDiv.classList.toggle('hidden', paymentSelect.value !== 'pay_now');
    });

    const submissionSelect = document.getElementById('submission_method');
    const documentDiv = document.getElementById('document_upload_div');
    submissionSelect.addEventListener('change', () => {
        documentDiv.classList.toggle('hidden', submissionSelect.value !== 'online');
    });
</script>
@endpush
