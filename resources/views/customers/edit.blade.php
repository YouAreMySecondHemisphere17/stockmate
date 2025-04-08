<x-layouts.app>

    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('customers.index')" class="hover:text-blue-500">
            Clientes
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Editar
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Editar Cliente</h2>

        <form action="{{ route('customers.update', ['customer' => $customer['id']]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            <div class="flex">
                <div class="flex-5 mr-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $customer['name']) }}" placeholder="Escribe el nombre del cliente." class="w-full border-gray-300 rounded-md">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
               </div>  

               <div class="flex-2 mr-3">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer['phone']) }}" placeholder="Escriba el teléfono del cliente." class="w-full border-gray-300 rounded-md">
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  
                
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>

                    <select name="status" class="w-full border-gray-300 rounded-md">
                        @foreach($statuses as $status)
                        <option value="{{ $status->value }}"
                            {{ (old('status', $customer['status']->value ?? '') == $status->value) ? 'selected' : '' }}>
                            {{ $status->value }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex">
                <div class="flex-5 mr-3">
                    <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input type="text" name="address" value="{{ old('address', $customer['address']) }}" placeholder="Escribe la dirección del cliente." class="w-full border-gray-300 rounded-md">
                    @error('address')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  

                <div class="flex-3 mr-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="{{ old('email', $customer['email']) }}" placeholder="Escriba el email del cliente." class="w-full border-gray-300 rounded-md">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  
            </div>  

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Cliente</button>
            </div>
        </form>
    </div>
</x-layouts.app>
