@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section class="bg-gray-50 min-h-screen">
    <div class="pt-24">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-10 gap-8">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">

                {{-- Welcome Header --}}
                <div class="mb-8" data-aos="fade-down">
                    <div class="relative bg-white border border-gray-100 rounded-2xl p-8 shadow-sm overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold uppercase tracking-wider text-red-500 mb-1">Church Member Portal</p>
                            <h2 class="text-4xl font-extrabold text-slate-800 leading-tight">
                                Peace be with you, <span class="text-indigo-600">{{ auth()->user()->firstname }}</span>!
                            </h2>
                            <div class="flex items-center mt-4 text-gray-500 bg-gray-50 w-fit px-4 py-2 rounded-lg border border-gray-100">
                                <i class="material-icons text-indigo-500 text-sm mr-2">calendar_today</i>
                                <span class="text-sm font-medium">{{ now()->setTimezone('Asia/Manila')->format('l, F j, Y — h:i A') }}</span>
                            </div>
                        </div>
                        {{-- Decorative Icon --}}
                        <div class="absolute -right-8 -bottom-8 opacity-[0.03] text-slate-900 text-[200px] pointer-events-none">
                            <span class="material-icons">church</span>
                        </div>
                    </div>
                </div>

                {{-- Stats Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10" data-aos="fade-up">

                    <a href="{{ route('member.events.page') }}" class="group bg-white p-1 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Upcoming Events</p>
                                <h3 class="text-4xl font-black text-slate-800 mt-1">{{ $eventCount }}</h3>
                                <div class="mt-4 flex items-center text-xs font-medium text-orange-600 bg-orange-50 px-3 py-1 rounded-full group-hover:bg-orange-100 transition-colors">
                                    <i class="material-icons-outlined text-sm mr-1">bolt</i>
                                    <span>Next: {{ $nextEvent ? Str::limit($nextEvent->title, 20) : 'No events' }}</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center shadow-lg shadow-orange-200 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-white text-3xl">event</span>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('member.reservation') }}" class="group bg-white p-1 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">My Reservations</p>
                                <h3 class="text-4xl font-black text-slate-800 mt-1">{{ $reservationCount }}</h3>
                                <div class="mt-4 flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full group-hover:bg-emerald-100 transition-colors">
                                    <i class="material-icons-outlined text-sm mr-1">check_circle</i>
                                    <span>View all bookings</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-white text-3xl">book_online</span>
                            </div>
                        </div>
                    </a>

                </div>

                {{-- Activity Table Section --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800">Recent Church Activities</h3>
                        <a href="{{ route('member.events.page') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800">View Calendar →</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Organizer</th>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Event Detail</th>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Schedule</th>
                                    <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($events as $event)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                                                {{ substr($event->user->firstname ?? 'U', 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-700">{{ $event->user->firstname ?? 'Unknown' }}</div>
                                                <div class="text-xs text-gray-400">{{ $event->type }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-sm font-semibold text-slate-600 group-hover:text-indigo-700 transition-colors">
                                            {{ $event->title }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="text-sm text-slate-600 font-medium">{{ $event->start_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $event->start_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        @php
                                            $today = now()->startOfDay();
                                            $eventDate = $event->start_date->startOfDay();
                                            $statusClass = $eventDate->equalTo($today)
                                                ? 'bg-emerald-100 text-emerald-700'
                                                : ($eventDate->greaterThan($today) ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500');
                                            $statusText = $eventDate->equalTo($today) ? 'Today' : ($eventDate->greaterThan($today) ? 'Upcoming' : 'Done');
                                        @endphp
                                        <span class="px-3 py-1 text-[11px] font-black uppercase tracking-wider rounded-full {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="material-icons text-gray-200 text-6xl mb-2">event_busy</span>
                                            <p class="text-gray-400 font-medium">No church events scheduled at the moment.</p>
                                        </div>
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
</section>
@endsection
