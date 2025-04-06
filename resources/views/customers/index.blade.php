<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Clientes
            </flux:breadcrumbs.item>
        </flux:breadcrumbs> 
    
        <a href="{{route('customers.create')}}" class="btn text-xs px-6 py-2 rounded-lg bg-[#e1f761be] text-black hover:bg-[#9c8353da]">
            Nuevo Cliente
        </a> 
    </div>
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
        <table class="w-full text-sm text-left rtl:text-right text-black">
            <thead class="text-xs text-black uppercase bg-[#e1f761be]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Teléfono
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Dirección
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
                @foreach ($customers as $customer)
                    <tr class="bg-white border-b border-[#e5d3b3]">
                        <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                            {{$customer->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$customer->customer_name}}
                        </td>
                        <td class="px-6 py-4">
                            {{$customer->email}}
                        </td>
                        <td class="px-6 py-4">
                            {{$customer->phone}}
                        </td>
                        <td class="px-6 py-4">
                            {{$customer->address}}
                        </td>
                        <td class="px-6 py-4">
                            {{$customer->status}}
                        </td>  
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{route('customers.edit', $customer)}}" class="btn text-xs px-4 py-2 rounded-lg bg-[#e1f761be] text-black hover:bg-[#e1f761be]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{route('customers.destroy', $customer)}}" method="POST">
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
        {{ $customers->links() }}
    </div>
    
</x-layouts.app>