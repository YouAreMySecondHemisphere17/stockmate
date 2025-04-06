<x-layouts.app>

    <div class="mb-4 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item :href="route('dashboard')">
                Dashboard
            </flux:breadcrumbs.item>
            <flux:breadcrumbs.item>
                Usuarios
            </flux:breadcrumbs.item>
        </flux:breadcrumbs> 
    
        <a href="{{route('users.create')}}" class="btn text-xs px-6 py-2 rounded-lg bg-[#8398f3da] text-black hover:bg-[#8398f3da]">
            Nuevo Usuario
        </a> 
    </div>
    
    <div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
        <table class="w-full text-sm text-left rtl:text-right text-black">
            <thead class="text-xs text-black uppercase bg-[#8398f3da]">
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
                @foreach ($users as $user)
                    <tr class="bg-white border-b border-[#e5d3b3]">
                        <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                            {{$user->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$user->name}}
                        </td>    
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{route('users.edit', $user)}}" class="btn text-xs px-4 py-2 rounded-lg bg-[#8398f3da] text-black hover:bg-[#8398f3da]">
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{route('users.destroy', $user)}}" method="POST">
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