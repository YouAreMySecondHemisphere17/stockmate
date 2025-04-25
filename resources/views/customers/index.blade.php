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
    </div>

    <div class="mb-4 flex justify-between items-center">
        <form action="{{ route('customers.index') }}" method="GET" class="flex items-center space-x-3">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar..."
                value="{{ request()->get('search') }}"
            >
            <select name="filter_type">
                <option value="">Seleccionar filtro</option>
                <option value="name" {{ request()->get('filter_type') == 'name' ? 'selected' : '' }}>Nombre</option>
                <option value="email" {{ request()->get('filter_type') == 'email' ? 'selected' : '' }}>Email</option>
                <option value="phone" {{ request()->get('filter_type') == 'phone' ? 'selected' : '' }}>Teléfono</option>
            </select>
            <button type="submit" class="btn btn-neutral text-s px-4 py-2 rounded-lg">
                Buscar
            </button>
        </form>
    
        <a href="{{ route('customers.create') }}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
            Nuevo Cliente
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
                        Nombre
                    </th>
                    <th scope="col">
                        Email
                    </th>
                    <th scope="col">
                        Teléfono
                    </th>
                    <th scope="col">
                        Dirección
                    </th>
                    <th scope="col">
                        Estado
                    </th>     
                    <th scope="col" class="text-center" width="10px">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td text-center whitespace-nowrap>
                            {{$customer['id']}} 
                        </td>
                        <td>
                            {{$customer['name']}} 
                        </td>
                        <td>
                            {{$customer['email']}} 
                        </td>
                        <td>
                            {{$customer['phone']}} 
                        </td>
                        <td>
                            {{$customer['address']}} 
                        </td>
                        <td>
                            {{$customer['status']}}
                        </td>  
                        <td>
                            <div class="flex space-x-2">
                                <a href="{{ route('customers.edit', ['customer' => $customer['id']]) }}" class="btn-edit px-4 py-2">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{ route('customers.destroy', ['customer' => $customer['id']]) }}" method="POST">
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
</x-layouts.app>