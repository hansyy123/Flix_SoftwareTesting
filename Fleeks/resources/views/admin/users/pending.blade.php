<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Pending users') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Approve accounts before they can reserve rooms.</p>
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
                                <th class="py-2 pr-4">Name</th>
                                <th class="py-2 pr-4">Email</th>
                                <th class="py-2 pr-4">Created</th>
                                <th class="py-2 pr-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-white">{{ $user->name }}</td>
                                    <td class="py-3 pr-4 text-white/70">{{ $user->email }}</td>
                                    <td class="py-3 pr-4 text-white/70">{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-500/90 hover:bg-emerald-400 text-white text-xs font-semibold rounded-xl transition">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-white/5 border border-white/15 text-white/80 text-xs font-semibold rounded-xl hover:bg-white/10">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-white/70">
                                        No pending users.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

