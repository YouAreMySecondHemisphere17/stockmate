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
        <form action="{{ route('categories.index') }}" method="GET" class="flex items-center space-x-3">
            <input
                type="text"
                name="search"
                placeholder="Buscar por nombre..."
                value="{{ request()->get('search') }}"
            >
            <button type="submit" class="btn btn-neutral text-s px-4 py-2 rounded-lg">
                Buscar
            </button>
        </form>

        <a href="{{ route('categories.create') }}" class="btn-primary text-s px-6 py-2 rounded-lg font-bold">
            Nueva Categoría
        </a>
    </div>


    <div>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="w-1/3">
                        ID
                    </th>
                    <th scope="col" class="w-1/3">
                        Nombre
                    </th>
                    <th scope="col" class="text-center">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody >
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">
                            {{$category['id']}}
                        </th>
                        <td>
                            {{$category['category_name']}}
                        </td>
                        <td>
                            <div class="flex space-x-2 justify-center">
                                <a href="{{ route('categories.edit', ['category' => $category['id']]) }}" class="btn-edit px-4 py-2">
                                    Editar
                                </a>

                                <form id="delete-form" class="delete-form" action="{{ route('categories.destroy', ['category' => $category['id']]) }}" method="POST">
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