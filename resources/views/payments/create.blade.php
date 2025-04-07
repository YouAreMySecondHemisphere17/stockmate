<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('invoices.index')" class="hover:text-blue-500">
            Facturas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Abonar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Registrar Pago</h2>

            <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
                @csrf

               <input type="hidden" id="sell_id" name="sell_id" value="{{ $invoice->id }}">
    
                <div class="flex">
                    <div class="flex-1 mr-3">
                        <div class="flex-1 mr-3">
                            <label for="date" class="block text-sm font-medium text-gray-700">Fecha del Pago</label>
                            <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-md" readonly>
                        </div>
                    </div>

                    <div class="flex-1 mr-3">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Monto del Pago</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', "0.01") }}" class="w-full border-gray-300 rounded-md" step="0.01" min="0.01">
                    </div>

                    <div class="flex-2">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Método De Pago</label>
                        <select name="payment_method" class="w-full border-gray-300 rounded-md">
                            @foreach($methods as $method)
                                <option value="{{ $method->value }}">{{ $method->value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div>
                    <label for="details" class="block text-sm font-medium text-gray-700">Detalles (Opcional)</label>
                    <textarea id="details" name="details" class="w-full border-gray-300 rounded-md">{{ old('details') }}</textarea>
                </div>
    

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Abonar</button>
            </div>
        </form>
    </div>
</x-layouts.app>