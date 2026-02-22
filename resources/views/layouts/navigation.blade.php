<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] sm:hidden">
    <!-- Mobile Bottom Navigation -->
    <div class="flex justify-around items-center h-16">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full transition-all duration-200 {{ request()->routeIs('dashboard*') || request()->routeIs('teacher.dashboard') || request()->routeIs('student.dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="text-[10px] font-black uppercase tracking-tighter mt-1">Beranda</span>
        </a>

        @if(auth()->user()->isSiswa())
            <!-- Scan Link (Student Only) -->
            <a href="{{ route('student.scan') }}" class="flex flex-col items-center justify-center w-full transition-all duration-200 {{ request()->routeIs('student.scan') ? 'text-blue-600' : 'text-gray-400' }}">
                <div class="bg-blue-600 p-3 rounded-2xl -mt-8 shadow-lg shadow-blue-200 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-tighter mt-1">Scan</span>
            </a>

            <!-- History Link (Student Only) -->
            <a href="{{ route('student.history') }}" class="flex flex-col items-center justify-center w-full transition-all duration-200 {{ request()->routeIs('student.history') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] font-black uppercase tracking-tighter mt-1">Riwayat</span>
            </a>
        @endif

        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center w-full transition-all duration-200 {{ request()->routeIs('profile*') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="text-[10px] font-black uppercase tracking-tighter mt-1">Profil</span>
        </a>
    </div>
</nav>

<!-- Desktop Navigation (Keep for desktop users) -->
<nav class="bg-white border-b border-gray-100 hidden sm:block">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('teacher.dashboard') || request()->routeIs('student.dashboard') || request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @if(auth()->user()->isSiswa())
                        <x-nav-link :href="route('student.history')" :active="request()->routeIs('student.history')">
                            {{ __('History') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>
            <div class="flex items-center sm:ms-6">
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-gray-500 hover:text-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
