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
    </div>

    <div class="mb-4 flex justify-between items-center">
        <form action="{{ route('vendors.index') }}" method="GET" class="flex items-center space-x-3">
            <input
                type="text"
                name="search"
                placeholder="Buscar..."
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

        <a href="{{ route('vendors.create') }}" class="btn btn-primary text-s px-6 py-2 rounded-lg">
            Nuevo Proveedor
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
                    <th scope="col" width="10px" class="text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $vendor)
                    <tr>
                        <td scope="row">
                            {{$vendor['id']}}
                        </td>
                        <td>
                            {{$vendor['name']}}
                        </td>
                        <td>
                            {{$vendor['email']}}
                        </td>
                        <td>
                            {{$vendor['phone']}}
                        </td>
                        <td>
                            {{$vendor['address']}}
                        </td>
                        <td text-center whitespace-nowrap>
                            <div class="flex space-x-2">
                                <a href="{{ route('vendors.edit', ['vendor' => $vendor['id']]) }}" class="btn-edit px-4 py-2">
                                    Editar
                                </a>

                                <form class="delete-form" action="{{ route('vendors.destroy', ['vendor' => $vendor['id']]) }}" method="POST">
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