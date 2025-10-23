@extends('components.default')

@section('title', 'Dashboard | Santo Niño Parish Church')

@section('content')
<section>
    <div class="min-h-screen pt-24">
        {{-- @include('components.admin.bg') --}}
        @include('components.member.topnav')

        <div class="flex flex-col lg:flex-row px-4 lg:px-10 pb-4 gap-6">

            {{-- Include Sidebar --}}
            <div class="lg:w-2/12 w-full">
                @include('components.member.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="lg:w-10/12 w-full">
                
            </div>
        </div>
    </div>
</section>


@endsection
