@extends('components.default')

@section('title', 'Document Repository | Santo Niño')

@section('content')
<section class="bg-gray-50 min-h-screen">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/12 w-full">@include('components.admin.sidebar')</div>

            <div class="lg:w-10/12 w-full">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Document Gallery</h1>
                    <p class="text-sm text-gray-500">Total Files: <span class="font-bold text-blue-600">{{ $documents->count() }}</span></p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($documents as $doc)
                        {{-- Verify data exists before rendering to avoid "Trying to access property of non-object" --}}
                        @if($doc->reservation && $doc->reservation->member)
                        <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                            <div class="relative h-48 bg-gray-200">
                                <img src="{{ asset('storage/' . $doc->file_path) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 cursor-pointer"
                                     onclick="showFullImage('{{ asset('storage/' . $doc->file_path) }}')">

                                <div class="absolute top-4 left-4">
                                    <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest">
                                        {{ $doc->reservation->sacrament->sacrament_type ?? 'Sacrament' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <p class="text-sm font-bold text-gray-900 truncate">
                                    {{ $doc->reservation->member->user->firstname ?? 'Unknown' }}
                                    {{ $doc->reservation->member->user->lastname ?? 'User' }}
                                </p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">
                                    Uploaded: {{ $doc->created_at->format('M d, Y') }}
                                </p>

                                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="p-2 text-gray-400 hover:text-blue-600 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </a>
                                    <button onclick="showFullImage('{{ asset('storage/' . $doc->file_path) }}')" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">
                                        View File
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="col-span-full bg-white rounded-[2.5rem] p-20 text-center border-2 border-dashed border-gray-100">
                            <div class="bg-gray-50 h-16 w-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                            </div>
                            <h3 class="text-gray-900 font-bold">No Documents Found</h3>
                            <p class="text-gray-400 text-sm">Once members upload requirements, they will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="imageModal" class="fixed inset-0 bg-gray-900/90 backdrop-blur-sm hidden items-center justify-center z-[100] p-4 shadow-2xl">
        <div class="relative bg-white rounded-[2.5rem] p-4 w-full max-w-4xl animate-in zoom-in duration-300">
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white flex items-center gap-2 font-bold uppercase text-xs tracking-widest">
                Close Viewer <span class="bg-white/20 h-8 w-8 rounded-full flex items-center justify-center text-lg">✕</span>
            </button>
            <img id="modalImage" class="w-full max-h-[80vh] object-contain rounded-2xl">
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function showFullImage(url) {
        document.getElementById('modalImage').src = url;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
    }

    // Close on clicking the backdrop
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) closeImageModal();
    });
</script>
@endpush
