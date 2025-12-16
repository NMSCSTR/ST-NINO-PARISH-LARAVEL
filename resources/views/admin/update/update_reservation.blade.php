@extends('components.default')

@section('title', 'Edit Reservation | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        {{-- Top Navigation --}}
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Reservation</h2>

                    <form action="{{ route('admin.reservations.update', ['id' => $reservations->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 mb-6">

                            <div class="sm:col-span-2">
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-700">
                                    Status
                                </label>
                                <select name="status" id="status" required
                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                                    <option value="pending" {{ old('status', $reservations->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $reservations->status) === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="cancel" {{ old('status', $reservations->status) === 'cancel' ? 'selected' : '' }}>Cancel</option>
                                    <option value="forwarded_to_priest" {{ old('status', $reservations->status) === 'forwarded_to_priest' ? 'selected' : '' }}>Forward to Priest</option>
                                </select>
                            </div>

                            <div>
                                <label for="reservation_date" class="block mb-2 text-sm font-medium text-gray-700">
                                    Reservation Date
                                </label>
                                <input type="date" name="reservation_date" id="reservation_date"
                                       value="{{ old('reservation_date', \Carbon\Carbon::parse($reservations->reservation_date)->format('Y-m-d')) }}"
                                       class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="remarks" class="block mb-2 text-sm font-medium text-gray-700">
                                    Remarks
                                </label>
                                <input type="text" name="remarks" id="remarks"
                                       value="{{ old('remarks', $reservations->remarks) }}"
                                       placeholder="Remarks..."
                                       class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-500">
                            </div>

                        </div>

                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.reservations') }}"
                               class="flex items-center text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                Back
                            </a>

                            <button type="submit"
                                    class="flex items-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 17h2M12 12v5m9-9l-4-4a2.828 2.828 0 00-4 0L4 14v4h4l7-7z" />
                                </svg>
                                Update Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection
