<x-layouts.app>
    <flux:breadcrumbs class="mb-4 text-gray-600">
        <flux:breadcrumbs.item :href="route('dashboard')" class="hover:text-blue-500">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('vendors.index')" class="hover:text-blue-500">
            Proveedores
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item class="text-blue-600">
            Nuevo
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <div class="container-lightgray card p-6 shadow-lg rounded-lg border border-gray-200 form-custom">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Registrar Nuevo Proveedor</h2>
        <form action="{{ route('vendors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    
            @csrf

            <div class="flex">
                <div class="flex-6 mr-3">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Escribe el nombre del proveedor" class="w-full border-gray-300 rounded-md">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
               </div>  

               <div class="flex-2 mr-3">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Escriba el teléfono del proveedor." class="w-full border-gray-300 rounded-md">
                    @error('phone')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  
            </div>

            <div class="flex">
                <div class="flex-5 mr-3">
                    <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Escribe la dirección del proveedor." class="w-full border-gray-300 rounded-md">
                    @error('address')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  

                <div class="flex-3 mr-3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Escriba el email del proveedor." class="w-full border-gray-300 rounded-md">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>  
            </div>  

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md">Guardar Proveedor</button>
            </div>
        </form>
    </div>
</x-layouts.app>