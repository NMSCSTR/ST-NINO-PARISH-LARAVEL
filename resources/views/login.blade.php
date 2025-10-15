@extends('components.default')

@section('title', 'Login | Santo Niño Parish Church')

@section('content')
<section class="relative flex items-center justify-center min-h-screen bg-gradient-to-br text-[#2c1c0f] overflow-hidden">

    <!-- 🪟 Background Image -->
    <div class="absolute inset-0 bg-[url('https://t4.ftcdn.net/jpg/04/89/89/53/360_F_489895355_Z4Hb6t1lSLT0zo66l5uWDnfmUGwdlkP4.jpg')] bg-cover bg-center opacity-8 mix-blend-overlay z-0"></div>

    <!-- ✨ Veil -->
    <div class="absolute inset-0 bg-white/20 backdrop-blur-sm z-1"></div>

    <!-- 🔐 Login Form -->
    <div class="relative z-10 w-full max-w-md mx-auto p-8 bg-white/80 rounded-xl shadow-lg border border-[#d4af37] animate-fade-in">
        <div class="text-center mb-6">
            <img src="https://pbs.twimg.com/profile_images/1018602821086691328/ZB3pi7f9_400x400.jpg"
                 alt="Santo Niño Logo"
                 class="w-24 h-24 mx-auto rounded-full mb-4">
            <h2 class="text-2xl font-bold text-[#6b4226]">Welcome Back</h2>
            <p class="text-sm text-[#4b3b2a]">Please login to your account</p>
        </div>

        <form method="POST" action="#" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-[#4b3b2a]">Email Address</label>
                <input type="email" id="email" name="email" required autofocus
                       class="w-full px-4 py-2 mt-1 border rounded-lg bg-white/70 focus:outline-none focus:ring-2 focus:ring-[#d4af37] focus:border-transparent">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-[#4b3b2a]">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-2 mt-1 border rounded-lg bg-white/70 focus:outline-none focus:ring-2 focus:ring-[#d4af37] focus:border-transparent">
            </div>

            <!-- Remember Me & Forgot -->
            <div class="flex items-center justify-between text-sm text-[#4b3b2a]">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-[#d4af37]">
                    <span class="ml-2">Remember me</span>
                </label>
                {{-- <a href="{{ route('password.request') }}" class="text-[#8b5e3c] hover:underline">Forgot password?</a> --}}
            </div>

            <!-- Login Button -->
            <button type="submit"
                    class="w-full py-3 px-4 bg-gradient-to-r from-[#d4af37] to-[#8b5e3c] text-white font-semibold rounded-lg shadow hover:shadow-xl hover:from-[#c9a137] hover:to-[#77492e] transition-all duration-300">
                Login
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-[#4b3b2a]">
            Don't have an account?
            {{-- <a href="{{ route('register') }}" class="text-[#8b5e3c] font-semibold hover:underline">Register</a> --}}
        </p>
    </div>
</section>

<!-- 🌀 Animation -->
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
</style>
@endsection
