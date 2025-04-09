<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->get('search');
        $filterType = $request->get('filter_type'); 

        if ($searchTerm) {
            $rawResults = DB::select('CALL filter_vendors(?, ?)', [$searchTerm, $filterType]);
            $vendors = collect($rawResults)->map(function ($item) {
                return (array) $item;
            });
        } else {
            $vendors = Vendor::orderBy('id', 'desc')->get();
        }

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:50|unique:vendors,name',
            'email' => 'nullable|string|email|max:255|unique:vendors,email',
            'phone' => 'nullable|string|min:10|max:20|regex:/^(\+?[\d\s\-\(\)]{10,15})$/',
            'address' => 'nullable|string',
        ]);

        Vendor::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha creado correctamente',
        ]);

        return redirect()->route('vendors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:50|unique:vendors,name,' . $vendor->id,
            'email' => 'nullable|string|email|max:255|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|min:10|max:20|regex:/^(\+?[\d\s\-\(\)]{10,15})$/',
            'address' => 'nullable|string',
        ]);

        $vendor->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha actualizado correctamente',
        ]);

        return redirect()->route('vendors.edit', $vendor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El proveedor se ha eliminado correctamente',
        ]);

        return redirect()->route('vendors.index');
    }
}
