<x-app-layout>
<form method="POST" action="{{ route('job') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Title')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="salery_range" :value="__('Salery Range')" />
            <x-text-input id="salery_range" class="block mt-1 w-full" type="email" name="salery_range" :value="old('salery_range')" required autocomplete="salery_range" />
            <x-input-error :messages="$errors->get('salery_range')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Applied_before')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="date"
                            name="applied_before"
                            required autocomplete="applied_before" />

            <x-input-error :messages="$errors->get('applied_before')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />

            <x-text-input id="description" class="block mt-1 w-full"
                            type="text"
                            name="description" required autocomplete="description" />

            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
           

            <x-primary-button class="ms-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
