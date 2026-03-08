<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Standard Access
            </h2>
        </div>
    </x-slot>

    <div class="py-20 flex flex-col items-center justify-center p-6 space-y-12">
        <div class="max-w-md w-full text-center space-y-10">
            <!-- Hero Icon -->
            <div class="relative inline-block">
                <div class="absolute -inset-4 bg-indigo-500/20 rounded-full blur-2xl"></div>
                <div class="relative w-32 h-32 glass-card rounded-[3rem] border-white/10 flex items-center justify-center mx-auto shadow-2xl">
                    <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-4">
                <h3 class="text-4xl font-black text-white tracking-tighter leading-none uppercase">Session Active</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed max-w-xs mx-auto opacity-70 italic">
                    {{ __("You're successfully authenticated. Welcome to the EduAttend ecosystem.") }}
                </p>
            </div>

            <!-- Action -->
            <div class="pt-6">
                <a href="/" class="btn-premium w-full max-w-xs mx-auto py-5 text-sm uppercase tracking-[0.2em] shadow-indigo-500/10 active:scale-95">
                    Proceed to Home
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
