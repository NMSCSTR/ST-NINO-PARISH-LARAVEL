@extends('components.default')

@section('title', 'My Reservations')

@section('content')

@include('components.member.topnav')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-4">My Reservations</h2>

    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">

        <table class="w-full text-sm text-gray-700">
            <thead>
                <tr class="border-b">
                    <th class="p-3">Sacrament</th>
                    <th class="p-3">Reservation Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($reservations as $res)
                <tr class="border-b">
                    <td class="p-3">{{ ucfirst($res->sacrament->sacrament_type) }}</td>
                    <td class="p-3">{{ $res->reservation_date?->format('M d, Y') }}</td>
                    <td class="p-3 capitalize">{{ $res->status }}</td>
                    <td class="p-3">
                        <button
                            class="bg-blue-600 text-white px-3 py-1 rounded detailBtn"
                            data-id="{{ $res->id }}">
                            View Details
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

{{-- Modal --}}
<div id="detailsModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">

    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">

        <button id="closeModal" class="absolute top-2 right-2 text-xl">&times;</button>

        <h2 class="text-xl font-bold mb-4">Reservation Details</h2>

        <div id="modalContent">
            <!-- AJAX loads content here -->
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Open modal
    const modal = document.getElementById('detailsModal');
    const closeModal = document.getElementById('closeModal');

    document.querySelectorAll('.detailBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            let id = this.dataset.id;

            fetch(`/reservation/payments/${id}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <p><strong>Member:</strong> ${data.member}</p>
                        <p><strong>Sacrament:</strong> ${data.sacrament}</p>

                        <h3 class="mt-4 font-bold">Payments</h3>
                    `;

                    if (data.payments.length > 0) {
                        html += `
                            <ul class="list-disc ml-6">
                                ${data.payments.map(p => `
                                    <li>
                                        <strong>₱${p.amount}</strong> (${p.method}) -
                                        <em>${p.status}</em> - ${p.date}
                                        ${p.receipt_url ? `<br><img src="${p.receipt_url}" class="w-32 mt-2 rounded border">` : ''}
                                    </li>
                                `).join('')}
                            </ul>
                        `;
                    } else {
                        html += `<p>No payments found.</p>`;
                    }

                    document.getElementById('modalContent').innerHTML = html;
                    modal.classList.remove('hidden');
                });
        });
    });

    // Close modal
    closeModal.addEventListener('click', () => modal.classList.add('hidden'));
</script>
@endpush

