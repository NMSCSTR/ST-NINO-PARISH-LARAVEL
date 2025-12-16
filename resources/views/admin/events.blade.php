@extends('components.default')

@section('title', 'Events | Santo Niño Parish Church')

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

                <div class="bg-white rounded-xl shadow-lg">
                    <div class="px-6 py-6">

                        <!-- Breadcrumb -->
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                        <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Admin
                                    </a>
                                </li>

                                <li>
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600">
                                            Dashboard
                                        </a>
                                    </div>
                                </li>

                                <li aria-current="page">
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-3 h-3 mx-1 text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <span class="ms-1 text-sm font-medium text-gray-500">
                                            Events
                                        </span>
                                    </div>
                                </li>
                            </ol>
                        </nav>


                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-700">Events</h2>
                            <button id="addEventBtn"
                                class="inline-flex items-center px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Event
                            </button>
                        </div>


                    </div>

                    <div class="relative overflow-x-auto sm:rounded-lg px-6 py-6">
                        <table id="datatable" class="w-full text-sm text-left rtl:text-right text-gray-700">

                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Created By</th>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">Description</th>
                                    <th scope="col" class="px-6 py-3">Start Date</th>
                                    <th scope="col" class="px-6 py-3">End Date</th>
                                    <th scope="col" class="px-6 py-3">Event Type</th>
                                    <th scope="col" class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($events as $event)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">

                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $event->user->firstname }} {{ $event->middle_name }} {{
                                        $event->user->lastname }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $event->title }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $event->description }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $event->start_date }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $event->end_date }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucfirst($event->type) }}
                                    </td>

                                    <td class="px-6 py-4 text-center flex gap-2">

                                        <a href="#" data-id="{{ $event->id }}"
                                            class="delete-user-btn inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                                            <svg class="w-4 h-4 text-white me-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7L5 7M6 7v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7M10 11v6M14 11v6M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                            Delete
                                        </a>

                                        <a href="{{ route('admin.users.edit', ['id' => $event->id]) }}"
                                            class="inline-flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                            <svg class="w-4 h-4 text-white me-2" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16 7l-8 8H4v-4l8-8 4 4z" />
                                            </svg>
                                            Edit
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>


                    <!-- Event Modal (Add / Update) -->
                    <div id="eventModal"
                        class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-50">
                        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6 relative">

                            <!-- Modal Header -->
                            <div class="flex justify-between items-center mb-6">
                                <h3 id="modalTitle" class="text-xl font-semibold text-gray-800">Add Event</h3>
                                <button id="closeEventModal" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <form id="eventForm" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="_method" id="formMethod" value="POST">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="title" id="title" required
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                            Date <span class="text-red-500">*</span></label>
                                        <input type="datetime-local" name="start_date" id="start_date" required
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">End
                                            Date</label>
                                        <input type="datetime-local" name="end_date" id="end_date"
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    </div>
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Event Type</label>
                                    <input type="text" name="type" id="type"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                        value="general">
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                                    <button type="button" id="closeEventModal"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                        Cancel
                                    </button>
                                    <button type="submit" id="saveEventBtn"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Save Event
                                    </button>
                                </div>
                            </form>
                        </div>
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
    const eventModal = document.getElementById('eventModal');
    const modalTitle = document.getElementById('modalTitle');
    const eventForm = document.getElementById('eventForm');
    const formMethod = document.getElementById('formMethod');
    const saveEventBtn = document.getElementById('saveEventBtn');
    const closeEventModal = document.querySelectorAll('#closeEventModal');

    const openAddModal = () => {
        modalTitle.textContent = 'Add Event';
        eventForm.action = "{{ route('admin.events.store') }}";
        formMethod.value = 'POST';
        eventForm.reset();
        eventModal.classList.remove('hidden');
    };

    const openEditModal = (event) => {
        modalTitle.textContent = 'Edit Event';
        eventForm.action = `/admin/events/${event.id}`;
        formMethod.value = 'PUT';
        document.getElementById('title').value = event.title;
        document.getElementById('description').value = event.description;
        document.getElementById('start_date').value = event.start;
        document.getElementById('end_date').value = event.end || '';
        document.getElementById('type').value = event.type;
        eventModal.classList.remove('hidden');
    };

    closeEventModal.forEach(btn => {
        btn.addEventListener('click', () => {
            eventModal.classList.add('hidden');
        });
    });

    // Delete event with SweetAlert
    document.querySelectorAll('.delete-event-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.dataset.id;

            Swal.fire({
                title: 'Are you sure?',
                text: "This event will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/events/${eventId}`;
                    form.innerHTML = `
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>

<script>
    const addEventBtn = document.getElementById('addEventBtn');
    const addEventModal = document.getElementById('addEventModal');
    const closeAddEventModal = document.getElementById('closeAddEventModal');

    addEventBtn.addEventListener('click', () => {
        addEventModal.classList.remove('hidden');
    });

    closeAddEventModal.addEventListener('click', () => {
        addEventModal.classList.add('hidden');
    });

    // Optional: click outside modal to close
    window.addEventListener('click', (e) => {
        if (e.target === addEventModal) {
            addEventModal.classList.add('hidden');
        }
    });
</script>

<script>
    document.querySelectorAll('.delete-user-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-user-form');
                    form.setAttribute('action', `/admin/users/${userId}`);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
