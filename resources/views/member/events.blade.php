@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            <div class="lg:w-10/12 w-full">
                <div id="calendar" class="w-full h-[80vh] px-4 py-4"></div>
            </div>
        </div>
    </div>

    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <!-- Modal box -->
        <div class="bg-white rounded-lg p-8 w-[600px] max-w-full max-h-[90vh] overflow-auto relative">
            <button id="closeModal"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            <h2 id="modalTitle" class="text-2xl font-bold mb-4"></h2>
            <p id="modalDescription" class="mb-6 whitespace-pre-line"></p>
            <p class="mb-2"><strong>Type:</strong> <span id="modalType"></span></p>
            <p class="mb-2"><strong>Start:</strong> <span id="modalStart"></span></p>
            <p><strong>End:</strong> <span id="modalEnd"></span></p>
        </div>
    </div>


</section>
@endsection

@section('scripts')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var modal = document.getElementById('eventModal');
    var closeModalBtn = document.getElementById('closeModal');

    var modalTitle = document.getElementById('modalTitle');
    var modalDescription = document.getElementById('modalDescription');
    var modalType = document.getElementById('modalType');
    var modalStart = document.getElementById('modalStart');
    var modalEnd = document.getElementById('modalEnd');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'events/data',
        timeZone: 'UTC',
        views: {
            dayGridYear: {
            type: 'dayGrid',
            duration: { years: 1 },
            buttonText: 'Year'
            }
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridYear,dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        eventDisplay: 'block',

        eventClick: function(info) {

            info.jsEvent.preventDefault();

            // Populate modal fields
            modalTitle.textContent = info.event.title;
            modalDescription.textContent = info.event.extendedProps.description || 'No description.';
            modalType.textContent = info.event.extendedProps.type || 'General';

            // Format dates nicely
            var options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            modalStart.textContent = info.event.start ? info.event.start.toLocaleString(undefined, options) : 'N/A';
            modalEnd.textContent = info.event.end ? info.event.end.toLocaleString(undefined, options) : '1 day event';

            // Show modal
            modal.classList.remove('hidden');
        }
    });

    calendar.render();

    // Close modal event
    closeModalBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
    });

    // Optional: close modal on clicking outside modal box
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});


</script>
@endsection
