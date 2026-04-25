<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                    {{ __('Rooms') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">Browse available rooms and open one to reserve for your movie.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                Quick reserve
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($rooms as $room)
                    <a href="{{ route('rooms.show', $room) }}" class="block bg-white overflow-hidden rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="aspect-[16/9] bg-gray-50 border-b border-gray-100 overflow-hidden">
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
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $room->name }}
                                    </h3>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-100 text-gray-700">
                                        {{ $room->capacity }} pax
                                    </span>
                                </div>
                                @if ($room->description)
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $room->description }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-700">
                                    <span class="font-semibold text-gray-900">₱{{ number_format((float) $room->price_per_hour, 2) }}</span>
                                    <span class="text-gray-500">/ hour</span>
                                </div>
                                <span class="text-sm font-medium text-indigo-600">View →</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-700">
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

