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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
            </div>
        </div>
    </div>
</x-app-layout>

