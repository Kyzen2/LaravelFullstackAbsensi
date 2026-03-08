<section class="space-y-8">
    <header>
        <h2 class="text-xl font-black text-white tracking-tight">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 opacity-70 italic">
            {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus permanen.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 glass-card bg-slate-900/95 border-rose-500/20 rounded-[40px]">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-white tracking-tight">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-3 text-slate-500 text-xs font-medium leading-relaxed opacity-70 italic">
                {{ __('Setelah akun dihapus, semua data akan hilang selamanya. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Password Konfirmasi') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Hapus Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
