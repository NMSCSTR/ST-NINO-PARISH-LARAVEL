@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        {{-- @include('components.admin.bg') --}}
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Include Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
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
                        <h2 class="text-4xl font-bold text-indigo-900 leading-tight"> {{
                            Str::ucfirst(auth()->user()->role) }}
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
                    <div class="bg-white rounded-xl  px-6 py-6 flex items-center justify-between shadow-2xl">
                        <div>
                            <p class="text-gray-600 text-sm">Total Members</p>
                            <h3 class="text-3xl font-semibold text-indigo-900">{{ $totalMembers }}</h3>
                        </div>
                        <span class="material-icons-outlined text-4xl text-blue-500">group</span>
                    </div>
                    <!-- Upcoming Events -->
                    <div
                        class="bg-white rounded-2xl shadow-card p-6 flex items-center justify-between transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1 shadow-2xl">
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Upcoming Events</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $eventCount }}</h3>
                            <p class="text-xs text-blue-500 mt-2 flex items-center">
                                <span class="material-icons-outlined text-sm mr-1">event_available</span>
                                <span>Next: Sunday Mass</span>
                            </p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center">
                            <span class="material-icons-outlined text-3xl text-orange-500">event</span>
                        </div>
                    </div>

                    <!-- New Reservations -->
                    <div class="bg-white rounded-xl px-6 py-6 flex items-center justify-between shadow-2xl">
                        <div>
                            <p class="text-gray-600 text-sm">New Reservations</p>
                            <h3 class="text-3xl font-semibold text-indigo-900">{{ $reservationCount }}</h3>
                        </div>
                        <span class="material-icons-outlined text-4xl text-green-500">event_available</span>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="mt-8 shadow-lg p-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Events</h3>
                    <div class="bg-white rounded-2xl shadow-card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Member</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Activity</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($events as $event)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-accent-500 mr-3">
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $event->user->firstname ?? 'Unknown User' }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $event->type }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->title }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $event->start_date->format('M d, Y h:i A') }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Upcoming
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">
                                            No upcoming events found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


@endsection
