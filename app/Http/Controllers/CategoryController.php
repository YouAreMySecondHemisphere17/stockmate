<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->get('search');

        if ($searchTerm) {
            $rawResults = DB::select('CALL filter_categories(?)', [$searchTerm]);
            $categories = collect($rawResults)->map(function ($item) {
                return (array) $item;
            });
        } else {
            $categories = Category::orderBy('id', 'desc')->get();
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        
        $data = $request->validate([
            'category_name' => 'required|string|min:3|max:50|unique:categories,category_name',
        ]);

        Category::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La categoría se ha creado correctamente',
        ]);

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|min:3|max:50|unique:categories,category_name,' . $category->id,
        ]);

        $category->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La categoría se ha actualizado correctamente',
        ]);

        return redirect()->route('categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La categoría se ha eliminado correctamente',
        ]);

        return redirect()->route('categories.index');
    } 

    public function search(Request $request)
    {
        $search = $request->input('q');
    
        $categories = Category::query()
            ->whereLike('category_name', "%{$search}%") 
            ->select('id', 'category_name as text')
            ->limit(10)
            ->get();
    
        return response()->json([
            'items' => $categories
        ]);
    }
    
}
