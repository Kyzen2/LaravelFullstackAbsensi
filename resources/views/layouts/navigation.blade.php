<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 sm:hidden z-50">
    <div class="flex items-center justify-between px-6 h-16">

        <!-- Home -->
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center text-xs font-medium flex-1
           {{ request()->routeIs('dashboard*') || request()->routeIs('teacher.dashboard') || request()->routeIs('student.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z" />
            </svg>
            Home
        </a>

        @if(auth()->user()->isSiswa())
        <!-- Scan -->
        <a href="{{ route('student.scan') }}"
            class="flex flex-col items-center text-xs font-medium flex-1
           {{ request()->routeIs('student.scan') ? 'text-indigo-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 8h2V6h2M5 16h2v2h2M17 8h2V6h-2M17 16h2v2h-2M9 12h6" />
            </svg>
            Scan
        </a>

        <!-- History -->
        <a href="{{ route('student.history') }}"
            class="flex flex-col items-center text-xs font-medium flex-1
           {{ request()->routeIs('student.history') ? 'text-indigo-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            History
        </a>
        @endif

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center text-xs font-medium flex-1
           {{ request()->routeIs('profile*') ? 'text-indigo-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profile
        </a>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit" class="flex flex-col items-center w-full text-xs font-medium text-gray-400 hover:text-red-500 transition-colors">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>

    </div>
</nav>