@extends('components.default')

@section('title', 'My Profile')

@section('content')
<section class="pt-24 pb-12 px-4 md:px-10 bg-gray-50 min-h-screen">
    @include('components.member.topnav')

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-2/12 w-full">
            @include('components.member.sidebar')
        </div>

        <div class="lg:w-10/12 w-full space-y-8">

            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                        <h2 class="text-3xl font-black text-gray-800 flex items-center gap-3">
                            <span class="material-icons-outlined text-blue-600 bg-blue-50 p-2 rounded-xl">person</span>
                            My Profile
                        </h2>

                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span> Active Account
                        </span>
                    </div>

                    <div class="flex items-start gap-4 bg-amber-50 border-l-4 border-amber-400 p-5 rounded-r-xl mb-8">
                        <span class="material-icons text-amber-500">priority_high</span>
                        <div>
                            <p class="text-sm font-bold text-amber-900 leading-tight">Attention Required</p>
                            <p class="text-xs text-amber-700 mt-1">Please ensure your personal details are complete and up-to-date for accurate sacrament documentation and parish records.</p>
                        </div>
                    </div>

                    <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-8">
                        @csrf

                        <div class="relative">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-gray-100"></div>
                            </div>
                            <div class="relative flex justify-start">
                                <span class="bg-white pr-4 text-sm font-bold text-gray-400 uppercase tracking-widest">Personal Information</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                            @php
                                $inputClasses = "mt-1.5 block w-full px-4 py-2.5 rounded-xl border-gray-200 bg-gray-50/50 text-gray-700 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all duration-200 shadow-sm sm:text-sm";
                                $labelClasses = "block text-xs font-black text-gray-500 uppercase tracking-wider ml-1";
                            @endphp

                            <div>
                                <label class="{{ $labelClasses }}">First Name</label>
                                <input type="text" name="firstname" value="{{ $user->firstname ?? '' }}" class="{{ $inputClasses }}" required>
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Last Name</label>
                                <input type="text" name="lastname" value="{{ $user->lastname ?? '' }}" class="{{ $inputClasses }}" required>
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ $member->middle_name ?? '' }}" class="{{ $inputClasses }}">
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Phone Number</label>
                                <input type="text" name="phone_number" value="{{ $user->phone_number ?? '' }}" class="{{ $inputClasses }}">
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Birth Date</label>
                                <input type="date" name="birth_date" value="{{ $member->birth_date ?? '' }}" class="{{ $inputClasses }}">
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Place of Birth</label>
                                <input type="text" name="place_of_birth" value="{{ $member->place_of_birth ?? '' }}" class="{{ $inputClasses }}">
                            </div>

                            <div class="md:col-span-2 lg:col-span-3">
                                <label class="{{ $labelClasses }}">Home Address</label>
                                <input type="text" name="address" value="{{ $member->address ?? '' }}" class="{{ $inputClasses }}">
                            </div>

                        </div>

                        <div class="pt-4">
                            <button class="flex items-center justify-center gap-2 w-full md:w-fit md:px-10 bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-blue-200 active:scale-[0.98]">
                                <span class="material-icons-outlined text-sm">save</span>
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl overflow-hidden transition-all hover:shadow-md">
                <div class="p-6 md:p-8">
                    <h3 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-3">
                        <span class="material-icons-outlined text-red-500 bg-red-50 p-2 rounded-xl">lock</span>
                        Security Settings
                    </h3>

                    <form action="{{ route('member.profile.changePassword') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="{{ $labelClasses }}">Current Password</label>
                                <input type="password" name="current_password" class="{{ $inputClasses }}" required placeholder="••••••••">
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">New Password</label>
                                <input type="password" name="new_password" class="{{ $inputClasses }}" required placeholder="••••••••">
                            </div>

                            <div>
                                <label class="{{ $labelClasses }}">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="{{ $inputClasses }}" required placeholder="••••••••">
                            </div>

                        </div>

                        <div class="pt-4">
                            <button class="flex items-center justify-center gap-2 w-full md:w-fit md:px-10 bg-slate-800 hover:bg-slate-900 text-white py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-slate-200 active:scale-[0.98]">
                                <span class="material-icons-outlined text-sm">sync</span>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
@include('components.alerts')
@endpush
