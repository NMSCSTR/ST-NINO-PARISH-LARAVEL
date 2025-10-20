@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section>
<div class="min-h-screen pt-24">
    @include('components.admin.bg')
    {{-- Include Top Navigation --}}
    @include('components.admin.topnav')


    <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

        {{-- Include Sidebar --}}
        <div class="lg:w-2/12 w-full">
            @include('components.admin.sidebar')
        </div>

        {{-- Main Content --}}
        <div class="lg:w-10/12 w-full">
            <div class="flex flex-col lg:flex-row gap-4" data-aos="zoom-in">
                <div class="bg-red-200 border border-red-300 rounded-xl p-6 flex-1 bg-no-repeat"
                    style="background-image: url(...); background-position: 90% center;">
                    <p class="text-4xl text-indigo-900">Welcome <br><strong>Lorem Ipsum</strong></p>
                    <span class="bg-red-300 text-lg text-white inline-block rounded-full mt-6 px-6 py-1"><strong>01:51</strong></span>
                </div>
                <div class="bg-orange-200 border border-orange-300 rounded-xl p-6 flex-1 bg-no-repeat"
                    style="background-image: url(...); background-position: 100% 40%;">
                    <p class="text-4xl text-indigo-900">Inbox <br><strong>23</strong></p>
                    <a href="#"
                        class="bg-orange-300 text-lg text-white underline hover:no-underline inline-block rounded-full mt-6 px-6 py-1"><strong>See messages</strong></a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <div class="bg-white rounded-xl shadow-lg px-6 py-4">a</div>
                <div class="bg-white rounded-xl shadow-lg px-6 py-4">b</div>
                <div class="bg-white rounded-xl shadow-lg px-6 py-4">c</div>
            </div>
        </div>
    </div>
</div>
</section>


@endsection
