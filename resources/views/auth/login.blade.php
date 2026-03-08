<x-guest-layout>
    <div class="w-full max-w-md space-y-8 animate-fade-in-up">
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-[2rem] glass-card border-indigo-500/20 mb-4 shadow-indigo-500/10">
                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-5.19 4.59-9.364 9.545-9.364 1.257 0 2.459.261 3.553.719m-3.9 10.43a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tight leading-none italic">
                Edu<span class="text-indigo-400">Attend</span>
            </h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] pt-1">Premium Portal Experience</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card p-10 rounded-[40px] border-white/5 shadow-2xl relative overflow-hidden">
             <!-- Orb Background -->
             <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-indigo-500/10 blur-3xl rounded-full"></div>

            <div class="relative space-y-8">
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Login</h3>
                    <p class="text-slate-400 text-xs font-medium mt-1">Sapa harimu dengan kedisiplinan.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Serial Number -->
                    <div class="space-y-3">
                        <label for="serial_number" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Serial ID (NIP/NIS)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="serial_number" type="text" name="serial_number" :value="old('serial_number')" required autofocus placeholder="Masukkan No. Induk" 
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="space-y-3">
                        <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded-[4px] border-white/10 bg-white/5 text-indigo-500 focus:ring-0 focus:ring-offset-0 transition-colors cursor-pointer" name="remember">
                            <span class="ml-2 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-400 transition-colors">Tetap Masuk</span>
                        </label>
                    </div>

                    <div class="pt-4 space-y-6">
                        <button type="submit" class="btn-premium w-full py-5 text-sm uppercase tracking-[0.2em]">
                            Sign In
                        </button>
                        
                        <p class="text-center text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em]">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors ml-1">Join the future</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Admin Contact -->
        <div class="text-center space-y-6">
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.3em] opacity-40">
                &bull; &bull; &bull;
            </p>
            <p class="text-slate-400 text-[9px] font-black uppercase tracking-[0.2em]">
                Trouble logging in? <a href="#" class="text-indigo-400/80 hover:text-indigo-400 transition-colors border-b border-indigo-500/20 pb-0.5">Reach Out Support</a>
            </p>
        </div>
    </div>
</x-guest-layout>
