@php
$groups = [
    'General' => [
        [
            'name' => 'Inicio',
            'icon' => 'home',
            'url' => route('dashboard'),
            'bg_color' => '#FC9BAC', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('dashboard'),
        ],
        [
            'name' => 'Usuarios',
            'icon' => 'user',
            'url' => route('users.index'),
            'bg_color' => '#4DA9C2', 
            'text_color' => '#8B0000', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('users.*'),
        ],
    ],
    'Gestión de Productos' => [
        [
            'name' => 'Categorías',
            'icon' => 'funnel',
            'url' => route('categories.index'),
            'bg_color' => '#A6D7C1', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('categories.*'),
        ],
        [
            'name' => 'Productos',
            'icon' => 'gift',
            'url' => route('products.index'),
            'bg_color' => '#F8E181', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('products.*'),
        ],
        [
            'name' => 'Proveedores',
            'icon' => 'truck',
            'url' => route('vendors.index'),
            'bg_color' => '#FC9BAC', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('vendors.*'),
        ],
    ],
    'Gestión de Clientes' => [
        [
            'name' => 'Clientes',
            'icon' => 'users',
            'url' => route('customers.index'),
            'bg_color' => '#4DA9C2',
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('customers.*'),
        ],
    ],
    'Gestión de Existencias' => [
        [
            'name' => 'Entradas',
            'icon' => 'arrow-down-circle',
            'url' => route('entries.index'),
            'bg_color' => '#A6D7C1', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('entries.*'),
        ],
        [
            'name' => 'Salidas/Facturación',
            'icon' => 'minus-circle',
            'url' => route('invoices.index'),
            'bg_color' => '#F8E181', 
            'text_color' => 'text-black', 
            'font_class' => 'font-semibold text-lg',
            'current' => request()->routeIs('invoices.*'),
        ],
    ],
    'Gestión de Reportes' => [
        [
            'name' => 'Reportes',
            'icon' => 'folder',
            'url' => route('reports.index'),
            'bg_color' => '#FC9BAC', 
            'text_color' => '#8B0000', 
            'font_class' => 'font-semibold text-lg',
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
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background-color: #F8F8FF;
            color: #000000; 
            padding-top: 10px;
            overflow-y: auto;
            margin-left: 2px;
            margin-right: 2px;
        }

        .main-content {
            margin-left: 250px;
            padding: 5px;
            min-height: 100vh;
            background-color: #F8F8FF;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            color: inherit;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar .header {
            font-size: 16px;
            font-weight: 700;
            color: #000000;
            text-transform: uppercase;
            margin-top: 0px;
            padding-left: 10px;
            margin-bottom: 0px;
        }

        .sidebar .nav-item {
            border-radius: 6px;
            margin-bottom: 6px;
            margin-right: 10px;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-item:hover {
            background-color: #E0EEEE;
        }

        .sidebar .nav-item.bg-[#F08080] { background-color: #F08080; color: #8B0000; }
        .sidebar .nav-item.bg-[#ADD8E6] { background-color: #ADD8E6; color: #00008B; } 
        .sidebar .nav-item.bg-[#90EE90] { background-color: #90EE90; color: #006400; } 
        .sidebar .nav-item.bg-[#FFFFE0] { background-color: #FFFFE0; color: #808000; } 

        .sidebar .nav-item.current {
            background-color: #DEDEE0; 
            color: #FFFFFF;
            border-left: 3px solid #adacac;
        }

        .sidebar .nav-item a {
            padding: 8px 12px;
        }

        .sidebar-settings {
            background-color: #F8F8FF; 
            font-size: 12px;
            font-weight: 500;
            padding: 10px;
        }

        .sidebar-group {
            font-size: 15px;
            font-weight: 1000;
            padding-left: 12px;
            margin-top: 10px;
            color: #000000; 
        }

        .bg-[#F8E181] { background-color: #F8E181; } /* yellow */ 
        .bg-[#DEDEE0] { background-color: #DEDEE0; } /* white */
        .bg-[#FC9BAC] { background-color: #FC9BAC; } /* pink */ 
        .bg-[#A6D7C1] { background-color: #A6D7C1; } /* green */
        .bg-[#4DA9C2] { background-color: #4DA9C2; } /* blue */
        .text-white { color: rgb(255, 255, 255); }
        .text-black { color: rgb(0, 0, 0); }

        .custom-dropdown {
            position: relative;
        }

        .custom-dropdown-button {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: #000000;
            cursor: pointer;
            padding: 8px 12px;
        }

        .user-initial {
            background-color: #000000; 
            color: #FFFFFF; 
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            margin-right: 8px;
        }

        .user-name {
            font-size: 14px;
            color: #000000;
        }

        .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-menu {
        position: absolute;
        bottom: 100%; 
        left: 0;
        display: none;
        background-color: white;
        border: 1px solid #000000;
        min-width: 160px;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .custom-dropdown-menu li {
        padding: 10px;
        cursor: pointer;
    }

    .custom-dropdown-menu li:hover {
        background-color: #f0f0f0;
    }
    </style>
</head>

<body class="min-h-screen bg-[#F8F8FF] dark:bg-zinc-800">
    <div class="sidebar sticky stashable border-r border-zinc-200 bg-[#F8F8FF] dark:border-zinc-700 dark:bg-zinc-900">
        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse">
            <x-app-logo style="width: 32px; height: 32px;mbackground-color: #F8F8FF;" /> <div class="ms-1 grid flex-1 text-start text-sm #F8F8FF">
                <span class="truncate leading-none font-semibold" style="font-size: 17px; background-color: #F8F8FF; color: #000000;">StockMate</span>
            </div>
        </a>

        <nav class="sidebar-group space-y-2 mt-4">
            @foreach ($groups as $group => $links)
                <div class="space-y-1.5">
                    <div class="sidebar-header">{{ $group }}</div>
                    @foreach ($links as $link)
                        <div class="nav-item bg-[{{ $link['bg_color'] }}] rounded-md {{ $link['current'] ? 'current' : '' }}">
                            <a href="{{ $link['url'] }}"
                               class="flex items-center space-x-2 p-1.5 rounded-md {{ $link['text_color'] ?? 'text-black' }}
                                            {{ $link['font_class'] ?? '' }}">
                                   <x-icon name="{{ $link['icon'] }}" style="width: 18px; height: 18px;" />
                                    <span>{{ $link['name'] }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </nav>

        <div class="sidebar-settings">
            <div class="custom-dropdown relative">
                <button class="custom-dropdown-button" onclick="toggleDropdown()">
                    <span class="user-initial" style="background-color: #000000; color: #FFFFFF;">{{ strtoupper(auth()->user()->name[0]) }}</span>
                    <span class="user-name" style="color: #000000;">{{ auth()->user()->name }}</span>
                </button>
                <div class="custom-dropdown-menu absolute hidden bg-white border border-gray-300 shadow-md min-w-[160px] z-10 top-full left-0">
                    <div class="text-center">
                        <a href="{{ route('settings.profile') }}" class="custom-dropdown-item" style="color: #000000;">
                            <i class="fas fa-cogs mr-2"></i> Configuración
                        </a>
                    </div>
                    <div class="text-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="custom-dropdown-item w-full" style="color: #000000;">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
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
        const dropdown = document.querySelector('.custom-dropdown');
        
        const dropdownRect = dropdown.getBoundingClientRect();
        const menuHeight = menu.offsetHeight;
        
        menu.style.top = `-${menuHeight + 70 }px`; 

        menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
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
        'border-[#F08080]', // Rojo Coral Claro
        'border-[#ADD8E6]', // Azul Pastel
        'border-[#90EE90]', // Verde Claro
        'border-[#FFFFE0]', //
        'text-[#00008B]',
        'text-[#333333]',
        'text-[#555555]',
        'text-[#666666]',
        'current',
        'border-left',
    ],
}
</script>