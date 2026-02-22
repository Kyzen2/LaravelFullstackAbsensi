<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-6 pb-24">
        <!-- Top Image Section -->
        <div class="w-full max-w-md mb-8">
            <div class="bg-blue-600 h-48 rounded-[2.5rem] relative overflow-hidden shadow-2xl shadow-blue-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-700"></div>
                <!-- Abstract circles -->
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-400/20 rounded-full blur-2xl"></div>
                
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white px-8 text-center">
                    <h2 class="text-3xl font-black tracking-tight mb-2">EduAttend</h2>
                    <p class="text-blue-100 text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Absensi Modern & Terpadu</p>
                </div>
            </div>
        </div>

        <div class="w-full max-w-md bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <div class="mb-8">
                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Login</h3>
                <p class="text-gray-400 text-[10px] font-black mt-1 uppercase tracking-widest leading-none">Silakan masuk ke akun Anda</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Serial Number (NIP/NIS) -->
                <div class="space-y-2">
                    <label for="serial_number" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Serial Number (NIP/NIS)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                        </div>
                        <input id="serial_number" type="text" name="serial_number" :value="old('serial_number')" required autofocus placeholder="Masukkan No. Induk" 
                            class="block w-full pl-12 pr-4 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all duration-200 font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Kata Sandi</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                            class="block w-full pl-12 pr-4 py-4 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all duration-200 font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-[10px] font-black text-gray-500 uppercase">Tetap Masuk</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-[10px] font-black text-blue-600 uppercase tracking-tighter" href="{{ route('password.request') }}">Lupa?</a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-black rounded-2xl shadow-lg shadow-blue-100 transition-all duration-200 uppercase tracking-widest text-xs">
                        Masuk
                    </button>
                    
                    <p class="text-center mt-6 text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline ml-1">Daftar</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
                <div class="text-center mt-8 space-y-4">
                    <p class="text-gray-400 text-xs font-bold">
                        Need help? <a href="#" class="text-blue-600 uppercase tracking-tighter">Contact Administrator</a>
                    </p>
                    <div class="flex items-center justify-center space-x-3 opacity-20">
                        <div class="h-[1px] w-12 bg-gray-400"></div>
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">EduAttend V2.4</span>
                        <div class="h-[1px] w-12 bg-gray-400"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
