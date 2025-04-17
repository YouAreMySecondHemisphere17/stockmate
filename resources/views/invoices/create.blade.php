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

        <div class="invoice-container">
            <div class="invoice-header">Factura de Venta</div>
        
            <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <div class="invoice-section">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="invoice-label">Cliente:</label>
                            <select name="customer_id" class="w-full border-gray-300 rounded-md">
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="invoice-label">N° Chalan:</label>
                            <input type="text" name="chalan_no" class="w-full border-gray-300 rounded-md" />
                        </div>
                        <div>
                            <label class="invoice-label">Fecha:</label>
                            <input type="date" name="sell_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly />
                        </div>
                    </div>
                </div>
        
                <div class="invoice-section">
                    <label class="invoice-label">Productos:</label>
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Descuento</th>
                            </tr>
                        </thead>
                        <tbody id="product-list">
                            <div id="product-list">
                                <div class="product-item flex space-x-4 mb-4" data-index="0">
                                        <label for="product_id_0" class="block text-sm font-medium text-gray-700">Producto</label>
                                        <select name="products[0][product_id]" id="product_id_0" class="w-full product-select border-gray-300 rounded-md" onchange="updatePrice(0)">
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{       $product->sold_price }}" data-stock="{{ $product->current_stock }}">
                                                {{ $product->product_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    
                                        <label for="sold_quantity_0" class="block text-sm font-medium text-gray-700">Cantidad</label>
                                        <input type="number" id="sold_quantity_0" name="products[0][sold_quantity]" value="1" min="1" max="products[0][current_stock]"
                                        class="w-full border-gray-300 rounded-md sold-quantity">
                
                                        <label for="sold_price_0" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                                        <input type="text" id="sold_price_0" name="products[0][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                
                                        <label for="total_sold_price_0" class="block text-sm font-medium text-gray-700">Total Venta</label>
                                        <input type="text" id="total_sold_price_0" name="products[0][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                
                                        <label for="discount_0" class="block text-sm font-medium text-gray-700">Descuento</label>
                                        <input type="text" id="discount_0" name="products[0][discount]" value="0" class="w-full border-gray-300 rounded-md discount" readonly>

                                        <div class="flex justify-center items-end pb-2">
                                            <button type="button" class="remove-product bg-red-500 text-white px-2 py-1 rounded-md">Eliminar</button>
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
                        </tbody>
                    </table>
                    <button type="button" id="invoiceProducts" class="mt-2 p-1 bg-blue-500 text-white rounded-md">+ Producto</button>
                </div>
        
                <div class="invoice-section total-section">
                    <p>Total: <input type="text" id="total_amount" name="total_amount" readonly class="border-gray-300 rounded-md w-40 text-right" /></p>
                    <p>Descuento Total: <input type="text" id="discount_amount" name="discount_amount" readonly class="border-gray-300 rounded-md w-40 text-right" /></p>
                </div>
        
                <div class="invoice-section">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="invoice-label">Método de Pago</label>
                            <select name="payment_method" class="w-full border-gray-300 rounded-md">
                                @foreach($methods as $method)
                                    <option value="{{ $method->value }}">{{ $method->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="invoice-label">Detalles del Pago</label>
                            <textarea name="details" class="w-full border-gray-300 rounded-md">{{ old('details') }}</textarea>
                        </div>
                    </div>

                    <div class="invoice-section bg-green-600">
                        <button type="submit" class="px-6 py-2 bg-green-600 text-black rounded-md shadow">Guardar Factura</button>
                    </div>
                </div>
            </form>        
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

<style>
    .invoice-container {
        max-width: 800px; /* Aproximadamente A4 */
        margin: auto;
        background-color: #fff;
        padding: 40px;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        font-family: 'Courier New', Courier, monospace;
    }

    .invoice-header {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 30px;
        text-transform: uppercase;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .invoice-section {
        margin-bottom: 20px;
        border-bottom: 1px dashed #ccc;
        padding-bottom: 10px;
    }

    .invoice-label {
        font-weight: bold;
        color: #333;
    }

    .invoice-table th,
    .invoice-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .total-section {
        font-weight: bold;
        font-size: 16px;
        text-align: right;
    }
</style>
