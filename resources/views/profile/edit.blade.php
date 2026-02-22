<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-screen pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 px-2">
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">Pengaturan Profil</h1>
                <p class="text-gray-400 text-[10px] font-black mt-1 uppercase tracking-widest leading-none">Kelola informasi akun Anda</p>
            </div>

            <div class="space-y-6">
                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-3xl">
                    <div class="max-w-xl">
                        <div class="p-4 bg-red-50 rounded-2xl border border-red-100">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
