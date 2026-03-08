<x-guest-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Verify Email</h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2 italic px-4 leading-relaxed">
                {{ __('Thanks for joining! Please verify your email by clicking the link we sent. If you didn\'t receive it, we\'ll send another.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-[10px] font-black uppercase tracking-widest text-emerald-400 text-center">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="space-y-6">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="w-full justify-center py-5">
                    {{ __('Resend Link') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-[10px] font-black text-slate-500 hover:text-white transition-colors uppercase tracking-[0.2em]">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
