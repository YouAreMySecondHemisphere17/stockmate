<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
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
        return view('entries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string',
        ]);

        Purchase::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha creado correctamente',
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
    public function edit(Purchase $purchase)
    {
        return view('entries.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string',
        ]);

        $purchase->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha actualizado correctamente',
        ]);

        return redirect()->route('entries.edit', $purchase);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha eliminado correctamente',
        ]);

        return redirect()->route('entries.index');
    }
}
