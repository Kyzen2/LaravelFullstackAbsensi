<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-6 pb-24">
        <!-- Top Image Section -->
        <div class="w-full max-w-md mb-8">
            <div class="bg-blue-600 h-40 rounded-[2.5rem] relative overflow-hidden shadow-2xl shadow-blue-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-700"></div>
                <div class="absolute inset-0 flex items-center justify-center opacity-10">
                    <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white px-8 text-center">
                    <h2 class="text-2xl font-black tracking-tight">Daftar Akun</h2>
                    <p class="text-blue-100 text-[9px] font-black uppercase tracking-widest mt-1 opacity-80">Mulai Perjalanan Anda</p>
                </div>
            </div>
        </div>

        <div class="w-full max-w-md bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div class="space-y-1">
                    <label for="name" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="John Doe" 
                            class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Serial Number (NIP/NIS) -->
                <div class="space-y-1">
                    <label for="serial_number" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Serial Number (NIP/NIS)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </div>
                        <input id="serial_number" type="text" name="serial_number" :value="old('serial_number')" required placeholder="Masukkan No. Induk" 
                            class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                    <x-input-error :messages="$errors->get('serial_number')" class="mt-1" />
                </div>

                <!-- Email (Optional) -->
                <div class="space-y-1">
                    <label for="email" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Email (Opsional)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                        </div>
                        <input id="email" type="email" name="email" :value="old('email')" placeholder="email@contoh.com" 
                            class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                            class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="••••••••" 
                            class="block w-full pl-12 pr-4 py-3.5 bg-gray-50 border-gray-100 rounded-2xl focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all font-bold text-gray-800 placeholder:text-gray-300" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-blue-600 text-white font-black rounded-2xl shadow-lg transition-all active:scale-95 uppercase tracking-widest text-xs">
                        Daftar Sekarang
                    </button>
                    
                    <p class="text-center mt-6 text-gray-400 font-bold text-[10px] uppercase tracking-widest">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline ml-1">Masuk</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
