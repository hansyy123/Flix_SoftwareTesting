<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('My reservations') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Track your reservation and approval status.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-white rounded-xl text-sm font-medium transition shadow-lg shadow-indigo-500/20">
                Reserve another room
            </a>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($reservations as $reservation)
                    @php
                        $statusClasses = match ($reservation->status) {
                            'approved' => 'bg-emerald-500/15 text-emerald-200 ring-emerald-400/20',
                            'rejected' => 'bg-red-500/15 text-red-200 ring-red-400/20',
                            'cancelled' => 'bg-white/10 text-white/80 ring-white/15',
                            default => 'bg-amber-500/15 text-amber-200 ring-amber-400/20',
                        };
                    @endphp
                    <div class="bg-white/5 rounded-2xl border border-white/10 shadow-2xl overflow-hidden backdrop-blur-xl">
                        <div class="p-5 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-sm text-white/60">Room</div>
                                    <div class="text-base font-semibold text-white">{{ $reservation->room?->name ?? '—' }}</div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $statusClasses }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-1 gap-3 text-sm">
                                <div>
                                    <div class="text-white/60">Movie</div>
                                    <div class="font-medium text-white">{{ $reservation->movie_title ?? '—' }}</div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <div class="text-white/60">Start</div>
                                        <div class="font-medium text-white">{{ $reservation->starts_at?->format('Y-m-d H:i') }}</div>
                                    </div>
                                    <div>
                                        <div class="text-white/60">End</div>
                                        <div class="font-medium text-white">{{ $reservation->ends_at?->format('Y-m-d H:i') }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-white/60">Payment</div>
                                        <div class="font-medium text-white">{{ str_replace('_', ' ', $reservation->payment_method) }}</div>
                                    </div>
                                </div>
                                @if ($reservation->admin_note)
                                    <div class="rounded-xl bg-white/5 border border-white/10 p-3">
                                        <div class="text-white/60 text-xs font-medium">Admin note</div>
                                        <div class="text-white text-sm mt-1">{{ $reservation->admin_note }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white/5 rounded-2xl border border-white/10 shadow-2xl backdrop-blur-xl">
                        <div class="p-6 text-white/70">
                            No reservations yet.
                        </div>
                    </div>
                @endforelse
            </div>

            <div>
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

