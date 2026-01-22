@extends('components.default')

@section('title', 'Print GSK Certification')

@section('content')
<style>
    /* This CSS ensures that when printing, only the certificate is visible */
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-area, #printable-area * {
            visibility: visible;
        }
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            shadow: none;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<section class="pt-24 px-6">
    <div class="no-print">
        @include('components.member.topnav')
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-2/12 no-print">
            @include('components.member.sidebar')
        </div>

        <div class="lg:w-10/12">
            <div class="flex justify-end mb-4 no-print">
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Certification
                </button>
            </div>

            <div id="printable-area" class="max-w-4xl mx-auto p-12 bg-white border border-gray-300 shadow-lg font-serif text-gray-900 mb-10 min-h-[1050px]">

                <div class="text-center mb-6">
                    <div class="flex justify-between items-center">
                        <div class="w-20 h-20 flex items-center justify-center">
                            <img src="/path-to-left-logo.png" alt="" class="max-h-full">
                        </div>
                        <div class="text-center">
                            <p class="text-[12px] uppercase leading-tight">Archdiocese of Ozamis</p>
                            <h1 class="text-2xl font-bold tracking-tighter">SANTO NIÑO PARISH</h1>
                            <p class="text-[11px]">Santa Maria, Tangub City 7214</p>
                            <p class="text-[11px]">Misamis Occidental, Philippines</p>
                        </div>
                        <div class="w-20 h-20 flex items-center justify-center">
                             <img src="/path-to-right-logo.png" alt="" class="max-h-full">
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black italic tracking-[0.2em] mb-1">GSK CERTIFICATION</h2>
                    <p class="text-sm font-bold uppercase">(ALANG SA KASLONON)</p>
                </div>

                <div class="space-y-6 leading-[2.5] text-base">
                    <p class="text-justify">
                        Kini nagapamatuod nga si <span class="border-b border-black inline-block min-w-[350px]"></span> lumolopyo sa
                        <span class="border-b border-black inline-block min-w-[250px]"></span>, narehistro opisyal isip sakop sa Gagmay'ng Simbahang Katilingban (GSK) sa kapilya ni
                        <span class="border-b border-black inline-block min-w-[200px]"></span> pinaagi sa Census nga gihimo sa atong parokya ug sa pagtambong sa GSK seminar nga gihimo sa kapilya niadtong <span class="border-b border-black min-w-[150px] inline-block"></span> 20<span class="border-b border-black w-8 inline-block"></span>.
                    </p>

                    <div class="flex flex-wrap gap-4 items-center">
                        <span>Nga siya [ ]ulitawo &nbsp; [ ]dalaga &nbsp; [ ]minyo &nbsp; [ ]balo</span>
                        <span class="text-xs italic text-gray-500">(palihog sa pag check ug usa lamang)</span>
                    </div>

                    <div class="space-y-1">
                        <p>Ug nga [ ] walay kabilinggan sa pagdawat sa sakramento sa kaminyoon</p>
                        <p class="flex items-center gap-2 leading-none">
                            [ ] adunay kabilinggan nga mao ang <span class="border-b border-black flex-1 min-h-[1.5rem]"></span>
                        </p>
                        <p>Siya nabunyagan sa tuig <span class="border-b border-black min-w-[80px] inline-block"></span> sa simbahang katoliko <span class="border-b border-black min-w-[80px] inline-block"></span> wala nabunyagi.</p>
                    </div>

                    <div class="mt-6 border border-gray-400 p-6">
                        <p class="italic text-[11px] mb-4 leading-tight">
                            Kini usab nagapatuod nga siya maantigong mangadye sa <span class="text-gray-500">(palihog pag check kon siya mahibalo mangadye...)</span>
                        </p>

                        <div class="grid grid-cols-2 gap-x-12 gap-y-2 text-sm">
                            <div class="flex items-center gap-2">[ ] 1. Amahan Namo</div>
                            <div class="flex items-center gap-2">[ ] 4. Maghimaya ka Hari</div>
                            <div class="flex items-center gap-2">[ ] 2. Maghimaya Ka Maria</div>
                            <div class="flex items-center gap-2">[ ] 5. Nagatoo Ako</div>
                            <div class="flex items-center gap-2">[ ] 3. Ginoo kong Jesukristo</div>
                            <div class="flex items-center gap-2">[ ] 6. Santos nga Rosaryo</div>
                        </div>

                        <p class="mt-6 font-bold uppercase text-xs">Ug nga siya mahibalo usab sa:</p>
                        <div class="grid grid-cols-2 gap-x-12 gap-y-2 text-sm mt-2">
                            <div class="flex items-center gap-2">[ ] 1. Pagkompisal</div>
                            <div class="flex items-center gap-2">[ ] 3. Mga pagtulun-an sa Simbahan</div>
                            <div class="flex items-center gap-2">[ ] 2. 10 ka sugo sa Dios</div>
                            <div class="flex items-center gap-2">[ ] 4. 7 ka Sakramento</div>
                        </div>
                    </div>

                    <p class="pt-6">
                        Kini nga certification gihatag tungod sa paghangyo sa nahitungdan ning ika <span class="border-b border-black min-w-[40px] inline-block text-center"></span> nga adlaw sa bulan sa <span class="border-b border-black min-w-[120px] inline-block"></span> sa tuig 20<span class="border-b border-black min-w-[30px] inline-block"></span> alang sa katuyuan nga siya magpakasal.
                    </p>
                </div>

                <div class="mt-20 text-[10px] uppercase font-bold">
                    <p class="mb-12 italic text-gray-700 normal-case font-normal text-xs uppercase">GIPAMATUD-AN NILA NI: <span class="text-[9px] lowercase">(signature over printed name)</span></p>

                    <div class="grid grid-cols-3 gap-y-16 gap-x-10 text-center">
                        <div class="border-t border-black pt-1">Chapel Coordinator</div>
                        <div class="border-t border-black pt-1">PPC Moderator</div>
                        <div class="border-t border-black pt-1 leading-tight">Chapel Vice-Coordinator<br><span class="text-[9px] font-normal lowercase">for Pastoral Programs</span></div>

                        <div class="border-t border-black pt-1">GSK Leader</div>
                        <div class="pt-1"></div>
                        <div class="border-t border-black pt-1">Chapel Lay Minister</div>

                        <div class="border-t border-black pt-1">Katekista</div>
                        <div class="pt-4">
                            <div class="border-t border-black w-3/4 mx-auto mb-1"></div>
                            <span class="block">Approved: Kura Paroko</span>
                        </div>
                        <div class="border-t border-black pt-1">Chapel Secretary</div>
                    </div>
                </div>
            </div> </div>
    </div>
</section>
@endsection
