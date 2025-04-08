<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('products.index')" class="hover:text-blue-500">
            Productos
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Producto</h2>

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-4 mr-3">
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Escribe el nombre del producto." class="w-full border-gray-300 rounded-md">
               </div>

               <div class="flex-2 mr-3">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="category_id" id="customer_id" class="w-full border-gray-300 rounded-md">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category->id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>         
                
                <div class="flex-1 mr-3">
                    <label for="sold_price" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                    <input type="number" id="sold_price" name="sold_price" value="{{ old('sold_price', $product->sold_price) }}" class="w-full price-input border-gray-300 rounded-md" step="0.01" min="0.01" max="999999.99">
                </div> 

                <div class="flex-1 mr-3">
                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                    <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="w-full price-input border-gray-300 rounded-md" step="1" min="10" max="999999">
                </div> 

               <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" class="w-full border-gray-300 rounded-md">
                        @foreach($statuses as $status)
                        <option value="{{ $status->value }}"
                            {{ (old('status', $product->status->value ?? '') == $status->value) ? 'selected' : '' }}>
                            {{ $status->value }}
                        </option>
                        @endforeach
                    </select>
                </div>                  
            </div>  

            <div class="flex">            
                <div class="flex-6 mr-5">
                    <label for="details" class="block text-sm font-medium text-gray-700">Detalles</label>
                    <textarea name="details" id="details" rows="4" class="w-full border-gray-300 rounded-md p-2" placeholder="Escribe los detalles del producto.">{{ old('details', $product->details) }}</textarea>
                </div>

                <div class="flex-2 relative mt-5 mr-0">
                    <div class="w-full h-35 overflow-hidden">
                        <img id="imgPreview" class="w-full h-full object-contain object-center" 
                            src= "{{ $product->image_path ? Storage::url($product->image_path) : "https://th.bing.com/th/id/R.34fdae8eebd55953d38fd8d72f7d53c6?rik=5oQzBpO6lDgt9g&riu=http%3a%2f%2fwww.solidbackgrounds.com%2fimages%2f2880x1800%2f2880x1800-light-gray-solid-color-background.jpg&ehk=an3tuTn09XTjenq4X5b1lFPbxVC62AK6OIyHLx2CvrQ%3d&risl=&pid=ImgRaw&r=0" }}" 
                        >                       
                        <div class="absolute -bottom-1/3 right-12">
                            <label class="btn-cambiar-imagen">
                                Cambiar Imagen
                                <input class="hidden" type="file" name="image" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-start">
                <button type="submit" class="px-6 py-2 text-white rounded-md">Guardar Producto</button>
            </div>
        </form>
    </div>
</x-layouts.app>