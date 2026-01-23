<div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4" data-aos="slide-right">
    <a href="{{ route('member.dashboard') }}"
       class="flex items-center justify-between my-4 {{ request()->routeIs('member.dashboard') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">dashboard</span>
            Home
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>


    <a href="{{ route('member.reservation') }}"
       class="flex items-center justify-between my-4 {{ request()->routeIs('member.reservation') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">event_available</span>
            Reservations
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>


    <a href="{{ route('member.events.page') }}"
       class="flex items-center justify-between my-4 {{ request()->routeIs('member.events.page') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}
">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">event</span>
            Events
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('member.member.payments') }}"
       class="flex items-center justify-between my-4 {{ request()->routeIs('admin.payments') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">payments</span>
            Payments
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('member.gskcert') }}"
    class="flex items-center justify-between my-4 {{ request()->routeIs('member.member.gskcert') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">payments</span>
            Reuirements
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>


</div>



<div class="bg-white rounded-xl shadow-lg px-6 py-4" data-aos="slide-right">
    <a href="{{ route('member.profile') }}" class="flex items-center justify-between my-4 {{ request()->routeIs('member.profile') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">face</span>
            Profile
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="button" id="logout-button"
            class="flex items-center justify-between text-red-600 hover:text-white my-4 bg-transparent border-none p-0 m-0 cursor-pointer">
            <span class="flex items-center">
                <span class="material-icons-outlined pr-2">power_settings_new</span>
                Log out
            </span>
            <span class="material-icons-outlined">keyboard_arrow_right</span>
        </button>
    </form>

    <script>
        document.getElementById('logout-button').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the logout form
                document.getElementById('logout-form').submit();
            }
        });
    });
    </script>


</div>
