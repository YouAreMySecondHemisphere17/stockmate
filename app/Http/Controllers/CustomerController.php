<?php

namespace App\Http\Controllers;

use App\Enums\CustomerStatusEnum;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->paginate();

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = CustomerStatusEnum::cases();

        return view('customers.create', compact('statuses'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|min:3|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|required|string|max:255',
            'address' => 'nullable|string',
            'status' => ['required', new Enum(CustomerStatusEnum::class)],
        ]);

        Customer::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El cliente se ha creado correctamente',
        ]);

        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $statuses = CustomerStatusEnum::cases();

        return view('customers.edit', compact('customer', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|min:3|max:255',
            'email' => 'nullable|string|email|max:255',
            'phone' => 'nullable|required|string|max:255',
            'address' => 'nullable|string',
            'status' => ['required', new Enum(CustomerStatusEnum::class)],
        ]);

        $customer->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El cliente se ha actualizado correctamente',
        ]);

        return redirect()->route('customers.edit', $customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El cliente se ha eliminado correctamente',
        ]);

        return redirect()->route('customers.index');
    }
}
