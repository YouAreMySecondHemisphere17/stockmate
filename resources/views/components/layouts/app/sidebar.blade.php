@php
$groups = [
    'General' => [
        [
            'name' => 'Inicio',
            'icon' => 'home',
            'url' => route('dashboard'),
            'current' => request()->routeIs('dashboard'),
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'user',
            'url' => route('users.index'),
            'current' => request()->routeIs('users.*'),
        ],
    ],
    'Gestión de Productos' => [
        [
            'name' => 'Categorías',
            'icon' => 'funnel',
            'url' => route('categories.index'),
            'current' => request()->routeIs('categories.*'),
        ],
        [
            'name' => 'Productos',
            'icon' => 'gift',
            'url' => route('products.index'),
            'current' => request()->routeIs('products.*'),
        ],
        [
            'name' => 'Proveedores',
            'icon' => 'truck',
            'url' => route('vendors.index'),
            'current' => request()->routeIs('vendors.*'),
        ],
    ],
    'Gestión de Clientes' => [
        [
            'name' => 'Clientes',
            'icon' => 'users',
            'url' => route('customers.index'),
            'current' => request()->routeIs('customers.*'),
        ],
    ],
    'Gestión de Existencias' => [
        [
            'name' => 'Entradas',
            'icon' => 'arrow-down-circle',
            'url' => route('entries.index'),
            'current' => request()->routeIs('entries.*'),
        ],
        [
            'name' => 'Salidas/Facturación',
            'icon' => 'minus-circle',
            'url' => route('invoices.index'),
            'current' => request()->routeIs('invoices.*'),
        ],
    ],
    'Gestión de Reportes' => [
        [
            'name' => 'Reportes',
            'icon' => 'folder',
            'url' => route('reports.index'),
            'current' => request()->routeIs('reports.*'),
        ],
    ],
];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #2D3A47; /* Gris oscuro azulado */
            color: #B0BEC5; /* Gris claro */
            padding-top: 20px;
            overflow-y: auto;
            border-right: 1px solid #394B59; /* Gris oscuro */
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #F8F8FF;
            min-height: 100vh;
        }

        .sidebar .sidebar-header {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 8px;
            padding-left: 20px;
            color: #E0E0E0; /* Gris claro */
        }

        .sidebar .nav-item {
            margin: 3px 0;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #B0BEC5; /* Gris claro */
            font-size: 15px;
            transition: background-color 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover {
            background-color: #394B59; /* Gris oscuro con toque azul */
            color: #FFFFFF; /* Blanco en hover */
        }

        .sidebar .nav-link.current {
            background-color: #F57C00; /* Naranja vibrante */
            border-left: 4px solid #FFFFFF; /* Resalta con blanco */
            font-weight: bold;
        }

        .sidebar .nav-link svg {
            margin-right: 10px;
        }

        .sidebar-settings {
            padding: 15px 20px;
            border-top: 1px solid #394B59; /* Gris oscuro */
        }

        .custom-dropdown {
            position: relative;
        }

        .custom-dropdown-button {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 5px 0;
            color: #E0E0E0; /* Gris claro */
        }

        .user-initial {
            background-color: #000;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border: 1px solid #ddd;
            min-width: 160px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
            z-index: 10;
        }

        .custom-dropdown-menu a,
        .custom-dropdown-menu button {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            font-size: 14px;
        }

        .custom-dropdown-menu a:hover,
        .custom-dropdown-menu button:hover {
            background-color: #f5f5f5;
        }

        .toggle-button {
            cursor: pointer;
            padding: 5px 10px;
            margin-left: auto;
            font-size: 18px;
            color: #E0E0E0;
        }

        .hidden-group {
            display: none;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; padding: 0 20px 20px;">
            <x-app-logo style="width: 32px; height: 32px;" />
            <span style="margin-left: 10px; font-weight: bold; font-size: 17px; color: #FFFFFF;">StockMate</span>
        </a>

        <nav>
            @foreach ($groups as $group => $links)
                <div class="sidebar-group">
                    <div class="sidebar-header">
                        {{ $group }}
                        <span class="toggle-button" onclick="toggleGroup('{{ $group }}')">+</span>
                    </div>
                    <div class="nav-items {{ $group }} hidden-group">
                        @foreach ($links as $link)
                            <div class="nav-item">
                                <a href="{{ $link['url'] }}"
                                   class="nav-link {{ $link['current'] ? 'current' : '' }}">
                                    <x-icon name="{{ $link['icon'] }}" style="width: 18px; height: 18px;" />
                                    <span>{{ $link['name'] }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>

        <div class="sidebar-settings">
            <div class="custom-dropdown">
                <button class="custom-dropdown-button" onclick="toggleDropdown()">
                    <span class="user-initial">{{ strtoupper(auth()->user()->name[0]) }}</span>
                    <span>{{ auth()->user()->name }}</span>
                </button>
                <div class="custom-dropdown-menu" id="userDropdown">
                    <a href="{{ route('settings.profile') }}">Configuración</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        {{ $slot }}
    </div>

    <script>
        function toggleGroup(groupName) {
            const group = document.querySelector(`.${groupName}`);
            const toggleButton = group.previousElementSibling.querySelector('.toggle-button');
            if (group.classList.contains('hidden-group')) {
                group.classList.remove('hidden-group');
                toggleButton.textContent = '-';
            } else {
                group.classList.add('hidden-group');
                toggleButton.textContent = '+';
            }
        }

        function toggleDropdown() {
            const menu = document.getElementById('userDropdown');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        document.addEventListener('click', function (e) {
            const dropdown = document.querySelector('.custom-dropdown');
            const menu = document.getElementById('userDropdown');
            if (!dropdown.contains(e.target)) {
                menu.style.display = 'none';
            }
        });
    </script>
</body>
</html>
