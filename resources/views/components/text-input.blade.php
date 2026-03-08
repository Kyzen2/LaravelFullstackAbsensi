@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/5 border-white/10 focus:border-indigo-500 focus:ring-indigo-500/20 rounded-2xl shadow-inner text-white placeholder-slate-500 transition-all duration-300 backdrop-blur-sm w-full py-4 px-6']) }}>
