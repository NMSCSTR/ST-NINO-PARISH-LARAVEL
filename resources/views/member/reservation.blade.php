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
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

                    {{-- Header Section --}}
                    <div class="px-6 py-6 bg-white border-b border-gray-100">
                        {{-- Breadcrumb --}}
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-xl bg-gray-50 mb-6" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-2">
                                <li class="inline-flex items-center">
                                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition">
                                        <svg class="w-3 h-3 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Member
                                    </a>
                                </li>
                                <li class="text-gray-400">/</li>
                                <li>
                                    <a href="#" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition">Dashboard</a>
                                </li>
                                <li class="text-gray-400">/</li>
                                <li>
                                    <span class="text-sm font-medium text-gray-500">Make Reservation</span>
                                </li>
                            </ol>
                        </nav>

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">New Reservation Request</h1>
                                <p class="text-sm text-gray-500 mt-1">Submit your requirements for review. Payment is settled after approval.</p>
                            </div>
                            <a href="{{ route('member.reservations.history') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition shadow-sm">
                                My Reservation History
                            </a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="px-6 py-8">
                        <form method="POST" action="{{ route('member.makeReservation') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="grid gap-8 sm:grid-cols-2">

                                {{-- Sacrament Details Card --}}
                                <div class="sm:col-span-2 space-y-6">
                                    <div class="grid gap-6 sm:grid-cols-2 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                        <div class="sm:col-span-2">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Select Sacrament Type</label>
                                            <select id="sacrament_id" name="sacrament_id" required
                                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition shadow-sm">
                                                <option value="">-- Choose sacrament type --</option>
                                                @foreach ($sacraments as $sacrament)
                                                <option value="{{ $sacrament->id }}">
                                                    {{ ucfirst($sacrament->sacrament_type) }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Estimated Fee</label>
                                            <div class="relative">
                                                <input type="text" id="fee_display" readonly
                                                    class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-lg font-bold text-blue-700"
                                                    placeholder="₱ 0.00">
                                                <input type="hidden" name="fee" id="fee_input">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 italic">* Note: Fees are settled upon priest approval.</p>
                                        </div>

                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Reservation Date</label>
                                            <input type="date" name="reservation_date" required
                                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition shadow-sm">
                                        </div>
                                    </div>
                                </div>

                                {{-- Remarks --}}
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Remarks / Special Instructions</label>
                                    <textarea name="remarks" rows="3" class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition shadow-sm"
                                        placeholder="Optional: e.g. Special requests for the ceremony..."></textarea>
                                </div>

                                {{-- Submission Method Section --}}
                                <div class="sm:col-span-2 border-t pt-6">
                                    <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Requirements Submission</h3>

                                    <div class="grid gap-6 sm:grid-cols-2">
                                        <div>
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Submission Method</label>
                                            <select id="submission_method" name="submission_method" required
                                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition shadow-sm">
                                                <option value="">-- Choose Method --</option>
                                                <option value="online">Submit Online (Upload Images)</option>
                                                <option value="walkin">Walk-in (Submit to Office)</option>
                                            </select>
                                        </div>

                                        {{-- Documents Upload (Hidden by Default) --}}
                                        <div class="hidden animate-fade-in" id="document_upload_div">
                                            <label class="block mb-2 text-sm font-semibold text-gray-700">Upload Required Documents</label>
                                            <input type="file" name="documents[]" multiple
                                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition cursor-pointer border border-gray-300 rounded-xl bg-white p-1">
                                            <p class="text-xs text-gray-500 mt-2">You can select multiple images (Birth Cert, etc.)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="mt-10 flex flex-col sm:flex-row items-center justify-between gap-4 border-t pt-8">
                                <p class="text-sm text-gray-500 max-w-sm">By submitting, you agree that your request is subject to the priest's availability and review.</p>
                                <button type="submit" class="w-full sm:w-auto rounded-xl bg-blue-600 px-10 py-4 text-base font-bold text-white hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/30 transition transform active:scale-95 shadow-lg">
                                    Submit Reservation Request
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

    // Update Fee Display based on Selection
    document.getElementById('sacrament_id').addEventListener('change', function () {
        const found = sacraments.find(item => item.id == this.value);
        if (found) {
            feeDisplay.value = `₱ ${parseFloat(found.fee).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            feeInput.value = parseFloat(found.fee).toFixed(2);
        } else {
            feeDisplay.value = '';
            feeInput.value = '';
        }
    });

    // Toggle Document Upload Div
    const submissionSelect = document.getElementById('submission_method');
    const documentDiv = document.getElementById('document_upload_div');

    submissionSelect.addEventListener('change', () => {
        if (submissionSelect.value === 'online') {
            documentDiv.classList.remove('hidden');
        } else {
            documentDiv.classList.add('hidden');
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
</style>
@endpush
