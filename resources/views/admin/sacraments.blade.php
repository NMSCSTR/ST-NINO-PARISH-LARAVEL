@extends('components.default')

@section('title', 'Sacraments | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            <div class="lg:w-10/12 w-full">

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold">Sacraments</h1>
                    <button id="openSacramentModal"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Sacrament</button>
                </div>

                @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Sacraments Table -->
                <div class="overflow-auto bg-white rounded shadow p-4">
                    <table class="w-full table-auto border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="px-4 py-2 border">ID</th>
                                <th class="px-4 py-2 border">Sacrament Type</th>
                                <th class="px-4 py-2 border">Fee</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sacraments as $sacrament)
                            <tr class="border-t">
                                <td class="px-4 py-2 border">{{ $sacrament->id }}</td>
                                <td class="px-4 py-2 border">{{ $sacrament->sacrament_type }}</td>
                                <td class="px-4 py-2 border">{{ number_format($sacrament->fee, 2) }}</td>
                                <td class="px-4 py-2 border flex gap-2">
                                    <!-- Edit Button triggers modal -->
                                    <button
                                        onclick="openEditModal({{ $sacrament->id }}, '{{ $sacrament->sacrament_type }}', '{{ $sacrament->fee }}')"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('sacraments.destroy', $sacrament->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
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

    <!-- Add/Edit Sacrament Modal -->
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
    form.action = "{{ route('admin.admin.sacraments.store') }}";
    document.getElementById('formMethod').value = 'POST';
}

function closeModal(){
    document.getElementById('sacramentModal').classList.add('hidden');
}

// Open modal for Add button
document.getElementById('openSacramentModal').addEventListener('click', openAddModal);
</script>
@endsection
