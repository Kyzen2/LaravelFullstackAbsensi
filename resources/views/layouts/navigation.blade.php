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
        </a>

        <!-- History -->
        <a href="{{ route('student.history') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('student.history') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>

        <!-- Laporan Performa -->
        <a href="{{ route('student.assessments.index') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('student.assessments*') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
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

        <!-- Teacher Assessment (Nilai) -->
        <a href="{{ route('teacher.assessments.index') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->is('teacher/assessments*') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
        </a>

        <!-- Teacher Reports (Cetak) -->
        <a href="{{ route('teacher.reports.index') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('teacher.reports*') 
               ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 shadow-lg shadow-indigo-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </a>
        @endif

        <!-- Helpdesk Terpadu -->
        <a href="{{ route('helpdesk.index') }}"
            class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl transition-all duration-300
            {{ request()->routeIs('helpdesk*') 
               ? 'bg-rose-500/20 text-rose-400 border border-rose-500/20 shadow-lg shadow-rose-500/10' 
               : 'text-slate-400 hover:text-white' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"></path>
            </svg>
        </a>

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