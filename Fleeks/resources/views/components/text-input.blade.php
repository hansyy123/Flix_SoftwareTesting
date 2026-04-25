@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'rounded-xl bg-white/10 border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400 shadow-sm']) }}
>
