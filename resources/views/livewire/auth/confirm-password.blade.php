<div class="flex flex-col gap-6 max-w-lg mx-auto bg-white p-8 shadow-lg rounded-lg">
    <!-- Header -->
    <x-auth-header
        :title="__('Confirmar Contraseña')"
        :description="__('Este es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.')"
    />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Introduce tu contraseña')"
            class="border border-gray-300 rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-green-400"
        />

        <!-- Confirm Button -->
        <flux:button variant="primary" type="submit" class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600">
            {{ __('Confirmar') }}
        </flux:button>
    </form>
</div>
