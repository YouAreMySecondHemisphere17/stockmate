<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Unidades en inventario
        DB::select('CALL get_total_units(@total)');
        $totalUnits = DB::select('SELECT @total AS total')[0]->total;

        // Total de categorías
        DB::select('CALL get_total_categories(@total)');
        $totalCategories = DB::select('SELECT @total AS total')[0]->total;

        // Total de productos
        DB::select('CALL get_total_products(@total)');
        $totalProducts = DB::select('SELECT @total AS total')[0]->total;

        // Total de proveedores
        DB::select('CALL get_total_vendors(@total)');
        $totalVendors = DB::select('SELECT @total AS total')[0]->total;

        // Total de clientes
        DB::select('CALL get_total_customers(@total)');
        $totalCustomers = DB::select('SELECT @total AS total')[0]->total;

        // Total de usuarios
        DB::select('CALL get_total_users(@total)');
        $totalUsers = DB::select('SELECT @total AS total')[0]->total; 
        
        // Total de productos críticos
        DB::select('CALL get_total_critical_stock(@total)');
        $totalCriticalStock  = DB::select('SELECT @total AS total')[0]->total; 

        $criticalStockProducts = DB::select('CALL get_critical_stock_products()');

        $totalSales= 0;
      
        //Ingresos
        DB::select('CALL get_total_income(@total)');
        $totalIncome = DB::select('SELECT @total AS total')[0]->total;

        //Ingreso Neto
        DB::select('CALL get_net_income(@total)');
        $totalNetIncome = DB::select('SELECT @total AS total')[0]->total;

        Product::calcularStockDeTodosLosProductos();

        return view('dashboard', compact(
            'totalCategories', 
            'totalProducts', 
            'totalVendors',
            'totalCustomers',
            'totalUsers',
            'totalSales',
            'totalIncome',
            'totalNetIncome',
            'totalUnits',
            'totalCriticalStock',
            'criticalStockProducts',
        ));
    }
    
    public function getCriticalStockProducts(Request $request)
    {
        $criticalStockProducts = DB::select('CALL get_critical_stock_products()');
    
        if ($request->ajax()) {
            return response()->json([
                'products' => view('partials.critical_stock_products', compact('criticalStockProducts'))->render(),
                'next_page_url' => null,
            ]);
        }
    
        return view('dashboard', compact('criticalStockProducts'));
    }
    
}
