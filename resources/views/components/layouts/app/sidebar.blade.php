@php
$groups = [
    'General' => [
        [
            'name' => 'Inicio',
            'icon' => 'home',
            'url' => route('dashboard'),
            'bg_color' => 'bg-dashboard',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('dashboard'),
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'user',
            'bg_color' => 'bg-users',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('users.index'),
            'current' => request()->routeIs('users.*'),
        ],
    ],
    'Gestión de Productos' => [
        [
            'name' => 'Categorías',
            'icon' => 'funnel',
            'url' => route('categories.index'),
            'bg_color' => 'bg-categories',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('categories.*'),
        ],
        [
            'name' => 'Productos',
            'icon' => 'gift',
            'bg_color' => 'bg-products',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('products.index'),
            'current' => request()->routeIs('products.*'),
        ],
        [
            'name' => 'Proveedores',
            'icon' => 'truck',
            'bg_color' => 'bg-providers',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('vendors.index'),
            'current' => request()->routeIs('vendors.*'),
        ],
    ],
    'Gestión de Clientes' => [
        [
            'name' => 'Clientes',
            'icon' => 'users',
            'bg_color' => 'bg-customers',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('customers.index'),
            'current' => request()->routeIs('customers.*'),
        ],
    ],
    'Gestión de Existencias' => [
        [
            'name' => 'Entradas',
            'icon' => 'arrow-down-circle',
            'bg_color' => 'bg-units',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('entries.index'),
            'current' => request()->routeIs('entries.*'),
        ],
        [
            'name' => 'Salidas/Facturación',
            'icon' => 'minus-circle',
            'bg_color' => 'bg-sales',
            'text_color' => 'text-black',
            'font_class' => 'font-semibold text-lg',
            'url' => route('invoices.index'),
            'current' => request()->routeIs('invoices.*'),
        ],
    ],
];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px; 
            background-color: #ffffff; 
            color: #1f2937;
            padding-top: 10px;
            overflow-y: auto;
            margin-left: 2px;
            margin-right: 2px;
        }

        .main-content {
            margin-left: 250px; 
            padding: 20px;
            min-height: 100vh;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 8px; 
            color: inherit;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar .header {
            font-size: 16px;
            font-weight: 700; 
            color: #1e3a8a;
            text-transform: uppercase;
            margin-top: 10px;
            padding-left: 10px;
            background-color: #f3f4f6; 
            border-radius: 6px;
            margin-bottom: 8px;
            border: 2px solid #1e3a8a; 
            padding: 10px 12px;
            font-weight: 1000;
        }

        .sidebar .nav-item {
            font-size: 12px; 
            font-weight: 500;
            border-radius: 18px;
            margin-bottom: 8px;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-item:hover {
            background-color: #f1f1f1;
        }

        .sidebar .nav-item.bg-gray-300 {
            background-color: #e2e8f0; 
        }

        .sidebar .nav-item.text-black {
            color: #1f2937;
        }

        .sidebar .nav-item a:hover {
            background-color: #ddd; 
        }

        .sidebar-settings {
            background-color: #ffffff; 
            font-size: 12px; 
            font-weight: 500;
        }

        .sidebar-group {
            background-color: #ffffff; 
            font-size: 16px; 
            font-weight: 800;
            padding-left: 8px;
            padding-right: 8px;
        }

        .bg-dashboard { background-color: #a80eb6f6; color: #ffffff; }
        .bg-categories { background-color: #9c8353da; color: #ffffff; }
        .bg-units { background-color: #38ca44da; color: #ffffff; }
        .bg-products { background-color: #ffea8edc; color: #000000; }
        .bg-providers { background-color: #ff68c0; color: #ffffff; }
        .bg-customers { background-color: #f8f529be; color: #000000; }
        .bg-sales { background-color: #fca311; color: #000000; }
        .bg-users { background-color: #2f4ed6da; color: #ffffff; }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px; 
            }

            .main-content {
                margin-left: 200px;
            }
        }
    </style>

<style>
.custom-dropdown {
    position: fixed;
}

.custom-dropdown-button {
    display: flex;
    align-items: center;
    background: none;
    border: none;
    color: #000000;
    cursor: pointer;
    padding: 8px;
}

.user-initial {
    background-color: #000000;
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    margin-right: 10px;
}

.user-name {
    font-size: 16px;
    color: #000000;
}

.custom-dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgb(255, 255, 255);
    border: 1px solid #000000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 160px;
    z-index: 1;
}

.custom-dropdown-item {
    padding: 8px 16px;
    font-size: 16px;
    text-decoration: none;
    text-align: center;
    display: block;
    color: #000000;
}

.custom-dropdown-item:hover {
    background-color: #a7a7a7;
}

</style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <div class="sidebar sticky stashable border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse">
            <x-app-logo />
            <div class="ms-1 grid flex-1 text-start text-sm bg-white">
                <span class="mb-0.5 truncate leading-none font-semibold" style="font-size: 20px; background-color: white;">StockMate</span>
            </div>
        </a>

        <nav class="sidebar-group space-y-2 mt-5">
            @foreach ($groups as $group => $links)
                <div class="space-y-2">
                    <div class="sidebar-header">{{ $group }}</div>
                    @foreach ($links as $link)
                        <div class="{{ $link['bg_color'] ?? '' }} rounded-md">
                            <a href="{{ $link['url'] }}"
                            class="flex items-center space-x-2 p-2 rounded-md 
                                   {{ $link['text_color'] ?? 'text-black' }} 
                                   {{ $link['font_class'] ?? '' }} 
                                   {{ $link['current'] ? 'border-3 border-black bg-gray-300' : '' }}">
                         
                                    <x-icon name="{{ $link['icon'] }}" />
                                    <span>{{ $link['name'] }}</span>
                                </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </nav>

    <div class="sidebar-settings p-2">
        <div class="custom-dropdown">
            <button class="custom-dropdown-button" onclick="toggleDropdown()">
                <span class="user-initial">{{ strtoupper(auth()->user()->name[0]) }}</span>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </button>
            <div class="custom-dropdown-menu">
                <div style="text-align: center;">
                    <a href="{{ route('settings.profile') }}" class="custom-dropdown-item"
                    style="width: 100%; text-align-last: left; font-size: 14px; ">
                        <i class="fas fa-cogs mr-3"></i> Configuración
                    </a>
                </div>

                <div style="text-align: center;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                            <button type="submit" class="custom-dropdown-item wi" style="width: 100%; text-align-last: left; font-size: 14px;">
                                <i class="fas fa-sign-out-alt mr-3"></i> Cerrar Sesión
                            </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>  
    <div class="main-content">
        {{ $slot }}
    </div>
</body>
</html>

<script>
    function toggleDropdown() {
        const menu = document.querySelector('.custom-dropdown-menu');
        const dropdownButton = document.querySelector('.custom-dropdown-button');
        const rect = dropdownButton.getBoundingClientRect();
    
        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
    
        if (menu.style.display === 'block') {
            menu.style.top = 'auto';
            menu.style.bottom = `${window.innerHeight - rect.top}px`;
            menu.style.left = `${rect.left}px`;
            menu.style.position = 'fixed'; // 
        }
    }
    
    document.addEventListener('click', function (e) {
        const dropdown = document.querySelector('.custom-dropdown');
        if (!dropdown.contains(e.target)) {
            const menu = document.querySelector('.custom-dropdown-menu');
            menu.style.display = 'none';
        }
    });
    </script>

<script>
module.exports = {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ],
    safelist: [
      'border-2',
      'border-4',
      'border-8',
      'border-black',
      'bg-gray-300',
    ],
  }

</script>
