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

            <div class="flex-1 mr-3">
                <label for="customer_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <div class="relative">
                    <select name="customer_id" id="customer_id" class="w-full border-gray-300 rounded-md">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="new-customer-form" class="hidden mt-4">
                <h3 class="text-lg font-medium text-gray-700">Nuevo Cliente</h3>
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label for="new_customer_name" class="block text-sm font-medium text-gray-700">Nombre del Cliente</label>
                        <input type="text" id="new_customer_name" name="new_customer_name" class="w-full border-gray-300 rounded-md">
                    </div>
                    <div class="flex-1">
                        <label for="new_customer_email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" id="new_customer_email" name="new_customer_email" class="w-full border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="sell_date" class="block text-sm font-medium text-gray-700">Fecha de Venta</label>
                    <input type="date" id="sell_date" name="sell_date" value="{{ old('sell_date', date('Y-m-d')) }}" class="w-full border-gray-300 rounded-md">
                </div>

                <div class="flex-1 mr-3">
                    <label for="chalan_no" class="block text-sm font-medium text-gray-700">Número de Chalan</label>
                    <input type="text" id="chalan_no" name="chalan_no" value="{{ old('chalan_no') }}" placeholder="Chalan No." class="w-full border-gray-300 rounded-md">
                </div>

                <div class="flex-1 mr-3">
                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Método de Pago</label>
                    <select name="payment_method" id="payment_method" class="w-full border-gray-300 rounded-md">
                        @foreach($paymentMethods as $paymentMethod)
                            <option value="{{ $paymentMethod->value }}">{{ $paymentMethod->value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label for="payment_status" class="block text-sm font-medium text-gray-700">Estado de Pago</label>
                    <select name="payment_status" id="payment_status" class="w-full border-gray-300 rounded-md">
                        @foreach($paymentStatuses as $paymentStatus)
                            <option value="{{ $paymentStatus->value }}">{{ $paymentStatus->value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h3 class="text-lg font-medium text-gray-700 mt-6 mb-2">Productos</h3>

            <div id="product-list">
                <div class="product-item flex space-x-4 mb-4" data-index="0">
                    <div class="flex-2">
                        <label for="product_id_0" class="block text-sm font-medium text-gray-700">Producto</label>
                        <select name="products[0][product_id]" id="product_id_0" class="w-full product-select border-gray-300 rounded-md" onchange="updatePrice(0)">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->sold_price }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1">
                        <label for="sold_quantity_0" class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input type="number" id="sold_quantity_0" name="products[0][sold_quantity]" value="1" min="1" class="w-full border-gray-300 rounded-md sold-quantity">
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

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Factura</button>
            </div>
        </form>
    </div>
</x-layouts.app>