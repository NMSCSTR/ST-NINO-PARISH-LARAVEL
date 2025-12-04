<script>
/* DELETE RESERVATION */
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

<!-- DOCUMENTS MODAL -->
<script>
function openDocumentsModal(reservationId) {
    fetch(`/admin/reservations/${reservationId}/documents`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("documentsReservationInfo").innerHTML =
                `Reservation for <strong>${data.member}</strong> — <span class="text-gray-700">${data.sacrament}</span>`;

            let html = "";

            if (data.documents.length === 0) {
                html = `<p class="text-gray-400 text-center">No documents uploaded.</p>`;
            } else {
                data.documents.forEach(doc => {
                    html += `
                        <div class="border rounded-lg shadow p-2 bg-white">
                            <img src="${doc.url}"
                                 class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-80"
                                 onclick="showReceipt('${doc.url}')">
                        </div>
                    `;
                });
            }

            document.getElementById("documentsContainer").innerHTML = html;

            const modal = document.getElementById("documentsModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
}

function closeDocumentsModal() {
    const modal = document.getElementById("documentsModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}
</script>

<!-- RECEIPT MODAL -->
<script>
function showReceipt(url) {
    document.getElementById('receiptImage').src = url;
    document.getElementById('receiptModal').classList.remove('hidden');
    document.getElementById('receiptModal').classList.add('flex');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
    document.getElementById('receiptModal').classList.remove('flex');
}
</script>

<!-- PAYMENT LIST MODAL -->
<script>
function openPaymentListModal(reservationId) {
    fetch(`/admin/reservations/${reservationId}/payments`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("paymentListReservationInfo").innerHTML =
                `Reservation for <strong>${data.member}</strong> — <span class="text-gray-700">${data.sacrament}</span>`;

            let rows = "";

            if (data.payments.length === 0) {
                rows = `<tr><td colspan="5" class="px-3 py-3 text-center text-gray-400">No payments found.</td></tr>`;
            } else {
                data.payments.forEach(payment => {
                    rows += `
                        <tr class="border-b">
                            <td class="px-3 py-2">₱${parseFloat(payment.amount).toFixed(2)}</td>
                            <td class="px-3 py-2">${payment.method ?? '-'}</td>
                            <td class="px-3 py-2">
                                <span class="${payment.status === 'paid' ? 'text-green-600' : 'text-yellow-600'}">
                                    ${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                ${payment.receipt_path ?
                                    `<button onclick="showReceipt('${payment.receipt_url}')"
                                        class="text-blue-600 underline">View</button>` : '-'}
                            </td>
                            <td class="px-3 py-2">${payment.date}</td>
                        </tr>
                    `;
                });
            }

            document.getElementById("paymentListBody").innerHTML = rows;

            const modal = document.getElementById("paymentListModal");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
}

function closePaymentListModal() {
    const modal = document.getElementById("paymentListModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");
}
</script>

<!-- ADMIN PAY-MODAL -->
<script>
function openPaymentModal(reservationId) {
    const form = document.getElementById('adminPayNowForm');
    form.action = `/admin/payments/${reservationId}/pay-now`;
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentModal').classList.add('flex');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentModal').classList.remove('flex');
}
</script>
<script>
/* FORWARD TO PRIEST CONFIRMATION */
document.querySelectorAll('form[action*="forward"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent immediate form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "This reservation will be forwarded to the priest.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, forward it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Submit the form if confirmed
            }
        });
    });
});
</script>
