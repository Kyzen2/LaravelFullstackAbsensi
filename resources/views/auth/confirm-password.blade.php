<x-guest-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-black text-white tracking-tight uppercase">Secure Area</h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mt-2 italic">
                {{ __('Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full justify-center py-5">
                    {{ __('Confirm Access') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
