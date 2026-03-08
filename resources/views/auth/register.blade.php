<x-guest-layout>
    <div class="w-full max-w-md space-y-8 animate-fade-in-up">
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-black text-white tracking-tight leading-none italic">
                Edu<span class="text-indigo-400">Attend</span>
            </h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] pt-1">New Member Onboarding</p>
        </div>

        <!-- Register Card -->
        <div class="glass-card p-10 rounded-[40px] border-white/5 shadow-2xl relative overflow-hidden">
             <!-- Orb Background -->
             <div class="absolute bottom-0 right-0 -mr-16 -mb-16 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full"></div>

            <div class="relative space-y-8">
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Register</h3>
                    <p class="text-slate-400 text-xs font-medium mt-1">Gabung untuk presensi yang lebih pintar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Nama Lengkap</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" 
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <!-- Serial Number -->
                    <div class="space-y-2">
                        <label for="serial_number" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Serial ID (NIP/NIS)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </div>
                            <input id="serial_number" type="text" name="serial_number" :value="old('serial_number')" required placeholder="No. Induk Siswa" 
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                        <x-input-error :messages="$errors->get('serial_number')" class="mt-1" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 ml-1">Confirm Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" 
                                class="block w-full pl-14 pr-6 py-4 bg-white/5 border border-white/5 rounded-2xl focus:bg-white/10 focus:border-indigo-500/50 focus:ring-0 transition-all duration-300 font-bold text-white placeholder:text-slate-600 shadow-inner" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <div class="pt-6 space-y-6">
                        <button type="submit" class="btn-premium w-full py-5 text-sm uppercase tracking-[0.2em] shadow-emerald-500/10">
                            Create Account
                        </button>
                        
                        <p class="text-center text-slate-500 font-bold text-[10px] uppercase tracking-[0.2em]">
                            Already registered? 
                            <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 transition-colors ml-1">Sign In instead</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
