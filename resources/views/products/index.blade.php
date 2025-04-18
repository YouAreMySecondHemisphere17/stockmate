<x-layouts.app>
    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Productos
            </flux:breadcrumbs.item>
        </flux:breadcrumbs> 
    
        <a href="{{ route('products.create') }}" class="btn text-xs px-6 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbddc]">
            Nuevo Producto
        </a> 
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($products as $product)
            <div 
                x-data="{ open: false, imageUrl: '' }" 
                class="rounded-lg overflow-hidden shadow-md bg-white hover:shadow-xl transition-shadow border border-[#faefbddc]"
            >
                <!-- Imagen -->
                <div 
                    @click="imageUrl = '{{ $product->image_path ? Storage::url($product->image_path) : '' }}'; open = true" 
                    class="cursor-pointer w-full h-40 bg-white flex items-center justify-center overflow-hidden rounded-t-lg"
                >                
                    @if($product['image_path'] ?? false)
                        <img 
                            src="{{ Storage::url($product->image_path) }}" 
                            alt="{{ $product['product_name'] }}" 
                            class="h-full object-contain"
                        >
                    @else
                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center font-bold">
                            Sin imagen
                        </div>
                    @endif
                </div>
                
                <!-- Info del producto -->
                <div class="p-4 text-black">
                    <h3 class="text-lg font-semibold mb-1">{{ $product['product_name'] }}</h3>
                    <p class="text-sm text-yellow-900 mb-2 font-medium">
                        Categoría: 
                        {{ 
                            is_array($product['category'] ?? null) 
                                ? ($product['category']['name'] ?? 'Sin categoría') 
                                : ($product['category']->name ?? 'Sin categoría') 
                        }}
                    </p>
                    <p class="text-sm text-green-600 mb-1 font-medium">Stock actual: {{ $product['current_stock'] }}</p>
                    <p class="text-sm text-red-600 mb-1 font-medium">Stock mínimo: {{ $product['minimum_stock'] }}</p>
                    
                    <p class="text-sm font-bold text-black">Precio: ${{ $product['sold_price'] }}</p>
                </div>

                <!-- Botones -->
                <div class="px-4 pb-4 flex justify-center items-center gap-2">
                    <a 
                        href="{{ route('products.edit', ['product' => $product['id']]) }}" 
                        class="btn text-xs px-4 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbd]"
                    >
                        Editar
                    </a>

                    <form 
                        action="{{ route('products.destroy', ['product' => $product['id']]) }}" 
                        method="POST" 
                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="btn text-xs px-4 py-2 rounded-lg bg-[#d9534f] text-white hover:bg-[#c9302c]"
                        >
                            Eliminar
                        </button>
                    </form>
                </div>

                <!-- Modal de imagen -->
                <div 
                    x-show="open" 
                    x-cloak 
                    @click.away="open = false"
                    class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center p-4"
                >
                    <div class="relative">
                        <!-- Botón cerrar -->
                        <button 
                            @click="open = false" 
                            class="absolute top-2 right-2 text-white text-3xl font-bold z-50 bg-black/50 rounded-full px-2 hover:bg-black"
                        >
                            &times;
                        </button>

                        <!-- Imagen -->
                        <img 
                            :src="imageUrl" 
                            class="max-w-full max-h-[90vh] rounded-lg z-10 relative"
                        >
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    
@push('js')
<script>
    forms = document.querySelectorAll('.delete-form');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminarlo",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        })
    });
</script>
@endpush

</x-layouts.app>
