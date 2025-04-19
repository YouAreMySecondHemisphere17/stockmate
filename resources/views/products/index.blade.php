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
    </div>

    <div class="mb-4">
        <form action="{{ route('products.index') }}" method="GET">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Buscar..."
                        class="text-s px-10 py-2 rounded-lg border border-[#faefbddc]"
                        value="{{ request()->get('search') }}"
                    >
                    <select name="filter_type" class="text-s px-10 py-2 rounded-lg border border-[#faefbddc]">
                        <option value="">Seleccionar filtro</option>
                        <option value="product_name" {{ request()->get('filter_type') == 'product_name' ? 'selected' : '' }}>Nombre</option>
                        <option value="category_id" {{ request()->get('filter_type') == 'category_id' ? 'selected' : '' }}>Categoría</option>
                    </select>
                    <button type="submit" class="btn text-s px-4 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbddc]">
                        Buscar
                    </button>
                </div>
    
                <a 
                    href="{{ route('products.create') }}" 
                    class="btn text-s px-6 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbddc]"
                >
                    Nuevo Producto
                </a> 
            </div>
        </form>
    </div>    

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
        @foreach ($products as $product)
            <div 
                x-data="{ open: false, imageUrl: '', showDetails: false }" 
                class="rounded-lg overflow-hidden shadow-md bg-white hover:shadow-xl transition-shadow border border-[#faefbddc]"
            >
                <!-- Imagen -->
                <div 
                    @click="imageUrl = '
                    {{ 
                                is_array($product['image_path']) 
                                    ? Storage::url($product['image_path'][0]) 
                                    : Storage::url($product['image_path'])
                    }}'; open = true" 
                    class="cursor-pointer w-full h-40 bg-white flex items-center justify-center overflow-hidden rounded-t-lg"
                >                
                    @if($product['image_path'] ?? false)
                        <img 
                            src="{{
                                is_array($product['image_path']) 
                                    ? Storage::url($product['image_path'][0]) 
                                    : Storage::url($product['image_path'])
                            }}"
                            class="h-full w-full object-contain"
                        >
                    @else
                        <img 
                            src="{{ asset('images/no_image.png') }}"
                            class="h-full w-full object-contain"
                        >
                    @endif
                </div>
                
                <!-- Info del producto -->
                <div class="p-4 text-black">
                    <h3 class="text-lg font-semibold mb-1 break-words">{{ $product['product_name'] }}</h3>
                    <p class="text-sm text-yellow-900 font-medium">
                        Categoría: {{ $product['category_name'] ?? 'Sin categoría' }}
                    </p>
                    <p class="text-sm text-green-600 font-medium">Stock actual: {{ $product['current_stock'] }}</p>
                    <p class="text-sm text-red-600 mb-1 font-medium">Stock mínimo: {{ $product['minimum_stock'] }}</p>
                    <p class="text-sm font-bold text-black">Precio: ${{ $product['sold_price'] }}</p>
                </div> <!-- Detalles + Botones en la misma fila -->
                <div class="mb-2 border-t border-gray-200 pt-2 px-4 flex items-center justify-between gap-2">
                    
                    <!-- Ver detalles toggle -->
                    <button 
                        @click="showDetails = !showDetails"
                        class="text-xs text-blue-600 font-medium hover:underline transition duration-200"
                    >
                        <span x-show="!showDetails">➕ Ver detalles</span>
                        <span x-show="showDetails">➖ Ocultar detalles</span>
                    </button>
                
                    <!-- Botones Editar y Eliminar -->
                    <div class="flex items-center gap-2">
                        <a 
                            href="{{ route('products.edit', ['product' => $product['id']]) }}" 
                            class="btn text-xs px-4 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbd]"
                        >
                            Editar
                        </a>
                
                        <form 
                            action="{{ route('products.destroy', ['product' => $product['id']]) }}" 
                            method="POST" 
                            class="delete-form"
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
                </div>
                
                <!-- Contenido de los detalles -->
                <div 
                    x-show="showDetails" 
                    x-collapse 
                    x-transition 
                    class="text-sm text-gray-800 bg-gray-50 p-2 rounded-md border border-gray-100 mx-4 mb-4"
                >
                    {{ $product['details'] ?? 'Sin detalles disponibles.' }}
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

    @if (!request()->has('search'))
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif

    
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
