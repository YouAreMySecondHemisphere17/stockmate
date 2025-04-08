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
    
        <a href="{{route('products.create')}}" class="btn text-xs px-6 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbddc]">
            Nuevo Producto
        </a> 
    </div>
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#faefbddc]">
        <table class="w-full text-sm text-left rtl:text-right text-black">
            <thead class="text-xs text-black uppercase bg-[#faefbddc]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Categoría
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Detalles                   
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stock
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Stock Mínimo (Crítico)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio de Venta
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>   
                    <th scope="col" class="px-6 py-3 text-center" width="10px">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="bg-white border-b border-[#e5d3b3]">
                        <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                            {{$product->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$product->product_name}}
                        </td>
                        <td class="px-6 py-4">
                            {{$product->category->name}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-h-20 overflow-y-auto">
                                {{$product->details}}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{$product->current_stock}}
                        </td>
                        <td class="px-6 py-4">
                            {{$product->minimum_stock}}
                        </td>
                        <td class="px-6 py-4">
                            {{$product->sold_price}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                {{$product->status}}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{route('products.edit', $product)}}" class="btn text-xs px-4 py-2 rounded-lg bg-[#faefbddc] text-black hover:bg-[#faefbddc]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{route('products.destroy', $product)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
    
                                    <button class="btn text-xs px-4 py-2 rounded-lg bg-[#d9534f] text-white hover:bg-[#c9302c]">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>      
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
    
</x-layouts.app>