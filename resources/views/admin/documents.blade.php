@extends('components.default')

@section('title', 'Document Repository | Santo Niño Parish')

@section('content')
<section class="bg-gray-50 min-h-screen">
    @include('components.admin.bg')
    @include('components.admin.topnav')

    <div class="pt-24 px-4 lg:px-10 pb-10">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.admin.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">

                {{-- Dashboard Header --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-black text-gray-900 tracking-tighter uppercase italic">Document Vault</h1>
                        <p class="text-sm text-gray-500 font-medium">Manage and verify all uploaded sacrament requirements.</p>
                    </div>
                    <div class="bg-white px-6 py-3 rounded-2xl border border-gray-100 shadow-sm">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Total Repository</p>
                        <p class="text-xl font-black text-blue-600 leading-none">{{ $documents->count() }} <span class="text-xs text-gray-400">Files</span></p>
                    </div>
                </div>

                {{-- Document Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($documents as $doc)
                        <div class="group bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/30 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">

                            {{-- Image Container --}}
                            <div class="relative h-52 bg-gray-100 overflow-hidden">
                                {{-- We use the asset helper. Ensure 'php artisan storage:link' is active --}}
                                <img src="{{ asset('storage/' . $doc->file_path) }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 cursor-pointer"
                                     onclick="openLightbox('{{ asset('storage/' . $doc->file_path) }}')">

                                {{-- Sacrament Tag --}}
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest text-blue-700 shadow-sm border border-white">
                                        {{ $doc->reservation?->sacrament?->sacrament_type ?? 'Sacrament' }}
                                    </span>
                                </div>

                                {{-- Quick View Overlay --}}
                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                    <span class="bg-white h-10 w-10 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                                    </span>
                                </div>
                            </div>

                            {{-- Card Details --}}
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-black text-gray-900 truncate">
                                            {{ $doc->reservation?->member?->user?->firstname ?? 'Unknown' }}
                                            {{ $doc->reservation?->member?->user?->lastname ?? 'Member' }}
                                        </p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">
                                            ID #{{ $doc->reservation_id ?? 'N/A' }} • {{ $doc->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <div class="h-8 w-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" download class="flex items-center gap-1 text-[10px] font-black text-gray-400 uppercase hover:text-blue-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Download
                                    </a>
                                    <button onclick="openLightbox('{{ asset('storage/' . $doc->file_path) }}')" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">
                                        Review File
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-[3rem] p-24 text-center border-2 border-dashed border-gray-100 shadow-inner">
                            <div class="bg-blue-50 h-20 w-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                                <svg class="w-10 h-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 uppercase">No Data Found</h3>
                            <p class="text-gray-400 text-sm max-w-xs mx-auto mt-2">There are currently no document submissions in the repository.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Modal Viewer --}}
    <div id="lightbox" class="fixed inset-0 bg-gray-900/95 backdrop-blur-sm hidden items-center justify-center z-[100] p-4 transition-all duration-300">
        <div class="relative bg-white rounded-[3rem] p-4 w-full max-w-4xl shadow-2xl animate-in zoom-in duration-300">
            {{-- Top Controls --}}
            <div class="absolute -top-12 left-0 right-0 flex justify-between items-center text-white px-2">
                <span id="lightboxLabel" class="text-xs font-black uppercase tracking-[0.2em] italic">Document Preview</span>
                <button onclick="closeLightbox()" class="flex items-center gap-2 font-black uppercase text-xs hover:text-blue-400 transition">
                    Dismiss <span class="bg-white/10 h-8 w-8 rounded-full flex items-center justify-center text-lg">✕</span>
                </button>
            </div>

            <img id="lightboxImg" class="w-full max-h-[75vh] object-contain rounded-[2rem] shadow-inner border border-gray-50 bg-gray-50">

            {{-- Bottom Hint --}}
            <div class="text-center mt-6 pb-2">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Sacrament Management Platform — Santo Niño Parish Church</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function openLightbox(url) {
        const lightbox = document.getElementById('lightbox');
        document.getElementById('lightboxImg').src = url;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Lock scrolling
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = 'auto'; // Unlock scrolling
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeLightbox();
    });

    // Close on backdrop click
    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });
</script>
@endpush
