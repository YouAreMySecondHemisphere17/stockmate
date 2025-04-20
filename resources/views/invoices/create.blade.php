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
                        <label class="invoice-label">N°:</label>
                        <input type="text" name="number" value="{{ $number }}" class="w-full border-gray-300 rounded-md" readonly/>
                    </div>
                    <div>
                        <label class="invoice-label">Fecha:</label>
                        <input type="date" name="sell_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly />
                    </div>
                </div>
            </div>

            <div class="invoice-section mt-3">
                <label class="invoice-label">Productos:</label>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th colspan="5">Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>SubTotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        <tr class="product-item" data-index="0">
                            <td colspan="5">
                                <select name="products[0][product_id]" class="w-full product-select border-gray-300 rounded-md">
                                    <option value="">Toca Aquí</option>
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
                            <td class="text-center">
                                <button type="button" class="remove-product text-red-600 text-lg font-bold px-2" onclick="removeProduct(0)">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            
                <button type="button" id="add-product" class="mt-4 p-2 bg-blue-500 text-white rounded-md">Agregar Producto</button>
            </div>

           <div class="invoice-section mt-6">
                <table class="invoice-table">
                    <tbody>                       
                        <tr>
                            <td class="text-right font-bold">Monto Total:</td>
                            <td>
                                <input type="number" id="total_amount" name="total_amount" value="0" min="0" class="w-full border-gray-300 rounded-md" oninput="updatePrice()">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right font-bold">Descuento:</td>
                            <td>
                                <input type="number" id="discount" name="discount" value="0" min="0" class="w-full border-gray-300 rounded-md" oninput="updatePrice()">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right font-bold">IVA (15%):</td>
                            <td>
                                <input type="text" id="iva_amount" name="iva_amount" class="w-full border-gray-300 rounded-md" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right font-bold">Total con IVA:</td>
                            <td>
                                <input type="text" id="total_with_iva" name="total_with_iva" class="w-full border-gray-300 rounded-md" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Submit Button -->
            <div class="invoice-section mt-6">
                <button type="submit" class="px-6 py-2 bg-[#fca311] text-black rounded-md shadow">Guardar Factura y Pago</button>
            </div>            
        </form>
    </div>
</x-layouts.app>

<script>
    let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', function () {
        let productRow = `
            <tr class="product-item" data-index="${productIndex}">
                <td colspan="5">
                    <select name="products[${productIndex}][product_id]" class="w-full product-select border-gray-300 rounded-md">
                        <option value="">Toca Aquí</option>
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${productIndex}][sold_quantity]" value="1" min="1" class="w-full border-gray-300 rounded-md sold-quantity" onchange="updatePrice(${productIndex})">
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][sold_price]" class="w-full price-input border-gray-300 rounded-md" readonly>
                </td>
                <td>
                    <input type="text" name="products[${productIndex}][total_sold_price]" value="0" class="w-full total-sold-price border-gray-300 rounded-md" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="remove-product text-red-600 text-lg font-bold px-2" onclick="removeProduct(${productIndex})">X</button>
                </td>
            </tr>
        `;
        document.getElementById('product-list').insertAdjacentHTML('beforeend', productRow);
        initSelect2(productIndex);
        updateProductOptions();
        productIndex++;
    });

    function updatePrice(index = 0) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.sold-quantity');
        const priceInput = row.querySelector('.price-input');
        const totalInput = row.querySelector('.total-sold-price');

        if (!select.value) {
            priceInput.value = '';
            totalInput.value = '0.00';
            updateTotalAmount();
            return;
        }

        const price = parseFloat(select.selectedOptions[0].dataset.price || 0);
        const quantity = parseInt(quantityInput.value) || 1;
        const total = price * quantity;

        priceInput.value = price.toFixed(2);
        totalInput.value = total.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        let totalAmount = 0;
        document.querySelectorAll('.product-item').forEach(row => {
            const total = parseFloat(row.querySelector('.total-sold-price').value) || 0;
            totalAmount += total;
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        totalAmount -= discount;

        const iva = totalAmount * 0.15;
        const totalWithIva = totalAmount + iva;

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        document.getElementById('iva_amount').value = iva.toFixed(2);
        document.getElementById('total_with_iva').value = totalWithIva.toFixed(2);
    }

    function removeProduct(index) {
        const row = document.querySelector(`.product-item[data-index="${index}"]`);
        if (row) row.remove();
        updateTotalAmount();
        updateProductOptions();
    }

    function initSelect2(index = null) {
        if (index === null) {
            $('.product-select').select2({
                placeholder: 'Buscar producto...',
                width: '100%',
                ajax: {
                    url: '{{ route('product-search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(product => ({
                                id: product.id,
                                text: `${product.text}`,
                                price: product.price // Asegúrate de enviar el precio aquí
                            }))
                        };
                    },
                    cache: true
                }
            });
        } else {
            $(`select[name="products[${index}][product_id]"]`).select2({
                placeholder: 'Buscar producto...',
                width: '100%',
                ajax: {
                    url: '{{ route('product-search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(product => ({
                                id: product.id,
                                text: `${product.text}`,
                                price: product.price // Asegúrate de enviar el precio aquí
                            }))
                        };
                    },
                    cache: true
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateProductOptions();
        updatePrice(0);
        initSelect2();
    });
</script>



<style>

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
    
    .invoice-section input[type="text"] {
        width: 100%;
        max-width: 200px;
    }
    
    .invoice-section input[type="number"] {
        width: 100%;
        max-width: 200px;
    }
    
    .invoice-label {
        font-weight: bold;
        color: #333;
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
    
    .invoice-section .flex {
        display: flex;
        justify-content: flex-end;
    }
    
    .invoice-section .flex-1 {
        flex: 1;
    }    

</style>
