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

    <div class="mb-4">
        <form action="{{ route('customers.index') }}" method="GET">
            <div class="flex items-center space-x-3">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Buscar..."
                    class="text-s px-10 py-2 mr-3 rounded-lg border border-[#e5d3b3]"
                    value="{{ request()->get('search') }}"
                >
                <select name="filter_type" class="text-s px-10 py-2 mr-3 rounded-lg border border-[#e5d3b3]">
                    <option value="">Seleccionar filtro</option>
                    <option value="name" {{ request()->get('filter_type') == 'name' ? 'selected' : '' }}>Nombre</option>
                    <option value="email" {{ request()->get('filter_type') == 'email' ? 'selected' : '' }}>Email</option>
                    <option value="phone" {{ request()->get('filter_type') == 'phone' ? 'selected' : '' }}>Teléfono</option>
                </select>
                <button type="submit" class="btn text-s px-4 py-2 rounded-lg bg-[#e1f761be] text-black hover:bg-[#e1f761be]">
                    Buscar
                </button>
            </div>
        </form>
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
                            {{$customer['id']}} 
                        </th>
                        <td class="px-6 py-4">
                            {{$customer['name']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$customer['email']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$customer['phone']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$customer['address']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$customer['status']}}
                        </td>  
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('customers.edit', ['customer' => $customer['id']]) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#e1f761be] text-black hover:bg-[#e1f761be]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{ route('customers.destroy', ['customer' => $customer['id']]) }}" method="POST">
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
</x-layouts.app>