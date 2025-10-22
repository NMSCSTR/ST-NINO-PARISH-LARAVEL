@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        {{-- Include Top Navigation --}}
        @include('components.admin.topnav')


        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Include Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="flex flex-col lg:flex-row gap-6 mb-6" data-aos="zoom-in">
                    {{-- Welcome Card --}}
                    <div
                        class="flex-1 bg-gradient-to-r from-red-100 to-red-300 border border-red-300 rounded-xl p-6 relative overflow-hidden">
                        <div class="absolute right-4 bottom-4 opacity-30 text-red-500 text-[120px] pointer-events-none">
                            <span class="material-icons-outlined">emoji_people</span>
                        </div>

                        <p class="text-xl text-gray-700">Welcome back,</p>
                        <h2 class="text-4xl font-bold text-indigo-900 leading-tight"> {{ Str::ucfirst(auth()->user()->role) }}
                            {{ auth()->user()->firstname }}
                        </h2>

                        <div class="mt-6">
                            <span class="bg-red-400 text-white text-sm px-5 py-2 rounded-full font-semibold shadow">
                                <i class="material-icons text-base align-middle mr-1">access_time</i>
                                {{ now()->setTimezone('Asia/Manila')->format('l, F j, Y h:i A') }}
                            </span>
                        </div>
                    </div>

                    {{-- Inbox Card --}}
                    <div
                        class="flex-1 bg-gradient-to-r from-orange-100 to-orange-300 border border-orange-300 rounded-xl p-6 relative overflow-hidden">
                        <div
                            class="absolute right-4 bottom-4 opacity-30 text-orange-500 text-[120px] pointer-events-none">
                            <span class="material-icons-outlined">mail</span>
                        </div>

                        <p class="text-xl text-gray-700">Inbox</p>
                        <h2 class="text-4xl font-bold text-indigo-900 leading-tight">23 Messages</h2>

                        <div class="mt-6">
                            <a href="#"
                                class="inline-block bg-orange-400 hover:bg-orange-500 text-white text-sm px-5 py-2 rounded-full font-semibold shadow transition">
                                <i class="material-icons text-base align-middle mr-1">mark_email_unread</i>
                                See Messages
                            </a>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" data-aos="fade-up">
                    <!-- Total Members -->
                    <div class="bg-white rounded-xl shadow-lg px-6 py-6 flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Members</p>
                            <h3 class="text-3xl font-semibold text-indigo-900"></h3>
                        </div>
                        <span class="material-icons-outlined text-4xl text-blue-500">group</span>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="bg-white rounded-xl shadow-lg px-6 py-6 flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Upcoming Events</p>
                            <h3 class="text-3xl font-semibold text-indigo-900"></h3>
                        </div>
                        <span class="material-icons-outlined text-4xl text-orange-500">event</span>
                    </div>

                    <!-- New Reservations -->
                    <div class="bg-white rounded-xl shadow-lg px-6 py-6 flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">New Reservations</p>
                            <h3 class="text-3xl font-semibold text-indigo-900"></h3>
                        </div>
                        <span class="material-icons-outlined text-4xl text-green-500">event_available</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


@endsection
