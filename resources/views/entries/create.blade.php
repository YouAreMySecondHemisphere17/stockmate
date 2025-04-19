<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('entries.index')" class="hover:text-blue-500">
            Entradas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Nueva
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Registrar Entrada</h2>

        <form action="{{ route('entries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf

            <div class="flex">
                <div class="flex-2 mr-3">
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Productos</label>
                    <select name="product_id" id="product_id" class="w-full border-gray-300 rounded-md">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->product_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-2">
                    <label for="vendor_id" class="block text-sm font-medium text-gray-700">Proveedor</label>
                    <select name="vendor_id" id="vendor_id" class="w-full border-gray-300 rounded-md">
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Fecha de Compra</label>
                    <input type="date" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly>
                </div>

                <div class="flex-1 mr-3">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Monto Total</label>
                    <input type="number" id="total_amount" name="total_amount"
                    value="{{ old('total_amount', '0.00') }}"
                    class="w-full border-gray-300 rounded-md bg-gray-100"
                    step="0.01" readonly>
                </div>

                <div class="flex-1 mr-3">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad del Producto</label>
                    <input type="number" id="quantity" name="quantity" value="{{ old('quantity', "1") }}" class="w-full border-gray-300 rounded-md" step="1" min="1" max="999999">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Entrada</button>
            </div>
        </form>
    </div>
</x-layouts.app>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const totalAmountInput = document.getElementById('total_amount');

        function calculateTotal() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = parseFloat(selectedOption.dataset.price || 0);
            const quantity = parseInt(quantityInput.value || 1);
            const total = (price * quantity).toFixed(2);
            totalAmountInput.value = total;
        }

        productSelect.addEventListener('change', calculateTotal);
        quantityInput.addEventListener('input', calculateTotal);

        calculateTotal();
    });
</script>
