<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Account pending approval') }}
            </h2>
            <p class="mt-1 text-sm text-white/60">An admin must approve your account before you can reserve rooms.</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 overflow-hidden rounded-2xl border border-white/10 shadow-2xl backdrop-blur-xl">
                <div class="p-6 text-white space-y-4">
                    <p class="text-sm text-white/70">
                        Your account is registered, but it must be approved by an admin before you can access the reservation system.
                    </p>
                    <p class="text-sm text-white/70">
                        Please check back later. You can still update your profile details or log out.
                    </p>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl font-semibold text-xs text-white/80 uppercase tracking-widest hover:bg-white/10">
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

