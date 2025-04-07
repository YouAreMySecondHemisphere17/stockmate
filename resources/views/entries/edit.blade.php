<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('entries.index')" class="hover:text-blue-500">
            Entradas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Entrada</h2>

        <form action="{{ route('entries.update', $entry) }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-2 mr-3">
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Productos</label>
                    <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md">
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                {{ old('product->id', $entry->product->id) == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-2">
                    <label for="vendor_id" class="block text-sm font-medium text-gray-700">Proveedor</label>
                    <select name="vendor_id" id="vendor_id" class="w-full border-gray-300 rounded-md">
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" 
                                {{ old('vendor->id', $entry->vendor->id) == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="price" class="block text-sm font-medium text-gray-700">Precio de Compra</label>
                    <input type="number" id="price" name="price" value="{{ old('price',  $entry->price) }}" class="w-full border-gray-300 rounded-md" step="0.01" min="0.01" max="999999.99">
                </div>

                <div class="flex-1 mr-3">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad del Producto</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $entry->quantity) }}" class="w-full border-gray-300 rounded-md" step="1" min="1" max="999999">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Entrada</button>
            </div>
        </form>
    </div>
</x-layouts.app>