<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">
            Facturas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Ver
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="invoice-container">
        <div class="invoice-header">Factura de Venta</div>

        <div class="invoice-section">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="invoice-label">Cliente:</label>
                    <p>{{ $invoice->customer->name }}</p>
                </div>
                <div>
                    <label class="invoice-label">N° :</label>
                    <p>{{ $invoice->number }}</p>
                </div>
                <div>
                    <label class="invoice-label">Fecha:</label>
                    <p>{{ $invoice->sell_date }}</p>
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
                        <th>Precio Unitario</th>
                        <th>Descuento</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->sell_details as $item)
                        <tr>
                            <td>{{ $item->product->product_name }}</td>
                            <td>{{ $item->quantity_sold }}</td>
                            <td>{{ $item->sold_price }}</td>
                            <td>{{ $item->discount }}</td>
                            <td>{{ $item->total_sold_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-section">
            <div class="flex space-x-4">
                <div class="flex-1">
                    <label class="invoice-label">Monto Total:</label>
                    <p>{{ $invoice->total_amount }}</p>
                </div>
                <div class="flex-1">
                    <label class="invoice-label">Descuento Total:</label>
                    <p>{{ $invoice->discount_amount }}</p>
                </div>
            </div>
        </div>

        <div class="invoice-section">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="invoice-label">Método de Pago:</label>
                    <p>{{ $invoice->payment->payment_method }}</p>
                </div>
                <div>
                    <label class="invoice-label">Detalles del Pago:</label>
                    <p>{{ $invoice->payment->details }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

<style>
    .invoice-container {
        max-width: 1000px; /* Aumentado de 800px a 1000px */
        margin: auto;
        background-color: #fffefeee;
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
