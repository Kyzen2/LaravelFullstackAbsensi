<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Account Settings
            </h2>
        </div>
    </x-slot>

    <div class="py-10 space-y-10 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <!-- Header Section -->
            <div class="space-y-1 px-2">
                <h1 class="text-3xl font-black text-white tracking-tight">Pengaturan Profil</h1>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] opacity-70 italic">Personalize your identity</p>
            </div>

            <div class="space-y-8">
                <!-- Profile Information Card -->
                <div class="glass-card p-8 rounded-[40px] border-white/5 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 -mr-12 -mt-12 w-32 h-32 bg-indigo-500/5 blur-3xl rounded-full"></div>
                    <div class="max-w-xl relative">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="glass-card p-8 rounded-[40px] border-white/5 shadow-2xl relative overflow-hidden group">
                    <div class="absolute bottom-0 right-0 -mr-12 -mb-12 w-32 h-32 bg-indigo-500/5 blur-3xl rounded-full"></div>
                    <div class="max-w-xl relative">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone Header -->
                <div class="pt-6 px-2 flex items-center gap-3">
                    <div class="h-[1px] flex-1 bg-white/5"></div>
                    <span class="text-[9px] font-black text-rose-500/50 uppercase tracking-[0.4em]">Danger Zone</span>
                    <div class="h-[1px] flex-1 bg-white/5"></div>
                </div>

                <!-- Logout Card -->
                <div class="glass-card p-8 rounded-[40px] border-rose-500/10 bg-rose-500/5 shadow-2xl relative overflow-hidden group">
                    <div class="max-w-xl relative">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-8">
                            <div class="space-y-1">
                                <h3 class="text-lg font-black text-white tracking-tight">Keluar Akun</h3>
                                <p class="text-slate-500 text-xs font-medium opacity-70">Logout dari sesi saat ini untuk keamanan tambahan.</p>
                            </div>

                            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full sm:w-auto px-8 py-4 bg-rose-500/10 text-rose-400 text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all duration-300 shadow-lg shadow-rose-500/10 active:scale-95">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="glass-card p-8 rounded-[40px] border-rose-500/10 bg-transparent shadow-2xl relative overflow-hidden group">
                    <div class="max-w-xl relative opacity-60 hover:opacity-100 transition-opacity">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>