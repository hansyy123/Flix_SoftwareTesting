<x-guest-layout>
    <div class="space-y-6" x-data="{ show1: false, show2: false }">
        <div class="text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-white">Create your account</h1>
            <p class="mt-1 text-sm text-white/70">Register now. Admin approval is required before reservations.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Full name')" class="text-white/80" />
                <x-text-input
                    id="name"
                    class="mt-1 block w-full rounded-xl bg-white/10 border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Juan Dela Cruz"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-white/80" />
                <x-text-input
                    id="email"
                    class="mt-1 block w-full rounded-xl bg-white/10 border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="you@example.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" class="text-white/80" />
                <div class="relative mt-1">
                    <x-text-input
                        id="password"
                        class="block w-full rounded-xl bg-white/10 border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400 pr-11"
                        type="password"
                        x-bind:type="show1 ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a strong password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 px-3 text-white/70 hover:text-white"
                        @click="show1 = !show1"
                        :aria-label="show1 ? 'Hide password' : 'Show password'"
                    >
                        <svg x-show="!show1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M12 4.5c-5.05 0-9.29 3.11-11 7.5 1.71 4.39 5.95 7.5 11 7.5s9.29-3.11 11-7.5c-1.71-4.39-5.95-7.5-11-7.5Zm0 12a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
                        </svg>
                        <svg x-show="show1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" style="display:none">
                            <path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l2.1 2.1C2.85 7.14 1.6 8.92 1 10.5c1.71 4.39 5.95 7.5 11 7.5 1.74 0 3.38-.37 4.87-1.03l2.6 2.6a.75.75 0 1 0 1.06-1.06l-17-17ZM12 16.5c-3.41 0-6.44-1.94-8.15-5 1.01-1.78 2.48-3.21 4.22-4.08l1.53 1.53a4.5 4.5 0 0 0 5.93 5.93l1.45 1.45c-1.2.48-2.53.74-3.98.74Zm-.19-9.37 3.06 3.06a2.99 2.99 0 0 0-3.06-3.06Z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm password')" class="text-white/80" />
                <div class="relative mt-1">
                    <x-text-input
                        id="password_confirmation"
                        class="block w-full rounded-xl bg-white/10 border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400 pr-11"
                        type="password"
                        x-bind:type="show2 ? 'text' : 'password'"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Repeat your password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 px-3 text-white/70 hover:text-white"
                        @click="show2 = !show2"
                        :aria-label="show2 ? 'Hide password' : 'Show password'"
                    >
                        <svg x-show="!show2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M12 4.5c-5.05 0-9.29 3.11-11 7.5 1.71 4.39 5.95 7.5 11 7.5s9.29-3.11 11-7.5c-1.71-4.39-5.95-7.5-11-7.5Zm0 12a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>
                        </svg>
                        <svg x-show="show2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" style="display:none">
                            <path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l2.1 2.1C2.85 7.14 1.6 8.92 1 10.5c1.71 4.39 5.95 7.5 11 7.5 1.74 0 3.38-.37 4.87-1.03l2.6 2.6a.75.75 0 1 0 1.06-1.06l-17-17ZM12 16.5c-3.41 0-6.44-1.94-8.15-5 1.01-1.78 2.48-3.21 4.22-4.08l1.53 1.53a4.5 4.5 0 0 0 5.93 5.93l1.45 1.45c-1.2.48-2.53.74-3.98.74Zm-.19-9.37 3.06 3.06a2.99 2.99 0 0 0-3.06-3.06Z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 rounded-xl bg-indigo-500 hover:bg-indigo-400 text-white font-semibold transition shadow-lg shadow-indigo-500/20">
                {{ __('Create account') }}
            </button>
        </form>

        <p class="text-center text-sm text-white/70">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="font-semibold text-white hover:underline">
                {{ __('Log in') }}
            </a>
        </p>
    </div>
</x-guest-layout>