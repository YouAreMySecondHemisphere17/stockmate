<x-layouts.app :title="__('Dashboard')">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Stock crítico -->
        <div id="openCriticalStockModal" class="flex items-center gap-4 bg-red-500 text-white p-4 rounded-xl shadow-md cursor-pointer">
            <div>
                <div class="text-sm">Stock crítico</div>
                <div class="text-2xl font-bold">{{ $totalCriticalStock }}</div>
            </div>
        </div>

        <!-- Categorías -->
        <div class="flex items-center gap-4 bg-[#9c8353da] text-white p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Categorías</div>
                <div class="text-2xl font-bold">{{ $totalCategories }}</div>
            </div>
        </div>        
        

        
        <div class="flex items-center gap-4 bg-[#38ca44da] text-white p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Unidades en inventario</div>
                <div class="text-2xl font-bold">{{ $totalUnits }}</div> 
            </div>
        </div> 
    
        
        <!-- Productos -->
        <div class="flex items-center gap-4 bg-[#faefbddc] text-black p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Productos</div>
                <div class="text-2xl font-bold">{{ $totalProducts }}</div>
            </div>
        </div>       
         
        <!-- Proveedores -->
        <div class="flex items-center gap-4 bg-[#f6c1c7] text-white p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Proveedores</div>
                <div class="text-2xl font-bold">{{ $totalVendors }}</div>
            </div>
        </div>
    
        <!-- Clientes -->
        <div class="flex items-center gap-4 bg-[#e1f761be] text-black p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Clientes</div>
                <div class="text-2xl font-bold">{{ $totalCustomers }}</div>
            </div>
        </div>
    
        <!-- Ventas -->
        <div class="flex items-center gap-4 bg-[#fca311] text-gray-800 p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Ventas del mes</div>
                <div class="text-2xl font-bold">{{ $totalSales }}</div>
            </div>
        </div>
    
        <!-- Ingresos -->
        <div class="flex items-center gap-4 bg-[#829ce2] text-gray-800 p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Ingresos</div>
                <div class="text-2xl font-bold">$12,400</div>
            </div>
        </div>                
        
        <!-- Usuarios -->
        <div class="flex items-center gap-4 bg-[#8398f3da] text-black p-4 rounded-xl shadow-m">
            <div>
                <div class="text-sm">Usuarios</div>
                <div class="text-2xl font-bold">{{ $totalUsers }}</div>
            </div>
        </div> 
    </div>



<div id="criticalStockModal" class="fixed inset-0 flex items-center justify-center bg-gray-600 bg-opacity-50 hidden">
    <div class="bg-white p-4 rounded-lg max-w-lg w-full max-h-96 overflow-hidden">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Productos con Stock Crítico</h3>
            <button id="closeCriticalStockModal" class="text-gray-700">X</button>
        </div>
        <!-- Lista de productos críticos -->
        <div class="overflow-y-auto max-h-64" id="critical-stock-products">
            @foreach($criticalStockProducts as $product)
                <div class="border-b border-gray-300 px-4 py-2">
                    <div class="flex justify-between">
                        <span>{{ $product->product_name }}</span>
                        <span>{{ $product->current_stock }} / {{ $product->minimum_stock }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Cargar más productos -->
        <div class="text-center mt-4" id="loading">
            <button class="px-4 py-2 bg-blue-500 text-white rounded" disabled>Loading...</button>
        </div>
    </div>
</div>

<script>
    // Mostrar el modal al hacer clic en el botón
    document.getElementById('openCriticalStockModal').addEventListener('click', function() {
        document.getElementById('criticalStockModal').classList.remove('hidden');
    });

    // Cerrar el modal
    document.getElementById('closeCriticalStockModal').addEventListener('click', function() {
        document.getElementById('criticalStockModal').classList.add('hidden');
    });

    let loading = false;
    let nextPageUrl = "{{ $criticalStockProducts->nextPageUrl() }}";

    // Scroll infinito en el modal
    const productContainer = document.getElementById('critical-stock-products');
    productContainer.addEventListener('scroll', function() {
        if (productContainer.scrollTop + productContainer.clientHeight >= productContainer.scrollHeight && !loading && nextPageUrl) {
            loading = true;
            document.getElementById('loading').style.display = 'block';

            // Solicitar más productos usando AJAX
            fetch(nextPageUrl)
                .then(response => response.json())
                .then(data => {
                    // Insertar los nuevos productos en la lista
                    document.getElementById('critical-stock-products').insertAdjacentHTML('beforeend', data.products);

                    // Actualizar la URL para la siguiente página
                    nextPageUrl = data.next_page_url;
                    loading = false;
                    document.getElementById('loading').style.display = 'none';
                });
        }
    });
</script>

    


</x-layouts.app>

<script>
    // Obtener los elementos del DOM
    const stockCriticalDiv = document.getElementById('stockCritical');
    const criticalModal = document.getElementById('criticalModal');
    const closeModalButton = document.getElementById('closeModal');

    // Abrir el modal cuando se haga clic en "Stock crítico"
    stockCriticalDiv.addEventListener('click', function() {
        criticalModal.classList.remove('hidden');
    });

    // Cerrar el modal cuando se haga clic en el botón de cerrar
    closeModalButton.addEventListener('click', function() {
        criticalModal.classList.add('hidden');
    });

    // Cerrar el modal si se hace clic fuera de la caja modal
    criticalModal.addEventListener('click', function(event) {
        if (event.target === criticalModal) {
            criticalModal.classList.add('hidden');
        }
    });
</script>
