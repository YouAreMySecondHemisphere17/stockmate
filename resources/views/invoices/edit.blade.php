<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">
            Facturas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Factura</h2>

        <form action="{{ route('invoices.update', $invoice) }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-1">
                    <label for="payment_status" class="block text-sm font-medium text-gray-700">Estado de Pago</label>
                    <select name="payment_status" id="payment_status" class="w-full border-gray-300 rounded-md">
                        @foreach($paymentStatuses as $paymentStatus)
                        <option value="{{ $paymentStatus->value }}"
                            {{ (old('payment_status', $invoice->payment_status ?? '') == $paymentStatus->value) ? 'selected' : '' }}>
                            {{ $paymentStatus->value }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Actualizar</button>
            </div>
        </form>
    </div>
</x-layouts.app>