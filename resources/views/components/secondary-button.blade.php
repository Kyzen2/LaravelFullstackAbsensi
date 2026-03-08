<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-8 py-4 bg-white/5 border border-white/10 rounded-2xl font-black text-[11px] text-slate-400 uppercase tracking-[0.2em] shadow-sm hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition active:scale-95 duration-300 backdrop-blur-sm']) }}>
    {{ $slot }}
</button>
