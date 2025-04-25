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
    
        <a href="{{route('users.create')}}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
            Nuevo Usuario
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
                    <th scope="col" width="10px" class="text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td scope="row">
                            {{$user['id']}}
                        </td>
                        <td>
                            {{$user->name}}
                        </td>    
                        <td>
                            <div class="flex space-x-2">
                                <a href="{{route('users.edit', $user)}}" 
                                    class="btn-edit px-4 py-2"
                                >
                                    Editar
                                </a>
    
                                <form class="delete-form" action="{{route('users.destroy', $user)}}" method="POST">
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

    @push('js')
        <script src="{{ mix('js/deleteConfirmation.js') }}"></script> 
    @endpush
    
</x-layouts.app>