@php
    $cardBase = "flex items-center justify-start gap-4 p-6 rounded-xl shadow-md cursor-pointer h-[150px]";
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Stock Crítico -->
        <div id="openCriticalStockModal" class="{{ $cardBase }} bg-red-500 text-white">
            <i class="fas fa-exclamation-triangle text-4xl text-white"></i>
            <div>
                <div class="text-lg font-semibold">Stock Crítico</div>
                <div class="text-3xl font-bold">{{ $totalCriticalStock }}</div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="{{ $cardBase }} bg-[#9c8353da] text-white">
            <i class="fas fa-tags text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Categorías</div>
                <div class="text-3xl font-bold">{{ $totalCategories }}</div>
            </div>
        </div>    

        <!-- Existencia actual-->
        <div class="{{ $cardBase }} bg-[#38ca44da] text-white">
            <i class="fas fa-cube text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Existencia Actual</div>
                <div class="text-3xl font-bold">{{ $totalUnits }}</div>
            </div>
        </div>           
        
        <!-- Facturas -->
        <div class="{{ $cardBase }} bg-[#f1f1f1] text-black">
            <i class="fas fa-file-invoice-dollar text-4xl text-black"></i>
           <div>
                <div class="text-lg font-semibold">Facturas</div>
                <div class="text-3xl font-bold">{{ $totalInvoices }}</div>
            </div>
        </div> 
        
        <!-- Existencia vendida -->
        <div class="{{ $cardBase }} bg-[#d847f5da] text-white">
            <i class="fas fa-box-open text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Existencia Vendida</div>
                <div class="text-3xl font-bold">{{ $totalSoldProducts }}</div>
            </div>
        </div>  

        <!-- Productos -->
        <div class="{{ $cardBase }} bg-[#ffea8edc] text-black">
            <i class="fas fa-boxes text-4xl text-black"></i>
           <div>
                <div class="text-lg font-semibold">Productos</div>
                <div class="text-3xl font-bold">{{ $totalProducts }}</div>
            </div>
        </div>           
        
        <!-- Proveedores -->
        <div class="{{ $cardBase }} bg-[#ff68c0] text-white">
            <i class="fas fa-truck text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Proveedores</div>
                <div class="text-3xl font-bold">{{ $totalVendors }}</div>
            </div>
        </div>         
        
        <!-- Clientes -->
        <div class="{{ $cardBase }} bg-[#f8f529be] text-black">
            <i class="fas fa-users text-4xl text-black"></i>
           <div>
                <div class="text-lg font-semibold">Clientes</div>
                <div class="text-3xl font-bold">{{ $totalCustomers }}</div>
            </div>
        </div>        
        
        <!-- Ventas -->
        <div class="{{ $cardBase }} bg-[#fca311] text-white">
            <i class="fas fa-chart-line text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Ventas del mes</div>
                <div class="text-3xl font-bold">{{ $totalSales }}</div>
            </div>
        </div>        
        
        <!-- Importe Vendido -->
        <div class="{{ $cardBase }} bg-[#208639] text-white">
            <i class="fas fa-dollar-sign text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Importe Vendido</div>
                <div class="text-3xl font-bold">{{ $totalAmount}}</div>
            </div>
        </div>                  
         
        <!-- Usuarios -->
        <div class="{{ $cardBase }} bg-[#2f4ed6da] text-white">
            <i class="fas fa-user text-4xl text-white"></i>
           <div>
                <div class="text-lg font-semibold">Usuarios</div>
                <div class="text-3xl font-bold">{{ $totalUsers }}</div>
            </div>
        </div>  
    </div>

    <div id="criticalStockModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-xl max-w-xl w-full max-h-[85vh] overflow-hidden shadow-2xl border-t-4 border-yellow-500 animate-fade-in">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-yellow-600 flex items-center gap-2">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-3xl"></i>
                    Productos con Stock Crítico
                </h3>
                <button id="closeCriticalStockModal" class="text-gray-500 hover:text-red-500 text-xl">×</button>
            </div>
    
            <div class="overflow-y-auto max-h-64 space-y-2 pr-2" id="critical-stock-products">
                <div id="loading" class="text-center py-2 text-gray-500">
                    <button class="px-4 py-2 bg-red-500 text-white rounded" disabled>Cargando...</button>
                </div>
    
                @foreach ($criticalStockProducts as $product)
                    <div class="border border-yellow-200 bg-yellow-50 px-4 py-2 rounded hidden fade-in">
                        <div class="flex justify-between font-medium text-sm text-yellow-700">
                            <span>{{ $product->product_name }}</span>
                            <span>{{ $product->current_stock }} / {{ $product->minimum_stock }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>

<script>
    document.getElementById('openCriticalStockModal').addEventListener('click', function () {
        const modal = document.getElementById('criticalStockModal');
        const loading = document.getElementById('loading');
        const items = document.querySelectorAll('#critical-stock-products .fade-in');

        modal.classList.remove('hidden');
        loading.style.display = 'block';

        // Esperar antes de mostrar productos
        setTimeout(() => {
            loading.style.display = 'none';
            items.forEach(item => item.classList.remove('hidden'));
        }, 1000); // ajustable
    });

    document.getElementById('closeCriticalStockModal').addEventListener('click', function () {
        document.getElementById('criticalStockModal').classList.add('hidden');
    });

    document.getElementById('criticalStockModal').addEventListener('click', function (event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
