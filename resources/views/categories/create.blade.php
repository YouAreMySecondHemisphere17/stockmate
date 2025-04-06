<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('categories.index')">
            Categorías
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Nuevo
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Registrar Nueva Categoría</h2>

        <form action="{{route('categories.store')}}" method="POST" class="space-y-6">

            @csrf

            <div class="flex">
                <div class="flex-2 mr-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Escribe el nombre de la categoría." class="w-full border-gray-300 rounded-md">
               </div>  

               <div class="flex-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" class="w-full border-gray-300 rounded-md">
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}">{{ $status->value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>  
  
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Categoría</button>
            </div>

        </form>

    </div>

</x-layouts.app>
