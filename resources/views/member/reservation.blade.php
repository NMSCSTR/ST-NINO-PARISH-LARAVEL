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
                                        <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Member
                                    </a>
                                </li>

                                <li class="text-gray-400">/</li>

                                <li>
                                    <a href="#"
                                        class="text-sm font-medium text-gray-700 hover:text-blue-600">
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
                            <a href="{{ route('member.reservations.history') }}"
                                class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white
                                       hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition">
                                My Reservation History
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="px-6 py-8 border-t">
                        <form method="POST" action="{{ route('member.makeReservation') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="grid gap-6 sm:grid-cols-2">

                                {{-- Sacrament --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Select Sacrament Type
                                    </label>
                                    <select id="sacrament_id" name="sacrament_id" required
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                                               focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition">
                                        <option value="">-- Choose sacrament type --</option>
                                        @foreach ($sacraments as $sacrament)
                                            <option value="{{ $sacrament->id }}">
                                                {{ ucfirst($sacrament->sacrament_type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Fee --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Fee
                                    </label>
                                    <input type="text" id="fee" readonly
                                        class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-2.5 text-sm"
                                        placeholder="Select a sacrament first">
                                </div>

                                {{-- Date --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Reservation Date
                                    </label>
                                    <input type="date" name="reservation_date"
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                                               focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition">
                                </div>

                                {{-- Remarks --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Remarks
                                    </label>
                                    <textarea name="remarks" rows="5"
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                                               focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition"
                                        placeholder="Optional notes or instructions"></textarea>
                                </div>

                                {{-- Payment Option --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Payment Option
                                    </label>
                                    <select id="payment_option" name="payment_option" required
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm">
                                        <option value="">-- Choose Payment Option --</option>
                                        <option value="pay_now">Pay Now</option>
                                        <option value="pay_later">Pay Later</option>
                                    </select>
                                </div>

                                {{-- Receipt --}}
                                <div class="sm:col-span-2 hidden" id="receipt_upload_div">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Upload Payment Receipt
                                    </label>
                                    <input type="file" name="receipt"
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm">
                                </div>

                                {{-- Submission --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Requirement Submission Method
                                    </label>
                                    <select id="submission_method" name="submission_method" required
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm">
                                        <option value="">-- Choose Method --</option>
                                        <option value="online">Submit Online</option>
                                        <option value="walkin">Walk-in</option>
                                    </select>
                                </div>

                                {{-- Documents --}}
                                <div class="sm:col-span-2 hidden" id="document_upload_div">
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Upload Required Documents
                                    </label>
                                    <input type="file" name="documents[]" multiple
                                        class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm">
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="mt-8 flex justify-end border-t pt-6">
                                <button type="submit"
                                    class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white
                                           hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition">
                                    Submit Reservation
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

    document.getElementById('sacrament_id').addEventListener('change', function () {
        const found = sacraments.find(item => item.id == this.value);
        document.getElementById('fee').value = found ? `₱ ${parseFloat(found.fee).toFixed(2)}` : '';
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
