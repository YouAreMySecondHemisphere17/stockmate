<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;

class EntryController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entries = Purchase::orderBy('id', 'desc')->paginate();

        return view('entries.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        $vendors = Vendor::all();

        return view('entries.create', compact('products', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'total_amount' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'transaction_date' => 'required|date',
        ]);

        Purchase::create($data);

        Product::calcularStockDeTodosLosProductos();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La entrada se ha creado correctamente',
        ]);

        return redirect()->route('entries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $entry)
    {
        $products = Product::all();
        $vendors = Vendor::all();

        return view('entries.edit', compact('entry', 'products', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $entry)
    {
        $data = $request->validate([
            'transaction_date' => 'required|date',
        ]);

        $entry->update($data);

        Product::calcularStockDeTodosLosProductos();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La entrada se ha actualizado correctamente',
        ]);

        return redirect()->route('entries.edit', $entry);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $entry)
    {
        $entry->delete();

        Product::calcularStockDeTodosLosProductos();
        
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La entrada se ha eliminado correctamente',
        ]);

        return redirect()->route('entries.index');
    }
}
