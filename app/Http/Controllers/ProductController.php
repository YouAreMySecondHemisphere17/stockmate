<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $vendors = Vendor::all();

        $searchTerm = $request->get('search');
        $filterType = $request->get('filter_type'); 

        if ($searchTerm) {
            $rawResults = DB::select('CALL filter_products(?, ?)', [$searchTerm, $filterType]);
            $products = collect($rawResults)->map(function ($item) {
                return (array) $item;
            });
        } else {
            $products = Product::with('category')->orderBy('id', 'desc')->paginate(12);

            $products->getCollection()->transform(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->product_name,
                    'category_id' => $product->category->id ?? null,
                    'category_name' => $product->category->category_name ?? null,
                    'image_path' => $product->image_path,
                    'current_stock' => $product->current_stock,
                    'minimum_stock' => $product->minimum_stock,
                    'purchase_price' => $product->purchase_price,
                    'sold_price' => $product->sold_price,
                    'details' => $product->details,
                ];
            });
            
        }
        
        return view('products.index', compact('products', 'categories', 'vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $vendors = Vendor::all();

        return view('products.create', compact('categories', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'product_name' => 'required|string|min:3|max:50|unique:products,product_name',
            'details' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sold_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
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

        return view('products.edit', compact('product', 'categories', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'product_name' => 'required|string|min:3|max:50|unique:products,product_name,' . $product->id,
            'details' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'sold_price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|numeric|min:0',
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
