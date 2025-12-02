@extends('components.default')

@section('title', 'Sacraments | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.admin.bg')
        @include('components.admin.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="px-6 py-6 flex justify-between items-center">
                        <h1 class="text-2xl font-bold">Sacraments</h1>
                        <button id="openSacramentModal"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add Sacrament
                        </button>
                    </div>

                    {{-- Breadcrumb --}}
                    <div class="px-6 py-2">
                        <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50"
                            aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
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
                                        <span class="ms-1 text-sm font-medium text-gray-500">
                                            Sacraments
                                        </span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                    <div class="px-6 py-2">
                        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    {{-- Sacraments Table --}}
                    <div class="relative overflow-x-auto sm:rounded-lg px-6 py-6">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Sacrament Type</th>
                                    <th class="px-6 py-3">Fee</th>
                                    <th class="px-6 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sacraments as $sacrament)
                                <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                    <td class="px-6 py-4">{{ $sacrament->id }}</td>
                                    <td class="px-6 py-4">{{ $sacrament->sacrament_type }}</td>
                                    <td class="px-6 py-4">{{ number_format($sacrament->fee, 2) }}</td>
                                    <td class="px-6 py-4 text-center flex gap-2 justify-center">
                                        <button
                                            onclick="openEditModal({{ $sacrament->id }}, '{{ $sacrament->sacrament_type }}', '{{ $sacrament->fee }}')"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>
                                        {{-- Delete Button --}}
                                        <button data-id="{{ $sacrament->id }}" class="delete-sacrament-btn bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                            Delete
                                        </button>

                                        {{-- Hidden Form --}}
                                        <form id="delete-sacrament-form" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

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

    {{-- Add/Edit Sacrament Modal --}}
    <div id="sacramentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-8 w-[500px] max-w-full max-h-[90vh] overflow-auto relative">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
            <h2 id="modalTitle" class="text-2xl font-bold mb-4">Add Sacrament</h2>

            <form id="sacramentForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="mb-4">
                    <label class="block font-medium mb-1">Sacrament Type</label>
                    <input type="text" name="sacrament_type" id="sacrament_type" class="w-full border rounded px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block font-medium mb-1">Fee</label>
                    <input type="number" name="fee" id="fee" class="w-full border rounded px-3 py-2" min="0" step="0.01"
                        required>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    function openEditModal(id, type, fee){
    const modal = document.getElementById('sacramentModal');
    modal.classList.remove('hidden');

    document.getElementById('modalTitle').innerText = 'Edit Sacrament';
    document.getElementById('sacrament_type').value = type;
    document.getElementById('fee').value = fee;

    const form = document.getElementById('sacramentForm');
    form.action = `/admin/sacraments/${id}`;
    document.getElementById('formMethod').value = 'PUT';
}

function openAddModal(){
    const modal = document.getElementById('sacramentModal');
    modal.classList.remove('hidden');
    document.getElementById('modalTitle').innerText = 'Add Sacrament';
    document.getElementById('sacrament_type').value = '';
    document.getElementById('fee').value = '';
    const form = document.getElementById('sacramentForm');
    form.action = "{{ route('admin.sacraments.store') }}";
    document.getElementById('formMethod').value = 'POST';
}

function closeModal(){
    document.getElementById('sacramentModal').classList.add('hidden');
}

document.getElementById('openSacramentModal').addEventListener('click', openAddModal);
</script>
@push('scripts')
@include('components.alerts')
<script>
    document.querySelectorAll('.delete-sacrament-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const sacramentId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This sacrament will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-sacrament-form');
                    form.setAttribute('action', `/admin/sacraments/${sacramentId}`);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

@endsection
