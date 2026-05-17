<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Admin dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Manage accounts, rooms, and reservations.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reservations.pending') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-white rounded-xl text-sm font-medium transition shadow-lg shadow-indigo-500/20">
                    Pending reservations
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-white/5 ring-1 ring-white/10 shadow-2xl sm:rounded-2xl backdrop-blur-xl">
                    <div class="p-4 text-sm text-white/80">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <a href="{{ route('admin.reservations.pending') }}" class="bg-white/5 rounded-2xl p-6 border border-white/10 shadow-2xl hover:shadow-indigo-500/10 transition backdrop-blur-xl">
                    <div class="text-sm text-white/60">Pending reservations</div>
                    <div class="mt-2 text-3xl font-semibold text-white">{{ $pending_reservations }}</div>
                    <div class="mt-4 text-sm font-medium text-indigo-200">Review reservations →</div>
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="bg-white/5 rounded-2xl p-6 border border-white/10 shadow-2xl hover:shadow-indigo-500/10 transition backdrop-blur-xl">
                    <div class="text-sm text-white/60">Rooms</div>
                    <div class="mt-2 text-3xl font-semibold text-white">{{ $rooms }}</div>
                    <div class="mt-4 text-sm font-medium text-indigo-200">Manage rooms →</div>
                </a>
                <div class="bg-white/5 rounded-2xl p-6 border border-white/10 shadow-2xl hover:shadow-indigo-500/10 transition backdrop-blur-xl">
                    <div class="text-sm text-white/60">Cancelled reservations</div>
                    <div class="mt-2 text-3xl font-semibold text-white">{{ $cancelled_reservations }}</div>
                    <div class="mt-4 text-sm font-medium text-indigo-200">Recent cancellations →</div>
                </div>
            </div>

            @if ($recent_cancellations->isNotEmpty())
                <div class="bg-white/5 overflow-hidden rounded-2xl border border-white/10 shadow-2xl backdrop-blur-xl">
                    <div class="p-6">
                        <div class="text-sm text-white/60">Latest cancellations</div>
                        <div class="mt-4 space-y-4">
                            @foreach ($recent_cancellations as $reservation)
                                <div class="rounded-2xl bg-[#0b1220]/80 border border-white/10 p-4">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <div class="text-sm text-white/60">{{ $reservation->room?->name ?? 'Room' }}</div>
                                            <div class="text-white font-semibold">{{ $reservation->user?->name ?? 'Unknown user' }}</div>
                                        </div>
                                        <span class="text-xs uppercase tracking-[0.2em] text-rose-300">Cancelled</span>
                                    </div>
                                    <div class="mt-3 text-sm text-white/70">
                                        {{ $reservation->starts_at?->format('Y-m-d H:i') }} → {{ $reservation->ends_at?->format('Y-m-d H:i') }}
                                    </div>
                                    <div class="mt-3 text-xs text-white/50">
                                        {{ $reservation->admin_note ?? 'Cancelled by user' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

