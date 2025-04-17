<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Categorías
            </flux:breadcrumbs.item>
        </flux:breadcrumbs> 
    
        <a href="{{ route('categories.create') }}" class="btn text-xs px-6 py-2 rounded-lg bg-[#9c8353da] text-amber-950 hover:bg-[#9c8353da]">
            Nueva Categoría
        </a>
    </div>

    <div class="mb-4">
        <form action="{{ route('categories.index') }}" method="GET">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar por nombre..." 
                class="text-s px-10 py-2 mr-3 rounded-lg border border-[#e5d3b3]"
                value="{{ request()->get('search') }}"
            >
            <button type="submit" class=" btn text-s px-4 py-2 rounded-lg bg-[#9c8353da] text-amber-950 hover:bg-[#9c8353da]">
                Buscar
            </button>
        </form>
    </div>
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
        <table class="w-full text-sm text-left rtl:text-right text-amber-950">
            <thead class="text-xs text-amber-950 uppercase bg-[#9c8353da]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3 text-center" width="10px">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="bg-white border-b border-[#e5d3b3]">
                        <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                            {{$category['id']}}
                        </th>
                        <td class="px-6 py-4">
                            {{$category['name']}}                        
                        </td>     
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', ['category' => $category['id']]) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#9c8353da] text-amber-950 hover:bg-[#9c8353da]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{ route('categories.destroy', ['category' => $category['id']]) }}" method="POST">
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
