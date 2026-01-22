@extends('components.default')

@section('title', 'GSK Certification')

@section('content')
<section class="pt-24 px-6">
    @include('components.member.topnav')

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-2/12">
            @include('components.member.sidebar')
        </div>

        <div class="lg:w-10/12">
            <div class="max-w-4xl mx-auto p-12 bg-white border border-gray-300 shadow-lg font-serif text-gray-900 mb-10">

                <div class="text-center mb-6 relative">
                    <div class="flex justify-between items-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-[8px] uppercase">Left Logo</div>
                        <div class="text-center">
                            <p class="text-[12px] uppercase leading-tight">Archdiocese of Ozamis</p>
                            <h1 class="text-2xl font-bold tracking-tighter">SANTO NIÑO PARISH</h1>
                            <p class="text-[11px]">Santa Maria, Tangub City 7214</p>
                            <p class="text-[11px]">Misamis Occidental, Philippines</p>
                        </div>
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center text-[8px] uppercase">Right Logo</div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black italic tracking-[0.2em] mb-1">GSK CERTIFICATION</h2>
                    <p class="text-sm font-bold uppercase">(ALANG SA KASLONON)</p>
                </div>

                <div class="space-y-4 leading-relaxed text-sm lg:text-base">
                    <p class="text-justify">
                        Kini nagapamatuod nga si <span class="border-b border-black inline-block min-w-[300px] px-2 font-bold uppercase text-center">Juan Dela Cruz</span> lumolopyo sa
                        <span class="border-b border-black inline-block min-w-[200px] px-2 text-center">Poblacion, Tangub City</span>, narehistro opisyal isip sakop sa Gagmay'ng Simbahang Katilingban (GSK) sa kapilya ni
                        <span class="border-b border-black inline-block min-w-[200px] px-2 text-center">San Vicente</span> pinaagi sa Census nga gihimo sa atong parokya ug sa pagtambong sa GSK seminar nga gihimo sa kapilya niadtong <span class="border-b border-black px-4">January 20, 20</span> <span class="border-b border-black px-2">26</span>.
                    </p>

                    <div class="flex flex-wrap gap-4 items-center">
                        <span>Nga siya [ ]ulitawo [ ]dalaga [ ]minyo [ ]balo</span>
                        <span class="text-xs italic text-red-500">(palihog sa pag check ug usa lamang)</span>
                    </div>

                    <div class="space-y-1">
                        <p>Ug nga [ ]walay kabilinggan sa pagdawat sa sakramento sa kaminyoon</p>
                        <p class="flex items-center gap-2">
                            [ ]adunay kabilinggan nga mao ang <span class="border-b border-black flex-1 min-h-[20px]"></span>
                        </p>
                        <p>Siya nabunyagan sa tuig <span class="border-b border-black px-4">2010</span> sa simbahang katoliko <span class="border-b border-black px-4">YES</span> wala nabunyagi.</p>
                    </div>

                    <div class="mt-6 border border-gray-200 p-4 rounded-sm">
                        <p class="italic text-xs text-red-600 mb-4 leading-tight">
                            Kini usab nagapatuod nga siya maantigong mangadye sa (palihog pag check kon siya mahibalo mangadye...)
                        </p>

                        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                            <div class="flex items-center gap-2">[ ] 1. Amahan Namo</div>
                            <div class="flex items-center gap-2">[ ] 4. Maghimaya ka Hari</div>
                            <div class="flex items-center gap-2">[ ] 2. Maghimaya Ka Maria</div>
                            <div class="flex items-center gap-2">[ ] 5. Nagatoo Ako</div>
                            <div class="flex items-center gap-2">[ ] 3. Ginoo kong Jesukristo</div>
                            <div class="flex items-center gap-2">[ ] 6. Santos nga Rosaryo</div>
                        </div>

                        <p class="mt-4 font-bold">Ug nga siya mahibalo usab sa:</p>
                        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm mt-2">
                            <div class="flex items-center gap-2">[ ] 1. Pagkompisal</div>
                            <div class="flex items-center gap-2">[ ] 3. Mga pagtulun-an sa Simbahan</div>
                            <div class="flex items-center gap-2">[ ] 2. 10 ka sugo sa Dios</div>
                            <div class="flex items-center gap-2">[ ] 4. 7 ka Sakramento</div>
                        </div>
                    </div>

                    <p class="pt-6">
                        Kini nga certification gihatag tungod sa paghangyo sa nahitungdan ning ika <span class="border-b border-black px-4">23</span> nga adlaw sa bulan sa <span class="border-b border-black px-6">January</span> sa tuig 20<span class="border-b border-black px-2">26</span> alang sa katuyuan nga siya magpakasal.
                    </p>
                </div>

                <div class="mt-16 text-[10px] lg:text-xs uppercase font-bold">
                    <p class="mb-10 italic text-red-600 normal-case font-normal text-sm">GIPAMATUD-AN NILA NI: (signature over printed name)</p>

                    <div class="grid grid-cols-3 gap-y-12 gap-x-8 text-center">
                        <div class="border-t border-black pt-1">Chapel Coordinator</div>
                        <div class="border-t border-black pt-1">PPC Moderator</div>
                        <div class="border-t border-black pt-1 leading-tight">Chapel Vice-Coordinator<br><span class="text-[9px] font-normal lowercase">for Pastoral Programs</span></div>

                        <div class="border-t border-black pt-1">GSK Leader</div>
                        <div class="pt-1"></div>
                        <div class="border-t border-black pt-1">Chapel Lay Minister</div>

                        <div class="border-t border-black pt-1">Katekista</div>
                        <div class="pt-4">
                            <div class="border-t border-black w-full mx-auto mb-1"></div>
                            <span class="block">Approved: Kura Paroko</span>
                        </div>
                        <div class="border-t border-black pt-1">Chapel Secretary</div>
                    </div>
                </div>
            </div> </div>
    </div>
</section>
@endsection

@push('scripts')
@include('components.alerts')
@endpush
