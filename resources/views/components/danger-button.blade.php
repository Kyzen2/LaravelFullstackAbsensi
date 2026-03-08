<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl font-black text-[11px] text-rose-400 uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition active:scale-95 duration-300 shadow-lg shadow-rose-500/5']) }}>
    {{ $slot }}
</button>
