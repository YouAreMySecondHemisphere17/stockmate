<div class="flex flex-col gap-6 max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
    <!-- Header -->
    <x-auth-header :title="__('Inicia sesión en tu cuenta de StockMate')" :description="__('Ingresa tu correo y contraseña para acceder al sistema de inventarios de tu papelería')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <!-- Login Form -->
    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Correo Electrónico')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@papeleria.com"
            class="border border-gray-300 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-green-400"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Contraseña')"
                class="border border-gray-300 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-green-400"
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm text-green-500 hover:text-green-700" :href="route('password.request')" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Recuérdame')" />

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600">
                {{ __('Iniciar Sesión') }}
            </flux:button>
        </div>
    </form>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __("¿No tienes cuenta?") }}
            <flux:link :href="route('register')" wire:navigate class="text-green-500 hover:text-green-700">{{ __('Registrarse') }}</flux:link>
        </div>
    @endif

    <div class="text-center mb-6">
        <!--  <img src="{{ asset('images/stockmate-logo.png') }}" alt="StockMate" class="mx-auto w-28"> -->
    </div>
</div>



