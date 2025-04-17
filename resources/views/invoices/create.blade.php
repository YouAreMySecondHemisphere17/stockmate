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
                        <input type="text" name="chalan_no"  value="{{ $chalanNo }}" class="w-full border-gray-300 rounded-md" readonly/>
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
                            <th colspan="5">Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Descuento</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <!-- Initial Product Row, starting from index 0 -->
                        <tr class="product-item" data-index="0">
                            <td colspan="5">
                                <select name="products[0][product_id]" class="w-full product-select border-gray-300 rounded-md" onchange="updatePrice(0)">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->sold_price }}" data-stock="{{ $product->current_stock }}">
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="products[0][sold_quantity]" value="1" min="1" class="w-full border-gray-300 rounded-md sold-quantity" onchange="updatePrice(0)">
                            </td>
                            <td>
                                <input type="text" name="products[0][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                            </td>
                            <td>
                                <input type="text" name="products[0][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                            </td>
                            <td>
                                <input type="text" name="products[0][discount]" value="0" class="w-full discount border-gray-300 rounded-md" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="add-product" class="mt-4 p-2 bg-blue-500 text-white rounded-md">Agregar Producto</button>

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
    </div>
</x-layouts.app>

<script>
    let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', function() {
        let productRow = `
            <tr class="product-item" data-index="${productIndex}">
                <td colspan="5">
                    <select name="products[${productIndex}][product_id]" class="w-full product-select border-gray-300 rounded-md"
                        onchange="updatePrice(${productIndex})">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->sold_price }}" data-stock="{{ $product->current_stock }}">
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][sold_quantity]" value="1" min="1"
                        class="w-full border-gray-300 rounded-md sold-quantity"
                        onchange="updatePrice(${productIndex})">
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][total_sold_price]" value="0"
                        class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][discount]" value="0"
                        class="w-full discount border-gray-300 rounded-md" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="remove-product text-red-600 text-lg font-bold px-2"
                        onclick="removeProduct(${productIndex})">X</button>
                </td>
            </tr>
        `;
        document.getElementById('product-list').insertAdjacentHTML('beforeend', productRow);
        updatePrice(productIndex);
        productIndex++;
    });

    function updatePrice(index) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.sold-quantity');
        const priceInput = row.querySelector('.price-input');
        const totalInput = row.querySelector('.total-sold-price');
        const discountInput = row.querySelector('.discount');

        const price = parseFloat(select.selectedOptions[0].dataset.price || 0);
        const quantity = parseInt(quantityInput.value) || 1;

        let discountRate = quantity >= 12 ? 0.10 : 0;
        let discount = price * discountRate * quantity;
        let total = (price * quantity) - discount;

        priceInput.value = price.toFixed(2);
        discountInput.value = discount.toFixed(2);
        totalInput.value = total.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        let totalAmount = 0;
        let discountAmount = 0;

        document.querySelectorAll('.product-item').forEach(row => {
            const total = parseFloat(row.querySelector('.total-sold-price').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            totalAmount += total;
            discountAmount += discount;
        });

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('discount_amount').value = discountAmount.toFixed(2);
    }

    function removeProduct(index) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        if (row) row.remove();
        updateTotalAmount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updatePrice(0);
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
