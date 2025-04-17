<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">
            Facturas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Nueva
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Registrar Nueva Factura</h2>

        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Cliente y Chalan -->
            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                    <select name="customer_id" id="customer_id" class="w-full border-gray-300 rounded-md">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div> 

                <div class="flex-1">
                    <label for="chalan_no" class="block text-sm font-medium text-gray-700">Número de Chalan</label>
                    <input type="text" id="chalan_no" name="chalan_no" value="{{ old('chalan_no') }}" placeholder="Chalan No." class="w-full border-gray-300 rounded-md">
                </div> 
            </div>

            <!-- Fecha -->
            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="sell_date" class="block text-sm font-medium text-gray-700">Fecha de Venta</label>
                    <input type="date" id="sell_date" name="sell_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly>
                </div>
            </div>

            <!-- Productos -->
       
            <h3 class="text-lg font-medium text-gray-700 mt-6 mb-2">Productos</h3>

            <div id="product-list">
                <div class="product-item flex space-x-4 mb-4" data-index="0">
                    <div class="flex-2">
                        <label for="product_id_0" class="block text-sm font-medium text-gray-700">Producto</label>
                        <select name="products[0][product_id]" id="product_id_0" class="w-full product-select border-gray-300 rounded-md" onchange="updatePrice(0)">
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{       $product->sold_price }}" data-stock="{{ $product->current_stock }}">
                                {{ $product->product_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex-1">
                        <label for="sold_quantity_0" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input type="number" id="sold_quantity_0" name="products[0][sold_quantity]" value="1" min="1" max="products[0][current_stock]"
                        class="w-full border-gray-300 rounded-md sold-quantity">
                    </div>

                    <div class="flex-1">
                        <label for="sold_price_0" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                        <input type="text" id="sold_price_0" name="products[0][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                    </div>

                    <div class="flex-1">
                        <label for="total_sold_price_0" class="block text-sm font-medium text-gray-700">Total Venta</label>
                        <input type="text" id="total_sold_price_0" name="products[0][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                    </div>

                    <div class="flex-1">
                        <label for="discount_0" class="block text-sm font-medium text-gray-700">Descuento</label>
                        <input type="text" id="discount_0" name="products[0][discount]" value="0" class="w-full border-gray-300 rounded-md discount" readonly>
                    </div>
                </div>
            </div>

            <button type="button" id="invoiceProducts" class="mt-4 p-2 bg-blue-500 text-white rounded-md">Agregar Producto</button>

            <div class="flex space-x-4 mt-6">
                <div class="flex-1">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Monto Total</label>
                    <input type="text" id="total_amount" name="total_amount" class="w-full border-gray-300 rounded-md" readonly>
                </div>
                <div class="flex-1">
                    <label for="discount_amount" class="block text-sm font-medium text-gray-700">Descuento Total</label>
                    <input type="text" id="discount_amount" name="discount_amount" class="w-full border-gray-300 rounded-md" readonly>
                </div>
            </div>                        
            
            <!-- Pago -->
            <h3 class="text-lg font-semibold mt-6 text-gray-800">Pago</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                    <select name="payment_method" id="payment_method" class="w-full border-gray-300 rounded-md">
                        @foreach($methods as $method)
                            <option value="{{ $method->value }}">{{ $method->value }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="details" class="block text-sm font-medium text-gray-700">Detalles del Pago (opcional)</label>
                    <textarea name="details" id="details" class="w-full border-gray-300 rounded-md">{{ old('details') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Factura y Registrar Pago</button>
            </div>
        </form>
    </div>
</x-layouts.app>


<script>
    // Cuando se cambia el producto, actualiza precio y stock
    function updatePrice(index) {
        const productSelect = document.getElementById(`product_id_${index}`);
        const selectedOption = productSelect.options[productSelect.selectedIndex];

        const price = selectedOption.dataset.price;
        const stock = selectedOption.dataset.stock;

        // Actualiza precio
        const priceInput = document.getElementById(`sold_price_${index}`);
        priceInput.value = price;

        // Actualiza stock en el input de cantidad
        const qtyInput = document.getElementById(`sold_quantity_${index}`);
        qtyInput.setAttribute('data-stock', stock);
        qtyInput.setAttribute('max', stock); // opcional

        // Forzamos validación por si hay una cantidad anterior inválida
        if (parseInt(qtyInput.value) > parseInt(stock)) {
            alert(`La cantidad no puede ser mayor al stock disponible (${stock})`);
            qtyInput.value = stock;
        }
    }

    // Validar stock al escribir en el campo cantidad
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('sold-quantity')) {
            const input = e.target;
            const stock = parseInt(input.dataset.stock);
            const value = parseInt(input.value);

            if (value > stock) {
                alert(`La cantidad no puede ser mayor al stock disponible (${stock})`);
                input.value = stock;
            }
        }
    });
</script>