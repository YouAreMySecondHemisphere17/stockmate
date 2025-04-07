<x-layouts.app :title="__('Dashboard')">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <!-- Usuarios -->
        <div class="flex items-center gap-4 bg-[#8398f3da] text-black p-4 rounded-xl shadow-m">
            <div>
                <div class="text-sm">Usuarios</div>
                <div class="text-2xl font-bold">879</div>
            </div>
        </div> 

        <!-- Categorías -->
        <div class="flex items-center gap-4 bg-[#9c8353da] text-white p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Categorías</div>
                <div class="text-2xl font-bold">{{ Category::getTotalCategories() }}</div>
            </div>
        </div>        
        
        <!-- Productos -->
        <div class="flex items-center gap-4 bg-[#faefbddc] text-black p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Productos</div>
                <div class="text-2xl font-bold">1,280</div>
            </div>
        </div>       
         
        <!-- Proveedores -->
        <div class="flex items-center gap-4 bg-[#f6c1c7] text-white p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Proveedores</div>
                <div class="text-2xl font-bold">1,280</div>
            </div>
        </div>
    
        <!-- Clientes -->
        <div class="flex items-center gap-4 bg-[#e1f761be] text-black p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Clientes</div>
                <div class="text-2xl font-bold">320</div>
            </div>
        </div>
    
        <!-- Ventas -->
        <div class="flex items-center gap-4 bg-[#fca311] text-gray-800 p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Ventas del mes</div>
                <div class="text-2xl font-bold">142</div>
            </div>
        </div>
    
        <!-- Ingresos -->
        <div class="flex items-center gap-4 bg-[#829ce2] text-gray-800 p-4 rounded-xl shadow-md">
            <div>
                <div class="text-sm">Ingresos</div>
                <div class="text-2xl font-bold">$12,400</div>
            </div>
        </div>
    </div>
    
</x-layouts.app>
