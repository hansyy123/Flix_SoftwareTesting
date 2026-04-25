<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Rooms') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Add, edit, and update room photos.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl text-sm font-medium text-white/80 hover:bg-white/10">
                    Back
                </a>
                <a href="{{ route('admin.rooms.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 text-white text-xs font-semibold rounded-xl transition shadow-lg shadow-indigo-500/20">
                    New room
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

            <div class="bg-white/5 overflow-hidden shadow-2xl ring-1 ring-white/10 sm:rounded-2xl backdrop-blur-xl">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-white/60">
                                <th class="py-2 pr-4">Image</th>
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Capacity</th>
                                <th class="py-2 pr-4">Price/hour</th>
                                <th class="py-2 pr-4">Active</th>
                                <th class="py-2 pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td class="py-3 pr-4">
                                        <img
                                            src="{{ $room->image_path ?: '/images/rooms/room-01.png' }}"
                                            alt="{{ $room->name }}"
                                            class="h-12 w-20 rounded-xl object-cover border border-white/10 bg-black/20"
                                            loading="lazy"
                                        />
                                    </td>
                                    <td class="py-3 pr-4 font-medium text-white">{{ $room->name }}</td>
                                    <td class="py-3 pr-4 text-white/70">{{ $room->capacity }}</td>
                                    <td class="py-3 pr-4 text-white/70">₱{{ number_format((float) $room->price_per_hour, 2) }}</td>
                                    <td class="py-3 pr-4 text-white/70">{{ $room->is_active ? 'Yes' : 'No' }}</td>
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="text-sm font-medium text-indigo-200 hover:text-white">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Delete this room?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-200 hover:text-white">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-white/70">
                                        No rooms yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $rooms->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

