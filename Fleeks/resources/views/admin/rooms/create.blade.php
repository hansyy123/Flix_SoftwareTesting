<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ __('Create room') }}
                </h2>
                <p class="mt-1 text-sm text-white/60">Add a new room and upload a photo.</p>
            </div>
            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/15 rounded-xl text-sm font-medium text-white/80 hover:bg-white/10">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 overflow-hidden shadow-2xl ring-1 ring-white/10 sm:rounded-2xl backdrop-blur-xl">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="name" value="Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-xl bg-white/10 border border-white/15 text-white placeholder-white/40 focus:border-indigo-400 focus:ring-indigo-400 shadow-sm" rows="4">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="capacity" value="Capacity" />
                                <x-text-input id="capacity" name="capacity" type="number" min="1" class="mt-1 block w-full" :value="old('capacity', 1)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('capacity')" />
                            </div>
                            <div>
                                <x-input-label for="price_per_hour" value="Price per hour" />
                                <x-text-input id="price_per_hour" name="price_per_hour" type="number" min="0" step="0.01" class="mt-1 block w-full" :value="old('price_per_hour', 0)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('price_per_hour')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="image" value="Room image (optional)" />
                            <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-white/80 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-white/10 file:text-white/80 hover:file:bg-white/15" />
                            <p class="mt-1 text-xs text-white/50">Tip: you can also replace images in <code class="font-mono">public/images/rooms</code>.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-white/20 bg-white/10 text-indigo-500 shadow-sm focus:ring-indigo-400" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="text-sm text-white/70">Active</label>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-400 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest transition shadow-lg shadow-indigo-500/20">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

