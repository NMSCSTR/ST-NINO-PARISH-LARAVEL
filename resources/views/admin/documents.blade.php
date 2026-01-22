@extends('components.default')

@section('title', 'Document Manager | Santo Niño Parish Church')

@section('content')

<section class="bg-gray-50 min-h-screen">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">
        <div class="flex flex-col lg:flex-row gap-8">

            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            <div class="lg:w-10/12 w-full">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-gray-900 tracking-tighter uppercase">Document Repository</h1>
                    <p class="text-gray-500 font-medium text-sm mt-1">Centralized view of all submitted requirements from members.</p>
                </div>

                {{-- Document Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($documents as $doc)
                    <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                        {{-- Image Preview --}}
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            <img src="{{ asset('storage/' . $doc->file_path) }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 cursor-pointer"
                                 onclick="showReceipt('{{ asset('storage/' . $doc->file_path) }}')">

                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase text-blue-600 shadow-sm">
                                    {{ $doc->reservation->sacrament->sacrament_type }}
                                </span>
                            </div>
                        </div>

                        {{-- Metadata --}}
                        <div class="p-5">
                            <p class="text-sm font-bold text-gray-900 truncate">
                                {{ $doc->reservation->member->user->firstname }} {{ $doc->reservation->member->user->lastname }}
                            </p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">
                                Submitted: {{ $doc->created_at->format('M d, Y') }}
                            </p>

                            <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" download class="text-gray-400 hover:text-blue-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </a>
                                <button onclick="showReceipt('{{ asset('storage/' . $doc->file_path) }}')" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:underline">
                                    Quick View
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full bg-white rounded-[2rem] p-20 text-center border-2 border-dashed border-gray-100">
                        <p class="text-gray-400 font-medium italic">No documents have been uploaded to the system yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Re-use the Receipt Modal for Quick View --}}
    <div id="receiptModal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm hidden items-center justify-center z-[100] p-4">
        <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-4xl shadow-2xl animate-in zoom-in duration-200">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-black uppercase tracking-tighter">Document Viewer</h2>
                <button onclick="closeReceiptModal()" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <img id="receiptImage" class="w-full max-h-[70vh] object-contain rounded-2xl shadow-inner border">
        </div>
    </div>

</section>
@endsection

@push('scripts')
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
@endpush
