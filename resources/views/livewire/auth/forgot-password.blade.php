<div class="flex flex-col gap-6 max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
    <!-- Header -->
    <x-auth-header :title="__('Recuperar Contraseña')" :description="__('Ingresa tu correo electrónico para recibir un enlace para restablecer tu contraseña')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Correo Electrónico')"
            type="email"
            required
            autofocus
            placeholder="correo@ejemplo.com"
            class="border border-gray-300 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-green-400"
        />

        <!-- Submit Button -->
        <flux:button variant="primary" type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600">
            {{ __('Enviar enlace para restablecer contraseña') }}
        </flux:button>
    </form>

    <!-- Link to Login -->
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        {{ __('O regresa a') }}
        <flux:link :href="route('login')" wire:navigate class="text-green-500 hover:text-green-700">
            {{ __('Iniciar sesión') }}
        </flux:link>
    </div>
</div>

