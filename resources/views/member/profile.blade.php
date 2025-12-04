@extends('components.default')

@section('title', 'My Profile')

@section('content')
<section class="pt-24 px-6">
    @include('components.member.topnav')

    <div class="flex flex-col lg:flex-row gap-6">
        <div class="lg:w-2/12">
            @include('components.member.sidebar')
        </div>

        <div class="lg:w-10/12">
            <div class="bg-white shadow-xl rounded-xl p-6">

                <h2 class="text-2xl font-bold mb-6">My Profile</h2>

                <form action="{{ route('member.profile.update') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- FIRST NAME -->
                        <div>
                            <label class="text-sm font-medium">First Name</label>
                            <input type="text" name="firstname" value="{{ $user->firstname }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50" required>
                        </div>

                        <!-- LAST NAME -->
                        <div>
                            <label class="text-sm font-medium">Last Name</label>
                            <input type="text" name="lastname" value="{{ $user->lastname }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50" required>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label class="text-sm font-medium">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                        <!-- MIDDLE NAME -->
                        <div>
                            <label class="text-sm font-medium">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ $member->middle_name }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                        <!-- BIRTHDATE -->
                        <div>
                            <label class="text-sm font-medium">Birth Date</label>
                            <input type="date" name="birth_date" value="{{ $member->birth_date }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                        <!-- PLACE OF BIRTH -->
                        <div>
                            <label class="text-sm font-medium">Place of Birth</label>
                            <input type="text" name="place_of_birth" value="{{ $member->place_of_birth }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                        <!-- ADDRESS -->
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Address</label>
                            <input type="text" name="address" value="{{ $member->address }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                        <!-- CONTACT NUMBER -->
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ $member->contact_number }}"
                                   class="w-full border p-2 rounded-lg bg-gray-50">
                        </div>

                    </div>

                    <button class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
                        Save Changes
                    </button>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
@include('components.alerts')
@endpush
