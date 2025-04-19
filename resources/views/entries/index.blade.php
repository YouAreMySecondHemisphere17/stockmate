<x-layouts.app>

<div class="mb-4 flex justify-between items-center">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Entradas
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <a href="{{route('entries.create')}}" class="btn text-s px-6 py-2 rounded-lg bg-[#b1f7cd] text-black hover:bg-[#b1f7cd]">
        Registrar Entrada
    </a> 
</div>

<div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
    <table class="w-full text-sm text-left rtl:text-right text-black">
        <thead class="text-xs text-black uppercase bg-[#b1f7cd]">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Producto
                </th>
                <th scope="col" class="px-6 py-3">
                    Proveedor
                </th>
                <th scope="col" class="px-6 py-3">
                    Precio
                </th>
                <th scope="col" class="px-6 py-3">
                    Cantidad
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr class="bg-white border-b border-[#e5d3b3]">
                    <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                        {{$entry->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$entry->product->product_name}}
                    </td>
                    <td class="px-6 py-4">
                        {{$entry->vendor->name}} 
                    </td>
                    <td class="px-6 py-4">
                        {{$entry->price}} USD
                    </td>
                    <td class="px-6 py-4">
                        {{$entry->quantity}}
                    </td>
                    <td class="px-6 py-4">
                        {{$entry->transaction_date}}
                    </td>    
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{route('entries.edit', $entry)}}" class="btn text-xs px-4 py-2 rounded-lg bg-[#b1f7cd] text-black hover:bg-[#c0f0d3]">
                                Editar
                            </a>

                            <form class="delete-form" action="{{route('entries.destroy', $entry)}}" method="POST">
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
        {{ $entries->links() }}
    /div>

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script> 
    @endpush

</x-layouts.app>