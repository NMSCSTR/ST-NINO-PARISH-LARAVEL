<div class="bg-white rounded-xl shadow-lg mb-6 px-6 py-4" data-aos="slide-right">
    <a href="{{ route('admin.dashboard') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">dashboard</span>
            Home
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.users') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.users') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">person</span>
            User
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.reservations') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.reservations') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">event_available</span>
            Reservations
            {{-- <span
                class="inline-flex items-right justify-center w-4 h-4 ms-2 text-xs font-semibold text-gray-100 bg-red-800 rounded-full">
                {{ $reservations->where('status', '=', 'pending')->count() }}
            </span> --}}
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.admin.members') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.members') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">group</span>
            Members
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.events') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.events') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">event</span>
            Events
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.sacraments.index') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.sacraments.*') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">auto_stories</span>
            Sacraments
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>


    <a href="{{ route('admin.payments') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.payments') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">payments</span>
            Payments
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>

    <a href="{{ route('admin.documents') }}"
        class="flex items-center justify-between my-4 {{ request()->routeIs('admin.documents') ? 'text-blue-600 font-bold' : 'text-gray-600 hover:text-black' }}">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">description</span>
            Documents
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>
</div>



<div class="bg-white rounded-xl shadow-lg px-6 py-4" data-aos="slide-right">
    <a href="#" class="flex items-center justify-between text-gray-600 hover:text-black my-4">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">face</span>
            Profile
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>
    <a href="#" class="flex items-center justify-between text-gray-600 hover:text-black my-4">
        <span class="flex items-center">
            <span class="material-icons-outlined pr-2">settings</span>
            Settings
        </span>
        <span class="material-icons-outlined">keyboard_arrow_right</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="button" id="logout-button"
            class="flex items-center justify-between text-gray-600 hover:text-black my-4 bg-transparent border-none p-0 m-0 cursor-pointer">
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
