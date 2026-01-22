@extends('components.default')

@section('title', 'GSK Certification Generator')

@section('content')
<style>
    /* Printing Logic: Ensures only the certificate is printed on A4 */
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
            padding: 30px;
            border: none;
            box-shadow: none;
        }
        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            background-color: white;
        }
        .no-print {
            display: none !important;
        }
    }

    /* Styling for the blank fillable lines */
    .blank-line {
        display: inline-block;
        border-bottom: 1px solid black;
        text-align: center;
        padding: 0 5px;
        vertical-align: bottom;
    }

    /* Text justify and line height to match physical forms */
    .form-text {
        line-height: 2.4;
        text-align: justify;
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

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 no-print bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Select Form:</span>
                    <div class="flex p-1 bg-gray-100 rounded-lg flex-wrap">
                        <button @click="formType = 'kaslonon'"
                                :class="formType === 'kaslonon' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 rounded-md text-xs font-bold transition-all">
                            Wedding (Kaslonon)
                        </button>
                        <button @click="formType = 'minatay'"
                                :class="formType === 'minatay' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 rounded-md text-xs font-bold transition-all">
                            Deceased (Minatay)
                        </button>
                        <button @click="formType = 'moral'"
                                :class="formType === 'moral' ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 rounded-md text-xs font-bold transition-all">
                            Good Moral/Baptism
                        </button>
                    </div>
                </div>

                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-md shadow-md flex items-center gap-2 transition font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Certificate
                </button>
            </div>

            <div id="printable-area" class="max-w-4xl mx-auto p-12 bg-white border border-gray-100 shadow-2xl font-serif text-gray-900 min-h-[1050px]">

                <div class="text-center mb-6">
                    <div class="flex justify-between items-center">
                        <div class="w-28 h-28 flex items-center justify-center">
                            <img src="{{ asset('images/stparish.jpg') }}" alt="Santo Niño Parish Logo" class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="text-center">
                            <p class="text-[12px] uppercase leading-tight">Archdiocese of Ozamis</p>
                            <h1 class="text-3xl font-bold tracking-tighter my-1">SANTO NIÑO PARISH</h1>
                            <p class="text-[11px]">Santa Maria, Tangub City 7214</p>
                            <p class="text-[11px]">Misamis Occidental, Philippines</p>
                        </div>
                        <div class="w-28 h-28 flex items-center justify-center">
                           <img src="{{ asset('images/archoz.png') }}" alt="Santo Niño Parish Logo" class="max-h-full max-w-full object-contain">
                        </div>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <h2 class="text-4xl font-black italic tracking-[0.25em] mb-1">GSK CERTIFICATION</h2>
                    <p class="text-sm font-bold uppercase" x-show="formType === 'kaslonon'">(ALANG SA KASLONON)</p>
                    <p class="text-sm font-bold uppercase" x-show="formType === 'minatay'">(ALANG SA MINATAY)</p>
                    <p class="text-sm font-bold uppercase" x-show="formType === 'moral'">(ALANG SA MAGPABUNYAG, KOMPIERMA UG GOOD MORAL)</p>
                </div>

                <div class="form-text text-[17px] space-y-6">

                    <template x-if="formType !== 'moral'">
                        <p>
                            Kini nagapamatuod nga <span x-text="formType === 'kaslonon' ? 'si' : 'ang namatay nga si'"></span>
                            <span class="blank-line min-w-[350px]"></span> lumolopyo sa
                            <span class="blank-line min-w-[280px]"></span>,
                            usa ka aktibong sakop sa Simbahang Katilingban (GSK) sa kapilya ni
                            <span class="blank-line min-w-[200px]"></span> pinaagi sa Census nga gihimo sa atong parokya. Siya nakatambong sa GSK Seminar nga gihimo sa kapilya niadtong
                            <span class="blank-line min-w-[150px]"></span>, 20<span class="blank-line min-w-[40px]"></span>.
                        </p>
                    </template>

                    <template x-if="formType === 'moral'">
                        <div class="space-y-4">
                            <p>
                                Kini nagapamatuod nga si Mr./Mrs. <span class="blank-line min-w-[350px]"></span> lumolopyo sa
                                <span class="blank-line min-w-[280px]"></span> ug sakop sa kapilya ni
                                <span class="blank-line min-w-[200px]"></span>.
                            </p>
                            <p class="italic text-[13px] text-center mb-0">Sila: (palihog pag check kon tinood nga nagabuhat niini)</p>
                            <div class="grid grid-cols-2 gap-x-4 text-[15px] leading-relaxed">
                                <div>[ ] Kinasal sa SIMBAHANG KATOLIKO</div>
                                <div>[ ] Dili kinasal sa SIMBAHANG KATOLIKO</div>
                                <div class="col-span-2 leading-tight py-1">[ ] Nga ilang gipakita [ ] Wala gipakita kanamo ang ilang MARRIAGE CONTRACT / MARRIAGE CERTIFICATE sa kasal sa SIMBAHANG KATOLIKO.</div>
                                <div>[ ] Sakop sa GSK No. <span class="blank-line min-w-[80px]"></span></div>
                                <div>[ ] Wala masakop sa GSK.</div>
                                <div>[ ] Maalagaron ug nagatambong sa GSK sama sa MAAMPUONG TIGUM.</div>
                                <div>[ ] Wala mag apil-apil sa kalihukan sa GSK.</div>
                                <div>[ ] Magtambongan sa kasaulogan sa Domingo.</div>
                                <div>[ ] Wala magtambongan sa kasaulogan sa Domingo.</div>
                                <div>[ ] Aktibo nga sakop dinhi sa among kapilya.</div>
                                <div>[ ] Dili aktibong sakop sa SIMBAHANG KATOLIKO.</div>
                                <div class="col-span-2 pt-2">[ ] Narihistro opisyal [ ] Wala marihistro isip sakop sa GAGMAY'NG SIMBAHANG KATILINGBAN (GSK) sa kapilya ni <span class="blank-line min-w-[150px]"></span> pinaagi sa CENSUS.</div>
                                <div class="col-span-2 pt-2">[ ] Nakatambong [ ] Wala makatambong sa GSK Seminar niadtong <span class="blank-line min-w-[120px]"></span>.</div>
                            </div>
                        </div>
                    </template>

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

                            <div class="mt-4 border-2 border-black p-4 leading-relaxed text-[14px]">
                                <p class="italic text-[11px] mb-2">Kini usab nagapatuod nga siya maantigong mangadye sa:</p>
                                <div class="grid grid-cols-2 gap-x-8 gap-y-1">
                                    <div>[ ] 1. Amahan Namo</div><div>[ ] 4. Maghimaya ka Hari</div>
                                    <div>[ ] 2. Maghimaya Ka Maria</div><div>[ ] 5. Nagatoo Ako</div>
                                    <div>[ ] 3. Ginoo kong Jesukristo</div><div>[ ] 6. Santos nga Rosaryo</div>
                                </div>
                                <p class="mt-3 font-bold uppercase text-[12px]">Ug mahibalo usab sa:</p>
                                <div class="grid grid-cols-2 gap-x-8 gap-y-1">
                                    <div>[ ] 1. Pagkompisal</div><div>[ ] 3. Pagtulun-an sa Simbahan</div>
                                    <div>[ ] 2. 10 ka sugo sa Dios</div><div>[ ] 4. 7 ka Sakramento</div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="formType === 'minatay'">
                        <div class="space-y-4">
                            <p class="italic text-sm">Kini usab nagapamatuod niining mosunod:</p>
                            <ul class="space-y-1 text-[16px] ml-6">
                                <li>[ ] Nga siya nabunyagan sa Simbahang Katoliko.</li>
                                <li>[ ] Nga siya wala mobalhin ug tinuhoan hangtud karon.</li>
                                <li>[ ] Nga siya maalagaron ug nagatambong sa mga kalihukan sa GSK.</li>
                                <li>[ ] Nga siya nagatambong sa mga Kasaulogan sa Domingo sa Kapilya.</li>
                                <li>[ ] Nga siya usa ka Sakop sa Simbahang Katoliko.</li>
                                <li>[ ] Ug wala mag apil-apil sa mga kalihukan sa ubang relihiyon o secta.</li>
                            </ul>
                            <p class="font-bold text-center pt-6 uppercase text-xl">Tungod niini, siya angayan nga ilubong sa atong SEMENTERYO KATOLIKO.</p>
                        </div>
                    </template>

                    <template x-if="formType === 'moral'">
                        <div class="border-2 border-black p-4 mt-4 leading-tight">
                            <p class="font-bold text-sm underline mb-2 tracking-tighter">Kami mga nangatungdanan sa Kapilya:</p>
                            <p class="flex items-start gap-2 text-[15px]">[ ] <span>Nagahangyo nga bunyagan ang ilang Anak.</span></p>
                            <p class="flex items-start gap-2 text-[15px]">[ ] <span>Dili makarekomindar nga bunyagan karon ilang anak tungod sa rason nga atong Makita dinha sa itaas.</span></p>
                        </div>
                    </template>

                    <p class="pt-6">
                        Kini nga Certification gihatag tungod sa paghangyo sa nahitungdan ning ika <span class="blank-line min-w-[50px]"></span> nga adlaw sa bulan sa <span class="blank-line min-w-[150px]"></span> tuig 20<span class="blank-line min-w-[40px]"></span> alang sa
                        <span x-text="formType === 'kaslonon' ? 'katuyuan nga siya magpakasal.' : (formType === 'minatay' ? 'katuyuan sa paglubong.' : 'katuyuan sa: [ ] Magpabunyag o [ ] Magpakompierma sa ilang anak.')"></span>
                    </p>
                </div>

                <div class="mt-20 text-[10px] uppercase font-bold px-4">
                    <p class="mb-14 italic text-gray-800 normal-case font-normal text-xs uppercase">GIPAMATUD-AN NILA NI: <span class="text-[10px] lowercase">(signature over printed name)</span></p>

                    <div class="grid grid-cols-3 gap-y-16 gap-x-12 text-center">
                        <div class="border-t border-black pt-1">Chapel Coordinator</div>
                        <div class="border-t border-black pt-1">PPC Moderator</div>
                        <div class="border-t border-black pt-1 leading-tight">Chapel Vice-Coordinator<br><span class="text-[8px] font-normal lowercase">for Pastoral Programs</span></div>

                        <div class="border-t border-black pt-1">GSK Leader</div>
                        <div class="pt-1"></div>
                        <div class="border-t border-black pt-1">Chapel Lay Minister</div>

                        <div class="border-t border-black pt-1">Katekista</div>
                        <div class="pt-4 flex flex-col items-center">
                            <div class="border-t border-black w-full mb-1"></div>
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
