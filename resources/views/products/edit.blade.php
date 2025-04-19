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

            <div class="flex flex-wrap gap-4">
                <!-- Nombre del Producto -->
                <div class="flex-2 min-w-[200px]">
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Escribe el nombre del producto." class="w-full border-gray-300 rounded-md">
                    @error('product_name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="flex-2 min-w-[200px]">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category->id) == $category->id ? 'selected' : '' }} >
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <!-- Precio de Compra -->
                <div class="flex-2 min-w-[180px]">
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700">Precio de Compra</label>
                    <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" class="w-full price-input border-gray-300 rounded-md" step="0.01" min="0.01" max="999999.99">
                </div>

                <!-- Precio de Venta -->
                <div class="flex-2 min-w-[180px]">
                    <label for="sold_price" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                    <input type="number" id="sold_price" name="sold_price" value="{{ old('sold_price', $product->sold_price) }}" class="w-full price-input border-gray-300 rounded-md" step="0.01" min="0.01" max="999999.99">
                </div>

                <!-- Margen de Ganancia (%) -->
                <div class="flex-2 min-w-[120px]">
                    <label for="margin" class="block text-sm font-medium text-gray-700">Margen de Ganancia (%)</label>
                    <input type="number" id="margin" name="margin" value="{{ old('margin', (($product->sold_price - $product->purchase_price) / $product->purchase_price) * 100) }}" class="w-full border-gray-300 rounded-md" step="1" min="1" max="500" readonly>
                </div>

                <!-- Stock Mínimo -->
                <div class="flex-1 min-w-[150px]">
                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                    <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="w-full price-input border-gray-300 rounded-md" step="1" min="10" max="999999">
                </div>
            </div>

            <div class="flex flex-wrap gap-4">
                <!-- Detalles -->
                <div class="flex-6 w-full md:w-3/4">
                    <label for="details" class="block text-sm font-medium text-gray-700">Detalles</label>
                    <textarea name="details" id="details" rows="4" class="w-full border-gray-300 rounded-md p-2" placeholder="Escribe los detalles del producto.">{{ old('details', $product->details) }}</textarea>
                </div>

                <!-- Imagen -->
                <div class="flex-2 relative mt-5 w-full md:w-1/4">
                    <div class="w-full h-35 overflow-hidden">
                        <img id="imgPreview" class="w-full h-full object-contain object-center" 
                            src="{{ $product->image_path ? Storage::url($product->image_path) : 'https://th.bing.com/th/id/R.34fdae8eebd55953d38fd8d72f7d53c6?rik=5oQzBpO6lDgt9g&riu=http%3a%2f%2fwww.solidbackgrounds.com%2fimages%2f2880x1800%2f2880x1800-light-gray-solid-color-background.jpg&ehk=an3tuTn09XTjenq4X5b1lFPbxVC62AK6OIyHLx2CvrQ%3d&risl=&pid=ImgRaw&r=0' }}" 
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
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">Guardar Producto</button>
            </div>
        </form>
    </div>
</x-layouts.app>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purchaseInput = document.getElementById('purchase_price');
        const soldInput = document.getElementById('sold_price');
        const marginInput = document.getElementById('margin');

        function calculateSalePrice() {
            const purchase = parseFloat(purchaseInput.value);
            const margin = parseFloat(marginInput.value);

            if (!isNaN(purchase) && !isNaN(margin)) {
                const price = purchase * (1 + margin / 100);
                soldInput.value = price.toFixed(2);
                soldInput.min = purchase.toFixed(2);
            }
        }

        function calculateMargin() {
            const purchase = parseFloat(purchaseInput.value);
            const sold = parseFloat(soldInput.value);
            if (!isNaN(purchase) && !isNaN(sold) && purchase > 0) {
                const margin = ((sold - purchase) / purchase) * 100;
                marginInput.value = margin.toFixed(2);
            }
        }

        purchaseInput.addEventListener('input', function () {
            calculateMargin();
            calculateSalePrice();
        });

        soldInput.addEventListener('input', function () {
            calculateMargin();
        });

        calculateMargin();
        calculateSalePrice(); 
    });

    function previewImage(event, targetId) {
        const input = event.target;
        const preview = document.querySelector(targetId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => preview.src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

