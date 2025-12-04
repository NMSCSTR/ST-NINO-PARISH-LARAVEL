<div class="fixed top-0 left-0 right-0 bg-white text-blue-800 px-4 lg:px-10 py-4 z-10 shadow-lg">
  <div class="flex items-center justify-between">

    <!-- Logo + Title -->
    <div class="flex items-center space-x-3">
      <img
        src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiLFkl6AqLR7rpJM-jmmf8a6YTXinAhu0_XYTB_wfT7x_qmVRzeeMXS5D0248sAyMfkSaEfCbUoI_UYUuChsdJjcWMP1TSuL_JFSvEWq8jTmHo4Nl7GwJlszGdJktCWi6oHSFgpCz1Xg8TqttFtMMSeCoidgn6iisdiH8oRsZWW4SUNDHfkq7FO2sArww/s1500/Sto.%20Ni%C3%B1o%20Parish%20-%20Tampakan,%20South%20Cotabato%20-%20Logo.jpg"
        alt="Santo Niño Parish Logo"
        class="h-10 w-10 object-contain"
      />
      <div class="font-bold text-blue-900 text-xl leading-tight">
        Priest's <span class="text-orange-600">Dashboard</span>
      </div>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative">
      <button id="profileDropdownBtn" class="flex items-center space-x-2 focus:outline-none">
        <span class="font-medium text-gray-700">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
        <img src="{{ auth()->user()->profile_photo_url ?? 'https://via.placeholder.com/32' }}"
             alt="Profile"
             class="h-8 w-8 rounded-full object-cover">
        <svg class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Dropdown Menu -->
      <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden z-20">
        <a href="{{ route('priest.profile.edit') }}"
           class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-800 flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.31.492 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          Profile
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Logout
          </button>
        </form>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script>
  const profileBtn = document.getElementById('profileDropdownBtn');
  const profileMenu = document.getElementById('profileDropdown');

  profileBtn.addEventListener('click', () => {
    profileMenu.classList.toggle('hidden');
  });

  // Click outside to close dropdown
  window.addEventListener('click', (e) => {
    if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
      profileMenu.classList.add('hidden');
    }
  });
</script>
@endpush
