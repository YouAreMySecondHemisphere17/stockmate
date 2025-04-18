<x-layouts.app>

    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('categories.index')">
            Categorias
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Categoría</h2>

        <form action="{{ route('categories.update', ['category' => $category['id']]) }}" method="POST" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-2 mr-3">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="category_name" value="{{ old('category_name', $category['category_name']) }}" placeholder="Escribe el nombre de la categoría." class="w-full border-gray-300 rounded-md">
                    @error('category_name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div> 
            </div>  

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Categoría</button>
            </div>

        </form>

    </div>

</x-layouts.app>
