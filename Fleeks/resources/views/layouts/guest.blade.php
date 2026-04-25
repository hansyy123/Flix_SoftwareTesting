<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        {{-- Vite requires Node/NPM. This project uses CDN Tailwind + Alpine for now. --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div
            class="min-h-screen bg-[#070a12] text-white"
            x-data="{
                i: 0,
                images: ['/images/rooms/room-01.png','/images/rooms/room-02.png','/images/rooms/room-03.png','/images/rooms/room-04.png','/images/rooms/room-05.png','/images/rooms/room-06.png','/images/rooms/room-07.png','/images/rooms/room-08.png'],
                tick() { this.i = (this.i + 1) % this.images.length; },
                start() { setInterval(() => this.tick(), 4500); },
            }"
            x-init="start()"
        >
            <div class="relative min-h-screen">
                <!-- Background slideshow -->
                <div class="absolute inset-0">
                    <template x-for="(img, idx) in images" :key="img">
                        <img
                            :src="img"
                            alt=""
                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000"
                            :class="idx === i ? 'opacity-40' : 'opacity-0'"
                        />
                    </template>
                    <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-[#070a12]/70 to-black/90"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(79,70,229,0.25),transparent_55%)]"></div>
                </div>

                <div class="relative z-10 min-h-screen grid lg:grid-cols-2">
                    <!-- Left marketing panel -->
                    <div class="hidden lg:flex flex-col justify-between p-10">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-white/10 ring-1 ring-white/15 grid place-items-center">
                                <x-application-logo class="h-6 w-6 fill-current text-white" />
                            </div>
                            <div class="leading-tight">
                                <div class="text-sm text-white/70">Flix</div>
                                <div class="font-semibold tracking-wide">Private Movie Room Reservations</div>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            <div class="text-4xl font-semibold leading-tight">
                                Your personal cinema, on your schedule.
                            </div>
                            <p class="mt-4 text-white/70 text-base leading-relaxed">
                                Choose a room, enter the movie you want to watch, and submit a reservation request. Admins approve accounts and validate schedules to prevent conflicts.
                            </p>

                            <div class="mt-8 grid grid-cols-3 gap-4">
                                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-4">
                                    <div class="text-sm text-white/70">Step 1</div>
                                    <div class="mt-1 font-semibold">Register</div>
                                </div>
                                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-4">
                                    <div class="text-sm text-white/70">Step 2</div>
                                    <div class="mt-1 font-semibold">Get approved</div>
                                </div>
                                <div class="rounded-2xl bg-white/5 ring-1 ring-white/10 p-4">
                                    <div class="text-sm text-white/70">Step 3</div>
                                    <div class="mt-1 font-semibold">Reserve</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-xs text-white/40">
                            Tip: replace room photos in <span class="font-mono">public/images/rooms</span>.
                        </div>
                    </div>

                    <!-- Right form panel -->
                    <div class="flex items-center justify-center p-6 lg:p-10">
                        <div class="w-full max-w-md">
                            <div class="lg:hidden mb-6 flex items-center justify-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-white/10 ring-1 ring-white/15 grid place-items-center">
                                    <x-application-logo class="h-6 w-6 fill-current text-white" />
                                </div>
                                <div class="font-semibold tracking-wide">Flix</div>
                            </div>

                            <div class="rounded-2xl bg-white/10 backdrop-blur-xl ring-1 ring-white/15 shadow-2xl p-6 sm:p-8">
                                {{ $slot }}
                            </div>

                            <div class="mt-6 text-center text-xs text-white/50">
                                By continuing, you agree to the project’s usage rules.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
