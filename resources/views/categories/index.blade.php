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
    </div>

    <div class="mb-4 flex justify-between items-center">
        <form action="{{ route('categories.index') }}" method="GET" class="flex items-center">
            <input 
                type="text" 
                name="search" 
                placeholder="Buscar por nombre..." 
                class="text-s px-10 py-2 mr-3 rounded-lg border border-[#e5d3b3]"
                value="{{ request()->get('search') }}"
            >
            <button type="submit" class="btn text-s px-4 py-2 rounded-lg bg-[#A6D7C1] text-black hover:bg-[#A6D7C1]">
                Buscar
            </button>
        </form>
    
        <a href="{{ route('categories.create') }}" class="btn text-s px-6 py-2 rounded-lg bg-[#A6D7C1] text-black hover:bg-[#A6D7C1]">
            Nueva Categoría
        </a>
    </div>
    
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
        <table class="w-full text-sm text-left rtl:text-right text-black">
            <thead class="text-xs text-black uppercase bg-[#A6D7C1]">
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
                            {{$category['category_name']}}                        
                        </td>     
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('categories.edit', ['category' => $category['id']]) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#A6D7C1] text-black hover:bg-[#A6D7C1">
                                    Editar
                                </a> 
                                
                                <form id="delete-form" class="delete-form" action="{{ route('categories.destroy', ['category' => $category['id']]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn text-xs px-4 py-2 rounded-lg bg-[#dd5954] text-white hover:bg-[#dd5954]">
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

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script> 
    @endpush
    
</x-layouts.app>
