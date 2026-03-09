<nav class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[92%] max-w-md glass-nav rounded-[32px] sm:hidden z-50 px-2 py-2 shadow-2xl shadow-black/50 border border-white/10">
    <div class="flex items-center justify-around h-14">

        <!-- Beranda -->
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('dashboard*') || request()->routeIs('teacher.dashboard') || request()->routeIs('student.dashboard') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-xs mt-1">Beranda</span>
        </a>

        @if(auth()->user()->isSiswa())
        <!-- Pindai -->
        <a href="{{ route('student.scan') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('student.scan') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
        <!-- History -->
        <a href="{{ route('student.history') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('student.history') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </a>
        @endif

        @if(auth()->user()->isGuru())
        <!-- Teacher Schedule -->
        <a href="{{ route('teacher.schedule') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('teacher.schedule') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </a>

        <!-- Teacher Attendance (Rekap) -->
        <a href="{{ route('teacher.attendance.index') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->is('teacher/attendance*') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2v0a2 2 0 01-2 2H11a2 2 0 01-2-2v0a2 2 0 012-2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </a>
        @endif

        <!-- Profile -->
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('profile*') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>

    </div>
</nav>