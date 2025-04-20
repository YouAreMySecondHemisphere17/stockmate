<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentMethodEnum;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sell;
use App\Models\SellDetails;

use Illuminate\Validation\Rules\Enum;


class InvoiceController extends Controller
{

   public function index()
   {
      $invoices = Sell::orderBy('id', 'desc')->paginate();

      return view('invoices.index', compact('invoices'));
   }

   public function create()
   {
      $customers = Customer::all();
      $products = Product::all();
      $status = PaymentStatusEnum::CANCELLED;
      $methods = PaymentMethodEnum::cases();
      
      $lastInvoice = Sell::latest()->first();
      $nextNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
      $number = 'INV-' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);

      return view('invoices.create', compact('customers', 
      'products', 'status', 'methods', 'number'));
   }

   public function store(Request $request)
   {
       $validated = $request->validate([
           'customer_id' => 'required|exists:customers,id',
           'sell_date' => 'required|date',
           'discount_amount' => 'nullable|numeric|min:0',
           'products' => 'required|array',
           'products.*.product_id' => 'required|exists:products,id',
           'products.*.sold_quantity' => 'required|numeric|min:1',
           'products.*.sold_price' => 'required|numeric|min:0',
           'products.*.total_sold_price' => 'required|numeric|min:0',
           'products.*.discount' => 'nullable|numeric|min:0',
           'payment_method' => ['required', new Enum(PaymentMethodEnum::class)],
           'details' => 'nullable|string|max:255',
       ]);
   
       $sell = Sell::create([
           'user_id' => auth()->id(),
           'number' => $request->number,
           'customer_id' => $request->customer_id,
           'total_amount' => $request->total_amount,
           'sell_date' => $request->sell_date,
           'discount_amount' => $request->discount_amount,
           'payment_method' => $request->payment_method,
           'payment_status' => PaymentStatusEnum::PAID, 
       ]);
   
       foreach ($request->products as $productData) {
           $totalSoldPrice = $productData['sold_quantity'] * $productData['sold_price'];
   
           SellDetails::create([
               'sell_id' => $sell->id,
               'product_id' => $productData['product_id'],
               'quantity_sold' => $productData['sold_quantity'],
               'sold_price' => $productData['sold_price'],
               'total_sold_price' => $totalSoldPrice,
           ]);
       }
   
       Payment::create([
            'sell_id' => $sell->id,
            'user_id' => auth()->id(),
            'date' => $sell->sell_date,
            'payment_method' => $request->payment_method,
            'details' => $request->details,
            'amount' => $request->total_amount,
       ]);
   
       Product::calcularStockDeTodosLosProductos();
   
       session()->flash('swal', [
           'icon' => 'success',
           'title' => '¡Bien hecho!',
           'text' => 'La factura y el pago se han registrado correctamente',
       ]);
   
       return redirect()->route('invoices.index');
   }
   

    public function show(Sell $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Sell $invoice)
    {
       $paymentStatuses = PaymentStatusEnum::cases();
 
       return view('invoices.edit', compact('invoice', 'paymentStatuses'));
    }

    public function update(Request $request, Sell $invoice)
    {
        $data = $request->validate([
            'payment_status' => ['required', new Enum(PaymentStatusEnum::class)],
        ]);

        $invoice->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La factura se ha actualizado correctamente',
        ]);

        return redirect()->route('invoices.edit', $invoice);
    }

    public function destroy(Sell $invoice)
    {
        $invoice->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La factura se ha eliminado correctamente',
        ]);

        return redirect()->route('invoices.index');
    }

}
