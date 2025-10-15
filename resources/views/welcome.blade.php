@extends('components.default')

@section('title', 'Santo Niño Parish Church')

@section('content')
<section
    class="relative flex items-center justify-center min-h-screen bg-gradient-to-br from-[#f9f6f0] to-[#f2e8dc] text-[#2c1c0f] overflow-hidden">

    <!-- 🪟 Background Image -->
    <div
        class="absolute inset-0 bg-[url('https://t4.ftcdn.net/jpg/04/89/89/53/360_F_489895355_Z4Hb6t1lSLT0zo66l5uWDnfmUGwdlkP4.jpg')] bg-cover bg-center opacity-60  z-0">
    </div>

    <!-- ✨ Soft Veil -->
    <div class="absolute inset-0 bg-white/40 backdrop-blur-[6px] z-1"></div>

    <!-- 💬 Main Grid -->
    <div class="relative z-10 grid w-full max-w-7xl px-6 py-16 mx-auto gap-12 lg:grid-cols-12 items-center">

        <!-- 🧭 Left: Text & Features -->
        <div class="lg:col-span-7 flex flex-col justify-center space-y-8 text-left animate-fade-in">
            <h1
                class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight max-w-2xl text-[#5e3d2c]">
                Welcome to <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#d4af37] to-[#8b5e3c] drop-shadow-lg">
                    Santo Niño Parish Church
                </span>
            </h1>

                <blockquote
                    class="text-center text-lg sm:text-xl font-semibold italic text-[#5e3d2c] leading-relaxed px-4 py-6 bg-white/60 backdrop-blur-md rounded-xl shadow-inner border-l-4 border-[#d4af37]">
                    “For where two or three gather in my name, there am I with them.”
                    <span class="block mt-2 text-sm font-normal text-[#6b4226]">— Matthew 18:20 (NIV)</span>
                </blockquote>


            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold bg-gradient-to-r from-[#d4af37] to-[#8b5e3c] text-white rounded-xl shadow-lg hover:from-[#c9a137] hover:to-[#77492e] hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                    Login to System
                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-6 py-3 text-base font-semibold text-[#6b4226] bg-white border border-[#d4af37] rounded-xl shadow hover:bg-[#fdf6e3] hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                    Create Account
                </a>
            </div>
        </div>

        <!-- 🎨 Right: Logo -->
        <div class="lg:col-span-5 flex justify-center items-center animate-fade-in delay-500">
            <div
                class="p-5 sm:p-6 bg-white/70 backdrop-blur-lg rounded-3xl shadow-xl border border-[#d4af37] w-full max-w-xs sm:max-w-sm transition-transform duration-300 hover:scale-105">
                <img src="https://pbs.twimg.com/profile_images/1018602821086691328/ZB3pi7f9_400x400.jpg"
                    alt="Santo Niño Logo" class="w-full object-contain rounded-2xl shadow-inner">
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

    .delay-500 {
        animation-delay: 0.5s;
    }
</style>
@endsection
