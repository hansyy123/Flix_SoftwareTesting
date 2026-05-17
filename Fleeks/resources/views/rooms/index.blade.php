<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Rooms') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Browse available rooms and open one to reserve for your movie.</p>
            </div>
            @if (!(auth()->user()->role ?? 'user' === 'admin'))
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl text-sm font-medium text-white/80 hover:bg-white/10">
                    Quick reserve
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @php $isAdmin = (auth()->user()->role ?? 'user') === 'admin'; @endphp
                @forelse ($rooms as $room)
                    <a href="{{ route('rooms.show', ['room' => $room->id]) }}" class="block overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur-xl hover:shadow-indigo-500/10 transition">
                        <div class="aspect-[16/9] bg-black/20 border-b border-white/10 overflow-hidden">
                            <img
                                src="{{ $room->image_path ?: '/images/rooms/room1.jpg' }}"
                                alt="{{ $room->name }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="space-y-1">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ $room->name }}
                                    </h3>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-white/10 text-white/80 ring-1 ring-white/10">
                                        {{ $room->capacity }} pax
                                    </span>
                                </div>
                                @if ($room->description)
                                    <p class="text-sm text-white/70 line-clamp-2">
                                        {{ $room->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-white/70">
                                    <span class="font-semibold text-white">₱{{ number_format((float) $room->price_per_hour, 2) }}</span>
                                    <span class="text-white/60">/ hour</span>
                                </div>
                                @unless ($isAdmin)
                                    <span class="inline-flex items-center px-3 py-2 rounded-xl border border-white/15 bg-white/5 text-xs font-semibold text-white/80 transition hover:bg-white/10">
                                        View
                                    </span>
                                @endunless
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full rounded-2xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur-xl">
                        <div class="p-6 text-white/70">
                            No rooms available yet.
                        </div>
                    </div>
                @endforelse
            </div>

            <div>
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

