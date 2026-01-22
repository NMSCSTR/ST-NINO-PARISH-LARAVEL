@extends('components.default')

@section('title', 'Admin Dashboard | Santo Niño Parish Church')

@section('content')
<section class="bg-gray-50 min-h-screen">
    <div class="pt-24">
        @include('components.admin.bg')
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-10 gap-8">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">

                {{-- Welcome Header --}}
                <div class="mb-8" data-aos="fade-down">
                    <div class="relative bg-white border border-gray-100 rounded-2xl p-8 shadow-sm overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-500 mb-1">System Administrator</p>
                            <h2 class="text-4xl font-extrabold text-slate-800 leading-tight">
                                Welcome back, <span class="text-indigo-600">{{ auth()->user()->firstname }}</span>!
                            </h2>
                            <div class="flex items-center mt-4 text-gray-500 bg-gray-50 w-fit px-4 py-2 rounded-lg border border-gray-100">
                                <i class="material-icons text-indigo-500 text-sm mr-2">schedule</i>
                                <span class="text-sm font-medium">{{ now()->setTimezone('Asia/Manila')->format('l, F j, Y — h:i A') }}</span>
                            </div>
                        </div>
                        {{-- Decorative Icon --}}
                        <div class="absolute -right-8 -bottom-8 opacity-[0.03] text-slate-900 text-[200px] pointer-events-none">
                            <span class="material-icons">admin_panel_settings</span>
                        </div>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6" data-aos="fade-up">

                    <div class="group bg-white p-1 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Total Members</p>
                                <h3 class="text-4xl font-black text-slate-800 mt-1">
                                    {{ $users->where('role', '!=', 'admin')->count() }}
                                </h3>
                                <div class="mt-4 flex items-center text-xs font-medium text-blue-600 bg-blue-50 px-3 py-1 rounded-full group-hover:bg-blue-100 transition-colors">
                                    <i class="material-icons text-sm mr-1">people_outline</i>
                                    <span>Registered Parishioners</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-white text-3xl">group</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white p-1 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Parish Events</p>
                                <h3 class="text-4xl font-black text-slate-800 mt-1">
                                    {{ $events->count() }}
                                </h3>
                                <div class="mt-4 flex items-center text-xs font-medium text-orange-600 bg-orange-50 px-3 py-1 rounded-full group-hover:bg-orange-100 transition-colors">
                                    <i class="material-icons text-sm mr-1">calendar_today</i>
                                    <span>Scheduled for this month</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center shadow-lg shadow-orange-200 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-white text-3xl">event</span>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white p-1 rounded-2xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="p-6 flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-semibold uppercase tracking-wide">New Reservations</p>
                                <h3 class="text-4xl font-black text-slate-800 mt-1">
                                    {{ $reservations->count() }}
                                </h3>
                                <div class="mt-4 flex items-center text-xs font-medium text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full group-hover:bg-emerald-100 transition-colors">
                                    <i class="material-icons text-sm mr-1">pending_actions</i>
                                    <span>Awaiting approval</span>
                                </div>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform">
                                <span class="material-icons text-white text-3xl">event_available</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Future Chart/Recent Activity Area --}}
                <div class="mt-10 grid grid-cols-1 gap-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-slate-800 tracking-tight">System Status</h4>
                            <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse mr-2"></span>
                                Operational
                            </span>
                        </div>
                        <div class="h-32 border-2 border-dashed border-gray-100 rounded-xl flex items-center justify-center">
                            <p class="text-gray-400 text-sm italic font-medium">Parish analytics and growth charts can be placed here.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
