<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl font-semibold text-xs text-white/80 uppercase tracking-widest shadow-sm hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-0 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
