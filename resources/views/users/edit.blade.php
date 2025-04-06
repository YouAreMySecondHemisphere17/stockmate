<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('users.index')">
            Usuarios
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Usuario</h2>

        <form action="{{route('users.update', $user)}}" method="POST" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-2 mr-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Escribe el nombre del usuario." class="w-full border-gray-300 rounded-md">
               </div> 
            </div>  

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Usuario</button>
            </div>

        </form>

    </div>

</x-layouts.app>
