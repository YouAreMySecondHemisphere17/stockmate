<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('images/bg.jpg') }}'); background-size: cover; background-position: center;">
    <div class="w-full max-w-sm bg-white backdrop-blur-md rounded-3xl shadow-xl border border-yellow-300 p-6 sm:p-8">

        <!-- Logo y encabezado -->
        <div class="text-center mb-4">
            <div class="flex items-center justify-between">
                <img src="{{ asset('images/stockmate_logo.png') }}" alt="StockMate" class="w-14 rounded-md shadow-sm border border-yellow-200">

                <h2 class="text-lg sm:text-xl font-extrabold text-gray-800">Confirmar Contraseña</h2>
            </div>
            <p class="text-sm text-gray-600 mt-2">Por seguridad, confirma tu contraseña antes de continuar 🔐</p>
        </div>

        <!-- Estado de sesión -->
        <x-auth-session-status class="text-center text-green-600 mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form wire:submit.prevent="confirmPassword" class="flex flex-col gap-5">
            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">{{ __('Contraseña') }}</label>
                <input
                    id="password"
                    type="password"
                    wire:model="password"
                    required
                    autocomplete="current-password"
                    placeholder="Introduce tu contraseña"
                    class="w-full rounded-lg bg-white border-2 border-yellow-300 px-4 py-2 shadow-md focus:ring-2 focus:ring-yellow-400 transition duration-200 ease-in-out"
                />
            </div>

            <!-- Botón -->
            <button
                type="submit"
                class="w-full bg-yellow-400 text-white font-bold py-3 rounded-lg transition hover:bg-yellow-500 shadow-md"
            >
                {{ __('Confirmar') }}
            </button>
        </form>
    </div>
</body>
