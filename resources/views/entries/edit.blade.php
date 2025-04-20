<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('entries.index')" class="hover:text-blue-500">
            Entradas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="container-lightgray card p-6 shadow-lg rounded-lg bg-white border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Entrada</h2>

        <form action="{{ route('entries.update', $entry) }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-1 mr-3">
                    <label for="transaction_date" class="block text-sm font-medium text-gray-700">Fecha de Entrada</label>
                    <input 
                        type="datetime-local" 
                        id="transaction_date" 
                        name="transaction_date" 
                        value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" 
                        step="60"
                        class="w-full border-gray-300 rounded-md"
                    />
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Entrada</button>
            </div>
        </form>
    </div>
</x-layouts.app>