@extends('components.default')

@section('title', 'Events Calendar | Santo Niño Parish Church')

@section('content')
<section class="bg-gray-50 min-h-screen">
    <div class="pt-24 pb-10">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 gap-8">
            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full" data-aos="fade-up">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Parish Events Calendar</h2>
                        <div class="flex items-center space-x-2 text-sm text-gray-500">
                            <span class="w-3 h-3 bg-indigo-600 rounded-full"></span>
                            <span>Church Events</span>
                        </div>
                    </div>

                    {{-- Calendar Container --}}
                    <div id="calendar" class="w-full min-h-[75vh]"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Refined Modal --}}
    <div id="eventModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center hidden z-[60] p-4 transition-all">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative animate-in fade-in zoom-in duration-200">
            {{-- Decorative Header --}}
            <div class="h-2 bg-indigo-600 w-full"></div>

            <div class="p-8">
                <button id="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-rose-500 transition-colors">
                    <span class="material-icons text-2xl font-bold">close</span>
                </button>

                <div class="flex items-center mb-4">
                    <span id="modalTypeBadge" class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider">
                        General
                    </span>
                </div>

                <h2 id="modalTitle" class="text-3xl font-black text-slate-800 mb-4 leading-tight"></h2>

                <div class="space-y-4 mb-8">
                    <div class="flex items-start text-slate-600">
                        <span class="material-icons-outlined text-indigo-500 mr-3">notes</span>
                        <p id="modalDescription" class="whitespace-pre-line text-sm leading-relaxed"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Starts</span>
                            <div class="flex items-center text-slate-700 font-semibold text-sm">
                                <span class="material-icons-outlined text-xs mr-2 text-slate-400">schedule</span>
                                <span id="modalStart"></span>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Ends</span>
                            <div class="flex items-center text-slate-700 font-semibold text-sm">
                                <span class="material-icons-outlined text-xs mr-2 text-slate-400">event_available</span>
                                <span id="modalEnd"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <button onclick="document.getElementById('eventModal').classList.add('hidden')"
                    class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors">
                    Close Details
                </button>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<style>
    /* FullCalendar Styling Overrides */
    :root {
        --fc-border-color: #f1f5f9;
        --fc-daygrid-event-dot-width: 8px;
        --fc-event-bg-color: #4f46e5;
        --fc-event-border-color: #4f46e5;
        --fc-button-bg-color: #ffffff;
        --fc-button-text-color: #475569;
        --fc-button-border-color: #e2e8f0;
        --fc-button-hover-bg-color: #f8fafc;
        --fc-button-hover-border-color: #cbd5e1;
        --fc-button-active-bg-color: #4f46e5;
        --fc-button-active-border-color: #4f46e5;
    }

    .fc .fc-toolbar-title {
        font-size: 1.25rem !important;
        font-weight: 800;
        color: #1e293b;
        text-transform: capitalize;
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active,
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #4f46e5 !important;
        color: white !important;
    }

    .fc-theme-standard td, .fc-theme-standard th {
        border-color: #f1f5f9 !important;
    }

    .fc-event {
        padding: 2px 4px;
        border-radius: 6px !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        margin-top: 1px !important;
        cursor: pointer;
    }

    .fc-v-event { border: none !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById('eventModal');
    var closeModalBtn = document.getElementById('closeModal');

    var modalTitle = document.getElementById('modalTitle');
    var modalDescription = document.getElementById('modalDescription');
    var modalTypeBadge = document.getElementById('modalTypeBadge');
    var modalStart = document.getElementById('modalStart');
    var modalEnd = document.getElementById('modalEnd');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'events/data',
        timeZone: 'Asia/Manila', // Specific timezone usually better for PH churches
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventDisplay: 'block',
        height: 'auto',
        eventClick: function(info) {
            info.jsEvent.preventDefault();

            modalTitle.textContent = info.event.title;
            modalDescription.textContent = info.event.extendedProps.description || 'No description available for this event.';
            modalTypeBadge.textContent = info.event.extendedProps.type || 'General';

            var options = { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            modalStart.textContent = info.event.start ? info.event.start.toLocaleString(undefined, options) : 'N/A';
            modalEnd.textContent = info.event.end ? info.event.end.toLocaleString(undefined, options) : '1-day event';

            modal.classList.remove('hidden');
        }
    });

    calendar.render();

    closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
    modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });
});
</script>
@endsection
