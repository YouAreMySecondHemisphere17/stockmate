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

    <a href="{{route('entries.create')}}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
        Registrar Entrada
    </a> 
</div>

<div>
    <table class="table-bordered">
        <thead>
            <tr>
                <th scope="col">
                    ID
                </th>
                <th scope="col">
                    Producto
                </th>
                <th scope="col">
                    Proveedor
                </th>
                <th scope="col">
                    Cantidad
                </th>
                <th scope="col">
                    Precio Unitario
                </th>
                <th scope="col">
                    Monto Total
                </th>
                <th scope="col">
                    Fecha
                </th>
                <th scope="col" width="10px" class="text-center">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td scope="row">
                        {{$entry->id}}
                    </td>
                    <td>
                        {{$entry->product->product_name}}
                    </td>
                    <td>
                        {{$entry->product->vendor->name}} 
                    </td>
                    <td>
                        {{$entry->quantity}}
                    </td>
                    <td>
                        {{$entry->product->purchase_price}} USD
                    </td>
                    <td>
                        {{$entry->total_amount}} USD
                    </td>
                    <td>
                        {{$entry->transaction_date}}
                    </td>    
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{route('entries.edit', $entry)}}" class="btn-edit px-4 py-2">
                                Editar
                            </a>

                            <form class="delete-form" action="{{route('entries.destroy', $entry)}}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn-delete px-4 py-2">
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