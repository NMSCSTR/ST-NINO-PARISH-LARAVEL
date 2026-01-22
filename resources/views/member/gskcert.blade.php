@extends('components.default')

@section('title', 'GSK Certification Generator')

@section('content')
<style>
    /* Printing Logic */
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        /* Show only the printable area and its children */
        #printable-area, #printable-area * {
            visibility: visible;
        }
        /* Position the certificate at the very top-left of the page */
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            border: none;
            box-shadow: none;
        }
        /* Ensure background colors/borders print */
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .no-print {
            display: none !important;
        }
    }

    /* Form styling for blanks */
    .blank-line {
        display: inline-block;
        border-bottom: 1px solid black;
        text-align: center;
        padding: 0 5px;
    }
</style>

<section class="pt-24 px-6" x-data="{ formType: 'kaslonon' }">
    <div class="no-print">
        @include('components.member.topnav')
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-2/12 no-print">
            @include('components.member.sidebar')
        </div>

        <div class="lg:w-10/12">

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 no-print bg-white p-4 rounded-lg shadow-sm border">
                <div class="flex gap-2">
                    <button @click="formType = 'kaslonon'"
                            :class="formType === 'kaslonon' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-md text-sm font-bold transition">
                        Wedding (Kaslonon)
                    </button>
                    <button @click="formType = 'minatay'"
                            :class="formType === 'minatay' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'"
                            class="px-4 py-2 rounded-md text-sm font-bold transition">
                        Deceased (Minatay)
                    </button>
                </div>

                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-md shadow-md flex items-center gap-2 transition font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Now
                </button>
            </div>

            <div id="printable-area" class="max-w-4xl mx-auto p-12 bg-white border border-gray-200 shadow-xl font-serif text-gray-900 min-h-[1050px]">

                <div class="text-center mb-6">
                    <div class="flex justify-between items-center">
                        <div class="w-24 h-24 flex items-center justify-center">
                            <img src="{{ asset('images/stparish.jpg') }}" alt="Santo Niño Parish Logo" class="max-h-full max-w-full object-contain"></div>
                        <div class="text-center">
                            <p class="text-[13px] uppercase tracking-wide leading-tight">Archdiocese of Ozamis</p>
                            <h1 class="text-3xl font-bold tracking-tighter">SANTO NIÑO PARISH</h1>
                            <p class="text-[12px]">Santa Maria, Tangub City 7214</p>
                            <p class="text-[12px]">Misamis Occidental, Philippines</p>
                        </div>
                        <div class="w-24 h-24 flex items-center justify-center">
                            <div class="border-2 border-dashed border-gray-300 rounded-full p-4 text-[10px] text-gray-400 no-print">Archdiocese Logo</div>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-10">
                    <h2 class="text-4xl font-black italic tracking-[0.25em] mb-1">GSK CERTIFICATION</h2>
                    <p class="text-md font-bold uppercase" x-text="formType === 'kaslonon' ? '(ALANG SA KASLONON)' : '(ALANG SA MINATAY)'"></p>
                </div>

                <div class="text-lg leading-[2.8] text-justify space-y-6">

                    <p>
                        Kini nagapamatuod nga <span x-text="formType === 'kaslonon' ? 'si' : 'ang namatay nga si'"></span>
                        <span class="blank-line min-w-[350px]"></span> lumolopyo sa
                        <span class="blank-line min-w-[280px]"></span>,
                        usa ka aktibong sakop sa Simbahang Katilingban (GSK) sa kapilya ni
                        <span class="blank-line min-w-[200px]"></span> pinaagi sa Census nga gihimo sa atong parokya. Siya nakatambong sa GSK Seminar nga gihimo sa kapilya niadtong
                        <span class="blank-line min-w-[150px]"></span>, 20<span class="blank-line min-w-[40px]"></span>.
                    </p>

                    <template x-if="formType === 'kaslonon'">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <span>Nga siya: [ ] ulitawo &nbsp; [ ] dalaga &nbsp; [ ] minyo &nbsp; [ ] balo</span>
                            </div>
                            <p>Ug nga [ ] walay kabilinggan sa pagdawat sa sakramento sa kaminyoon</p>
                            <p class="flex items-center gap-2 leading-none">
                                [ ] adunay kabilinggan nga mao ang <span class="blank-line flex-1 min-h-[1.5rem]"></span>
                            </p>
                            <p>Siya nabunyagan sa tuig <span class="blank-line min-w-[80px]"></span> sa simbahang katoliko <span class="blank-line min-w-[80px]"></span> wala nabunyagi.</p>

                            <div class="mt-4 border border-black p-6 leading-relaxed">
                                <p class="italic text-xs mb-4">Kini usab nagapatuod nga siya maantigong mangadye sa:</p>
                                <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-[15px]">
                                    <div>[ ] 1. Amahan Namo</div><div>[ ] 4. Maghimaya ka Hari</div>
                                    <div>[ ] 2. Maghimaya Ka Maria</div><div>[ ] 5. Nagatoo Ako</div>
                                    <div>[ ] 3. Ginoo kong Jesukristo</div><div>[ ] 6. Santos nga Rosaryo</div>
                                </div>
                                <p class="mt-4 font-bold text-sm uppercase">Ug mahibalo usab sa:</p>
                                <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-[15px]">
                                    <div>[ ] 1. Pagkompisal</div><div>[ ] 3. Pagtulun-an sa Simbahan</div>
                                    <div>[ ] 2. 10 ka sugo sa Dios</div><div>[ ] 4. 7 ka Sakramento</div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="formType === 'minatay'">
                        <div class="space-y-4">
                            <p class="italic text-sm">Kini usab nagapamatuod niining mosunod:</p>
                            <ul class="space-y-2 text-[16px]">
                                <li>[ ] Nga siya nabunyagan sa Simbahang Katoliko.</li>
                                <li>[ ] Nga siya wala mobalhin ug tinuhoan hangtud karon.</li>
                                <li>[ ] Nga siya maalagaron ug nagatambong sa mga kalihukan sa GSK.</li>
                                <li>[ ] Nga siya nagatambong sa mga Kasaulogan sa Domingo sa Kapilya.</li>
                            </ul>
                            <p class="font-bold text-center pt-4 uppercase">Tungod niini, siya angayan nga ilubong sa atong SEMENTERYO KATOLIKO.</p>
                        </div>
                    </template>

                    <p class="pt-4">
                        Kini nga Certification gihatag tungod sa paghangyo sa nahitungdan ning ika <span class="blank-line min-w-[50px]"></span> nga adlaw sa bulan sa <span class="blank-line min-w-[150px]"></span> tuig 20<span class="blank-line min-w-[40px]"></span> alang sa
                        <span x-text="formType === 'kaslonon' ? 'katuyuan nga siya magpakasal.' : 'katuyuan sa paglubong.'"></span>
                    </p>
                </div>

                <div class="mt-20 text-[11px] uppercase font-bold">
                    <p class="mb-14 italic text-red-700 normal-case font-normal text-sm">GIPAMATUD-AN NILA NI: <span class="text-xs lowercase">(signature over printed name)</span></p>

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

@push('scripts')
@include('components.alerts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
