<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sell;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtención de datos
        $totalCategories = Category::getTotalCategories();
        $totalProducts = Product::getTotalProducts();
        $totalVendors = Vendor::getTotalVendors();
        $totalCustomers = Customer::getTotalCustomers();
        $totalUsers = User::getTotalUsers();
    
        // Productos con stock crítico
        $criticalStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')->paginate(10); // 10 productos por página
        $totalCriticalStock = $criticalStockProducts->total(); // Total de productos con stock crítico para la paginación
    
        // Ventas del mes
        $totalSales = Sell::whereMonth('sell_date', Carbon::now()->month)
            ->whereYear('sell_date', Carbon::now()->year)
            ->sum('paid_amount');  
    
        // Unidades en inventario
        $totalUnits = Product::sum('current_stock');
    
        return view('dashboard', compact(
            'totalCategories', 
            'totalProducts', 
            'totalVendors',
            'totalCustomers',
            'totalUsers',
            'totalSales',
            'totalUnits',
            'totalCriticalStock',
            'criticalStockProducts' // Paginación de productos críticos
        ));
    }
    
    public function getCriticalStockProducts(Request $request)
    {
        // Paginación de productos con stock crítico
        $criticalStockProducts = Product::whereColumn('current_stock', '<=', 'minimum_stock')->paginate(10);
    
        // Si la solicitud es AJAX, retornamos los productos y la paginación en formato JSON
        if ($request->ajax()) {
            return response()->json([
                'products' => view('partials.critical_stock_products', compact('criticalStockProducts'))->render(),
                'next_page_url' => $criticalStockProducts->nextPageUrl(),
            ]);
        }
    
        // Si no es AJAX, retornamos la vista completa
        return view('dashboard', compact('criticalStockProducts'));
    }  
    
}
