<body class="min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('{{ asset('images/bg.jpg') }}'); background-size: cover; background-position: center;">
    <div class="w-full max-w-sm bg-white backdrop-blur-md rounded-3xl shadow-xl border border-gray-400 p-4 sm:p-6">

        <!-- Logo y título -->
        <div class="text-center mb-2">
            <div class="flex items-center justify-center mb-2">
                <img src="{{ asset('images/app_logo.png') }}" alt="StockMate" class="w-10 rounded-md shadow-sm">
                <h2 class="ml-2 text-lg font-extrabold text-gray-800">{{ __('StockMate') }}</h2>
            </div>
            <p class="text-sm text-gray-600">{{ __('Ingresa tus datos para crear una cuenta') }}</p>
        </div>

        <!-- Estado de sesión -->
        <x-auth-session-status class="text-center text-cyan-600 mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form wire:submit.prevent="register" class="flex flex-col gap-3">

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-1">{{ __('Nombre completo') }}</label>
                <input
                    id="name"
                    type="text"
                    wire:model="name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="{{ __('Nombre completo') }}"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-500 transition duration-200 ease-in-out"
                />
            </div>

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">{{ __('Correo electrónico') }}</label>
                <input
                    id="email"
                    type="email"
                    wire:model="email"
                    required
                    autocomplete="email"
                    placeholder="email@ejemplo.com"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-500 transition duration-200 ease-in-out"
                />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">{{ __('Contraseña') }}</label>
                <input
                    id="password"
                    type="password"
                    wire:model="password"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Contraseña') }}"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-50 transition duration-200 ease-in-out"
                />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">{{ __('Confirmar contraseña') }}</label>
                <input
                    id="password_confirmation"
                    type="password"
                    wire:model="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="{{ __('Confirmar contraseña') }}"
                    class="w-full rounded-lg bg-white border-2 border-gray-400 px-4 py-2 shadow-md focus:ring-2 focus:ring-gray-50 transition duration-200 ease-in-out"
                />
            </div>

            <!-- Botón de crear cuenta -->
            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="w-full bg-teal-500 text-white font-bold py-3 rounded-lg transition hover:bg-teal-700 shadow-md"
                >
                    {{ __('Crear cuenta') }}
                </button>
            </div>
        </form>

        <!-- Enlace para iniciar sesión -->
        <div class="mt-4 text-center text-sm text-gray-600">
            {{ __("¿Ya tienes una cuenta?") }}
            <a href="{{ route('login') }}" class="text-cyan-700 font-semibold hover:text-cyan-900">
                {{ __('Iniciar sesión') }}
            </a>
        </div>
    </div>
</body>
