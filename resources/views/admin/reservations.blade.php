@extends('components.default')

@section('title', 'Reservations | Santo Niño Parish Church')

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
                                        Admin
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
                                            class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Reservations</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="relative overflow-x-auto sm:rounded-xl bg-white dark:bg-gray-900 shadow-xl px-6 py-6">

    <table id="datatable" class="w-full text-sm text-left text-gray-700 dark:text-gray-200">

        <!-- TABLE HEADER -->
        <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
            <tr class="[&>th]:px-6 [&>th]:py-4 [&>th]:font-semibold border-b dark:border-gray-700">

                <th class="tracking-wide">Member Name</th>
                <th class="tracking-wide">Event Id</th>
                <th class="tracking-wide">Status</th>
                <th class="tracking-wide">Reservation Date</th>
                <th class="tracking-wide">Remarks</th>
                <th class="tracking-wide">Approved By</th>
                <th class="tracking-wide text-right">Actions</th>
            </tr>
        </thead>

        <!-- TABLE BODY -->
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

            @foreach ($reservations as $reservation)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                <!-- Member Name -->
                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                    {{ $reservation->member->user->firstname }} {{ $reservation->member->user->lastname }}
                </td>

                <!-- Event -->
                <td class="px-6 py-4">
                    <span class="text-gray-700 dark:text-gray-300">{{ $reservation->type }}</span>
                </td>

                <!-- Status with clean pill badges -->
                <td class="px-6 py-4">
                    @if ($reservation->status === 'approved')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-700 dark:text-white">
                            Approved
                        </span>
                    @elseif ($reservation->status === 'pending')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-600 dark:text-white">
                            Pending
                        </span>
                    @elseif ($reservation->status === 'cancel')
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 dark:bg-red-700 dark:text-white">
                            Cancelled
                        </span>
                    @endif
                </td>

                <!-- Date -->
                <td class="px-6 py-4">
                    {{ $reservation->reservation_date->format('F j, Y \a\t g:i A') }}
                </td>

                <!-- Remarks -->
                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                    {{ $reservation->remarks ?? '—' }}
                </td>

                <!-- Approved By -->
                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ $reservation->approvedBy?->firstname . ' ' . $reservation->approvedBy?->lastname ?? 'Not yet approved' }}
                </td>

                <!-- Actions -->
                <td class="px-6 py-4 text-right space-x-2">

                    <!-- Delete -->
                    <a href="#" data-id="{{ $reservation->id }}"
                        class="delete-reservation-btn inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                        Delete
                    </a>

                    @if ($reservation->status !== 'cancel')
                    <!-- Edit -->
                    <a href="{{ route('reservations.edit', ['id' => $reservation->id]) }}"
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                        Edit
                    </a>
                    @endif

                    @if (!$reservation->approved_by)
                    <!-- Approve -->
                    <form action="{{ route('reservations.approve', $reservation->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition">
                            Approve
                        </button>
                    </form>
                    @endif

                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
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
    document.querySelectorAll('.delete-reservation-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const reservationId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This reservation will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-reservation-form');
                    form.setAttribute('action', `/admin/reservations/${reservationId}`);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
