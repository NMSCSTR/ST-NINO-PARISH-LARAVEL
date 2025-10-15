@extends('components.default')

@section('title', 'Santo Niño Parish Church')

@section('content')
<section class="relative flex items-center justify-center min-h-screen bg-gradient-to-br text-[#2c1c0f] overflow-hidden">

    <!-- 🪟 Stained Glass Background -->
    <div class="absolute inset-0 bg-[url('https://t4.ftcdn.net/jpg/04/89/89/53/360_F_489895355_Z4Hb6t1lSLT0zo66l5uWDnfmUGwdlkP4.jpg')] bg-cover bg-center opacity-8 mix-blend-overlay z-0"></div>

    <!-- ✨ Soft Veil Overlay -->
    <div class="absolute inset-0 bg-white/20 backdrop-blur-sm z-1"></div>

    <!-- 💬 Main Content -->
    <div class="relative z-10 grid w-full max-w-7xl px-6 py-12 mx-auto gap-12 lg:grid-cols-12 lg:py-20 items-center">

        <!-- 🧭 Left: Text and Features -->
        <div class="lg:col-span-7 flex flex-col justify-center items-start space-y-6 text-left animate-fade-in">
            <h1 class="text-3xl sm:text-4xl md:text-5xl xl:text-6xl font-extrabold tracking-tight leading-tight max-w-2xl text-[#6b4226]">
                Welcome to <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#8b5e3c] drop-shadow-lg">
                    Santo Niño Parish Church
                </span>
            </h1>

            <div class="max-w-2xl space-y-3 text-[#4b3b2a] text-sm sm:text-base lg:text-lg delay-150 animate-fade-in bg-white/70 backdrop-blur-sm p-5 rounded-lg shadow-md">
                <p class="font-medium">Our parish system supports the community with:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-1 list-disc list-inside text-sm sm:text-base">
                    <li>User login</li>
                    <li>Record management (baptisms and weddings)</li>
                    <li>Event scheduling</li>
                    <li>Searchable archives</li>
                    <li>Report generation</li>
                    <li>Certificate printing</li>
                    <li>Reservation handling</li>
                    <li>Document management</li>
                    <li>Monthly events</li>
                    <li>GCash payments</li>
                    <li>SMS notifications</li>
                    <li>Support for religious services</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 delay-300 animate-fade-in">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center px-6 py-3 text-sm sm:text-base font-semibold bg-gradient-to-r from-[#d4af37] to-[#8b5e3c] text-white rounded-lg shadow-lg hover:from-[#c9a137] hover:to-[#77492e] hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    Login to System
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                              clip-rule="evenodd">
                        </path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 🎨 Right: Logo -->
        <div class="lg:col-span-5 flex justify-center items-center animate-fade-in delay-500">
            <div class="p-4 sm:p-6 bg-white/80 rounded-2xl shadow-lg border border-[#d4af37] w-full max-w-xs sm:max-w-md">
                <img src="https://pbs.twimg.com/profile_images/1018602821086691328/ZB3pi7f9_400x400.jpg"
                     alt="Santo Niño Logo"
                     class="w-full max-h-[320px] sm:max-h-[400px] object-contain rounded-xl">
            </div>
        </div>
    </div>
</section>

<!-- 🌀 Animation Styles -->
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.9s ease forwards;
        opacity: 0;
    }

    .delay-150 {
        animation-delay: 0.15s;
    }

    .delay-300 {
        animation-delay: 0.3s;
    }

    .delay-500 {
        animation-delay: 0.5s;
    }
</style>
@endsection
