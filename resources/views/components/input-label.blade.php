@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-black text-[10px] uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
