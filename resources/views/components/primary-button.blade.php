<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium inline-flex items-center px-8 py-4 text-[11px] font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-500/20 active:scale-95 transition-all']) }}>
    {{ $slot }}
</button>
