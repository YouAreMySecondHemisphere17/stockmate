<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatusEnum;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate();
        $categories = Category::all();
        $vendors = Vendor::all();

        return view('products.index', compact('products', 'categories', 'vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $vendors = Vendor::all();

        $statuses = ProductStatusEnum::cases();

        return view('products.create', compact('categories', 'vendors', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'product_name' => 'required|string|min:3|max:50|unique:products,name',
            'details' => 'nullable|string',
            'sold_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'status' => ['required', new Enum(ProductStatusEnum::class)],
            'image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            $data['image_path'] = Storage::put('products', $request->image);
        }

        Product::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha creado correctamente',
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $vendors = Vendor::all();

        $statuses = ProductStatusEnum::cases();

        return view('products.edit', compact('product', 'categories', 'vendors', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'product_name' => 'required|string|min:3|max:50|unique:products,name,' . $product->id,
            'details' => 'nullable|string',
            'sold_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
            'status' => ['required', new Enum(ProductStatusEnum::class)],
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {

            if ($product->image_path) {
                Storage::delete($product->image_path);
            }

            $data['image_path'] = Storage::put('products', $request->image);
        }

        $product->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha actualizado correctamente',
        ]);

        return redirect()->route('products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El producto se ha eliminado correctamente',
        ]);

        return redirect()->route('products.index');
    }
}
