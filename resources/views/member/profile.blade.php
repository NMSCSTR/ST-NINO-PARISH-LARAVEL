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
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
                        <h2 class="text-2xl font-bold text-gray-800">Parish Events Calendar</h2>

                        {{-- Legend --}}
                        <div class="flex flex-wrap gap-3">
                            <div class="flex items-center text-xs font-bold text-slate-500">
                                <span class="w-3 h-3 bg-emerald-500 rounded-full mr-1"></span> Mass
                            </div>
                            <div class="flex items-center text-xs font-bold text-slate-500">
                                <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span> Wedding
                            </div>
                            <div class="flex items-center text-xs font-bold text-slate-500">
                                <span class="w-3 h-3 bg-purple-500 rounded-full mr-1"></span> Baptism
                            </div>
                            <div class="flex items-center text-xs font-bold text-slate-500">
                                <span class="w-3 h-3 bg-slate-400 rounded-full mr-1"></span> Others
                            </div>
                        </div>
                    </div>

                    <div id="calendar" class="w-full min-h-[75vh]"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Event Modal --}}
    <div id="eventModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center hidden z-[60] p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative animate-in fade-in zoom-in duration-200">
            <div id="modalAccent" class="h-2 w-full bg-indigo-600 transition-colors duration-500"></div>

            <div class="p-8">
                <button id="closeModal" class="absolute top-6 right-6 text-gray-400 hover:text-rose-500 transition-colors">
                    <span class="material-icons text-2xl font-bold">close</span>
                </button>

                <div class="flex items-center mb-4">
                    <span id="modalTypeBadge" class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border">
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
    :root {
        --fc-border-color: #f1f5f9;
        --fc-button-bg-color: #ffffff;
        --fc-button-text-color: #475569;
        --fc-button-border-color: #e2e8f0;
        --fc-button-active-bg-color: #4f46e5;
    }
    .fc .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 800; color: #1e293b; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f8fafc !important; }
    .fc-event {
        border: none !important;
        padding: 3px 6px !important;
        border-radius: 6px !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 2px !important;
    }
    .fc-event-title { font-weight: 700 !important; font-size: 0.75rem !important; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const modal = document.getElementById('eventModal');
    const modalAccent = document.getElementById('modalAccent');
    const modalTypeBadge = document.getElementById('modalTypeBadge');

    // Color Configuration
    const eventColors = {
        mass: { bg: '#10b981', accent: 'bg-emerald-500', badge: 'bg-emerald-50 text-emerald-600 border-emerald-100' },
        wedding: { bg: '#3b82f6', accent: 'bg-blue-500', badge: 'bg-blue-50 text-blue-600 border-blue-100' },
        baptism: { bg: '#a855f7', accent: 'bg-purple-500', badge: 'bg-purple-50 text-purple-600 border-purple-100' },
        funeral: { bg: '#64748b', accent: 'bg-slate-500', badge: 'bg-slate-50 text-slate-600 border-slate-100' },
        default: { bg: '#6366f1', accent: 'bg-indigo-500', badge: 'bg-indigo-50 text-indigo-600 border-indigo-100' }
    };

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'events/data',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },

        // Color Logic: Applies color to the calendar items
        eventDidMount: function(info) {
            const type = (info.event.extendedProps.type || '').toLowerCase();
            const colorSet = eventColors[type] || eventColors.default;

            info.el.style.backgroundColor = colorSet.bg;
        },

        eventClick: function(info) {
            info.jsEvent.preventDefault();
            const type = (info.event.extendedProps.type || '').toLowerCase();
            const colorSet = eventColors[type] || eventColors.default;

            // Update Modal UI based on event type
            modalTitle.textContent = info.event.title;
            modalDescription.textContent = info.event.extendedProps.description || 'No description provided.';

            modalTypeBadge.textContent = info.event.extendedProps.type || 'General';
            modalTypeBadge.className = `px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border ${colorSet.badge}`;

            modalAccent.className = `h-2 w-full transition-colors duration-500 ${colorSet.accent}`;

            const options = { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            modalStart.textContent = info.event.start ? info.event.start.toLocaleString(undefined, options) : 'N/A';
            modalEnd.textContent = info.event.end ? info.event.end.toLocaleString(undefined, options) : 'Ends Same Day';

            modal.classList.remove('hidden');
        }
    });

    calendar.render();

    document.getElementById('closeModal').onclick = () => modal.classList.add('hidden');
    window.onclick = (e) => { if (e.target === modal) modal.classList.add('hidden'); };
});
</script>
@endsection
