<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

use App\Models\Customer;
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
      $branches = Branch::all();
      $status = PaymentStatusEnum::PENDING;

      return view('invoices.create', compact('customers', 'branches', 'products', 'status'));
   }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_status' => ['required', new Enum(PaymentStatusEnum::class)],
            'sell_date' => 'required|date',
            'discount_amount' => 'nullable|numeric|min:0',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.sold_quantity' => 'required|numeric|min:1',
            'products.*.sold_price' => 'required|numeric|min:0',
            'products.*.discount' => 'nullable|numeric|min:0',
        ]);

        $totalAmount = 0;
        $totalDiscount = 0;

        foreach ($request->products as $productData) {
            $product = Product::find($productData['product_id']);
            $totalAmount += $productData['sold_quantity'] * $productData['sold_price'];
            $totalDiscount += $productData['discount'];
        }

        $sell = Sell::create([
            'user_id' => auth()->id(),
            'customer_id' => $request->customer_id,
            'branch_id' => $request->branch_id ?? 1,
            'total_amount' => $totalAmount,
            'paid_amount' => 0, 
            'sell_date' => $request->sell_date,
            'discount_amount' => $totalDiscount,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
        ]);

        foreach ($request->products as $productData) {
            $product = Product::find($productData['product_id']);
            $totalSoldPrice = $productData['sold_quantity'] * $productData['sold_price'];

            SellDetails::create([
                'sell_id' => $sell->id,
                'product_id' => $productData['product_id'],
                'quantity_sold' => $productData['sold_quantity'],
                'sold_price' => $productData['sold_price'],
                'total_sold_price' => $totalSoldPrice,
                'discount' => $productData['discount'] ?? 0,
                'discount_amount' => $productData['discount'] ?? 0,
            ]);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La factura se ha creado correctamente',
        ]);

        return redirect()->route('invoices.index');
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

        return redirect()->route('invoices.destroy', $invoice);
    }

}
