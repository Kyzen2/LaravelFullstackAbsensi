@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[10px] font-bold text-rose-400 space-y-1 mt-2 ml-1 italic']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1.5 font-bold uppercase tracking-wider">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                {{ $message }}
            </li>
        @endforeach
    </ul>
@endif
