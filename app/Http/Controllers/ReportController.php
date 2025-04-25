<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function stock()
    {
        $products = Product::with('category')->get();

        $pdf = Pdf::loadView('reports.stock_pdf', compact('products'));

        return $pdf->download('stock-report.pdf');
    }

    public function index()
    {
        return view('reports.index');
    }
}

