<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Choose a room') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">
                    Pick a room, select schedule, and reserve for the movie you want to watch.
                </p>
            </div>
            <a href="{{ route('reservations.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl text-sm font-medium text-white/80 hover:bg-white/10">
                My reservations
            </a>
        </div>
    </x-slot>

    <div
        class="py-12"
        x-data="{
            open: false,
            room: null,
            openFor(room) { this.room = room; this.open = true; },
            close() { this.open = false; this.room = null; },
            action() { return this.room ? `/rooms/${this.room.id}/reservations` : '#'; },
        }"
        @keydown.escape.window="close()"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-white/5 ring-1 ring-white/10 shadow-2xl sm:rounded-2xl backdrop-blur-xl">
                    <div class="p-4 text-sm text-white/80">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($rooms as $room)
                    <div class="bg-white/5 overflow-hidden rounded-2xl border border-white/10 shadow-2xl hover:shadow-indigo-500/10 transition">
                        <div class="aspect-[16/9] bg-black/20 border-b border-white/10 overflow-hidden">
                            <img
                                src="{{ $room->image_path ?: '/images/rooms/room-01.png' }}"
                                alt="{{ $room->name }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            />
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="space-y-1">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="text-lg font-semibold text-white leading-snug">
                                        {{ $room->name }}
                                    </h3>
                                    <span class="shrink-0 text-xs font-medium px-2 py-1 rounded-full bg-white/10 text-white/80 ring-1 ring-white/10">
                                        {{ $room->capacity }} pax
                                    </span>
                                </div>
                                @if ($room->description)
                                    <p class="text-sm text-white/60 line-clamp-2">
                                        {{ $room->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-white/70">
                                    <span class="font-semibold text-white">₱{{ number_format((float) $room->price_per_hour, 2) }}</span>
                                    <span class="text-white/50">/ hour</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('rooms.show', $room) }}" class="inline-flex items-center px-3 py-2 rounded-xl text-xs font-semibold border border-white/15 text-white/80 hover:bg-white/10">
                                        Details
                                    </a>
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 bg-indigo-500 hover:bg-indigo-400 text-white text-xs font-semibold rounded-xl transition shadow-lg shadow-indigo-500/20"
                                        @click="openFor({ id: {{ $room->id }}, name: @js($room->name) })"
                                    >
                                        Reserve
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white/5 overflow-hidden ring-1 ring-white/10 shadow-2xl sm:rounded-2xl backdrop-blur-xl">
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

        <!-- Reserve Modal -->
        <div
            class="fixed inset-0 z-50 flex items-center justify-center px-4"
            x-show="open"
            x-transition.opacity
            style="display: none;"
            aria-modal="true"
            role="dialog"
        >
            <div class="absolute inset-0 bg-black/70" @click="close()"></div>

            <div class="relative w-full max-w-lg bg-[#0b1220]/95 rounded-2xl shadow-2xl ring-1 ring-white/15 overflow-hidden">
                <div class="px-6 py-4 border-b border-white/10 flex items-center justify-between">
                    <div class="space-y-0.5">
                        <h3 class="text-base font-semibold text-white">Reserve room</h3>
                        <p class="text-sm text-white/60" x-text="room?.name"></p>
                    </div>
                    <button type="button" class="text-white/60 hover:text-white" @click="close()">
                        <span class="sr-only">Close</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 011.06 0L12 10.94l5.47-5.47a.75.75 0 111.06 1.06L13.06 12l5.47 5.47a.75.75 0 11-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 11-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <form method="POST" enctype="multipart/form-data" :action="action()" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="movie_title" value="Movie title" />
                        <x-text-input id="movie_title" name="movie_title" type="text" class="mt-1 block w-full" :value="old('movie_title')" required />
                        <x-input-error class="mt-2" :messages="$errors->get('movie_title')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="starts_at" value="Start date & time" />
                            <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full" :value="old('starts_at')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('starts_at')" />
                        </div>
                        <div>
                            <x-input-label for="ends_at" value="End date & time" />
                            <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full" :value="old('ends_at')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('ends_at')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="payment_method" value="Payment method" />
                        <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-xl bg-white/10 border border-white/15 text-white focus:border-indigo-400 focus:ring-indigo-400 shadow-sm" required>
                            <option value="" disabled {{ old('payment_method') ? '' : 'selected' }}>Select...</option>
                            <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                            <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank transfer</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                    </div>

                    <div>
                        <x-input-label for="payment_proof" value="Payment proof (optional / required for GCash & bank transfer)" />
                        <input id="payment_proof" name="payment_proof" type="file" class="mt-1 block w-full text-sm text-white/80 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-white/10 file:text-white/80 hover:file:bg-white/15" />
                        <x-input-error class="mt-2" :messages="$errors->get('payment_proof')" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl font-semibold text-xs text-white/80 uppercase tracking-widest hover:bg-white/10" @click="close()">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                            Submit request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
