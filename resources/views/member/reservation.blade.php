@extends('components.default')

@section('title', 'Reservations | Santo Niño Parish Church')

@section('content')

<section>
    <div class="min-h-screen pt-24">
        {{-- @include('components.admin.bg') --}}
        {{-- Include Top Navigation --}}
        @include('components.member.topnav')
        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Include Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">

                <div class="bg-white rounded-xl shadow-2xl">
                    <div class="px-6 py-6">


                        <!-- Breadcrumb -->
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                                        <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Member
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#"
                                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Dashboard</a>
                                    </div>
                                </li>
                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span
                                            class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Make
                                            Reservations</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>

                    </div>

                    <div class="relative overflow-x-auto sm:rounded-lg  px-6 py-6">
                        <section class="bg-white dark:bg-gray-900">
                            <div class=" mx-auto max-w-2xl lg:py-16">
                                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Reserve an Event</h2>

                                <form method="POST" action="{{ route('member.makeReservation') }}">
                                    @csrf

                                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">

                                        <!-- Hidden Member ID -->
                                        <input type="hidden" name="member_id" value="{{ auth()->user()->id }}">

                                        <!-- Event Selection -->
                                        <div class="sm:col-span-2">
                                            <label for="event_id"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
                                                Event</label>
                                            <select id="event_id" name="event_id" required
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5
                         dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                <option value="">-- Choose an event --</option>
                                                @foreach ($events as $event)
                                                <option value="{{ $event->id }}">{{ $event->title }} ({{
                                                    $event->start_date->format('M d, Y h:i A') }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Reservation Date -->
                                        <div class="sm:col-span-2">
                                            <label for="reservation_date"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reservation
                                                Date</label>
                                            <input type="datetime-local" id="reservation_date" name="reservation_date"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        </div>

                                        <!-- Remarks -->
                                        <div class="sm:col-span-2">
                                            <label for="remarks"
                                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks</label>
                                            <textarea id="remarks" name="remarks" rows="6"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                           focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600
                           dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                placeholder="Any special instructions or comments (optional)"></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700
                     rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                        Submit Reservation
                                    </button>
                                </form>
                            </div>
                        </section>


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
