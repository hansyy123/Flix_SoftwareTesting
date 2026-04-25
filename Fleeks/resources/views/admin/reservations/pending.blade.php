<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Pending reservations') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Approve or reject requests. Approvals re-check schedule conflicts.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl text-sm font-medium text-white/80 hover:bg-white/10">
                Back
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

            <div class="bg-white/5 overflow-hidden rounded-2xl border border-white/10 shadow-2xl backdrop-blur-xl">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-white/60">
                                <th class="py-2 pr-4">User</th>
                                <th class="py-2 pr-4">Room</th>
                                <th class="py-2 pr-4">Movie</th>
                                <th class="py-2 pr-4">Schedule</th>
                                <th class="py-2 pr-4">Payment</th>
                                <th class="py-2 pr-4">Proof</th>
                                <th class="py-2 pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($reservations as $reservation)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-white">
                                        <div>{{ $reservation->user?->name ?? '—' }}</div>
                                        <div class="text-xs text-white/50">{{ $reservation->user?->email ?? '' }}</div>
                                    </td>
                                    <td class="py-3 pr-4 text-white/70">
                                        {{ $reservation->room?->name ?? '—' }}
                                    </td>
                                    <td class="py-3 pr-4 text-white/70">
                                        {{ $reservation->movie_title ?? '—' }}
                                    </td>
                                    <td class="py-3 pr-4 text-white/70">
                                        {{ $reservation->starts_at?->format('Y-m-d H:i') }} → {{ $reservation->ends_at?->format('Y-m-d H:i') }}
                                    </td>
                                    <td class="py-3 pr-4 text-white/70">
                                        {{ str_replace('_', ' ', $reservation->payment_method) }}
                                    </td>
                                    <td class="py-3 pr-4 text-white/70">
                                        @if ($reservation->payment_proof_path)
                                            <a
                                                class="text-sm font-medium text-indigo-200 hover:text-white"
                                                href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($reservation->payment_proof_path) }}"
                                                target="_blank"
                                                rel="noreferrer"
                                            >
                                                View
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('admin.reservations.approve', $reservation) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-500/90 hover:bg-emerald-400 text-white text-xs font-semibold rounded-xl transition">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.reservations.reject', $reservation) }}" class="flex items-center gap-2">
                                                @csrf
                                                <input
                                                    type="text"
                                                    name="admin_note"
                                                    class="w-56 rounded-xl bg-white/10 border border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400 shadow-sm text-sm"
                                                    placeholder="Optional note"
                                                />
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-white/5 border border-white/15 text-white/80 text-xs font-semibold rounded-xl hover:bg-white/10">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-white/70">
                                        No pending reservations.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

