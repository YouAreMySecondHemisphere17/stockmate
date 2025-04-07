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
        $totalCategories = Category::getTotalCategories();
        $totalProducts = Product::getTotalProducts();
        $totalVendors = Vendor::getTotalVendors();
        $totalCustomers = Customer::getTotalCustomers();
        $totalUsers = User::getTotalUsers();

        $totalSales = Sell::whereMonth('sell_date', Carbon::now()->month)
        ->whereYear('sell_date', Carbon::now()->year)
        ->sum('paid_amount');  

        return view('dashboard', compact(
            'totalCategories', 
            'totalProducts', 
            'totalVendors',
            'totalCustomers',
            'totalUsers',
            'totalSales',
        ));
    }
}
