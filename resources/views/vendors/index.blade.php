<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Proveedores
            </flux:breadcrumbs.item>
        </flux:breadcrumbs> 
    
        <a href="{{route('vendors.create')}}" class="btn text-xs px-6 py-2 rounded-lg bg-[#fddde6] text-black hover:bg-[#fddde6]">
            Nuevo Proveedor
        </a> 
    </div>

    <div class="mb-4">
        <form action="{{ route('vendors.index') }}" method="GET">
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
                <button type="submit" class="btn text-s px-4 py-2 rounded-lg bg-[#fddde6] text-black hover:bg-[#fddde6]">
                    Buscar
                </button>
            </div>
        </form>
    </div>
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
        <table class="w-full text-sm text-left rtl:text-right text-black">
            <thead class="text-xs text-black uppercase bg-[#fddde6]">
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
                    <th scope="col" class="px-6 py-3 text-center" width="10px">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                    <tr class="bg-white border-b border-[#e5d3b3]">
                        <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                            {{$vendor['id']}} 
                        </th>
                        <td class="px-6 py-4">
                            {{$vendor['name']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$vendor['email']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$vendor['phone']}} 
                        </td>
                        <td class="px-6 py-4">
                            {{$vendor['address']}} 
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('vendors.edit', ['vendor' => $vendor['id']]) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#fddde6] text-black hover:bg-[#fddde6]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{ route('vendors.destroy', ['vendor' => $vendor['id']]) }}" method="POST">
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