<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethodEnum;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Sell;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::orderBy('id', 'desc')->paginate();

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sell $invoice)
    {
        $methods = PaymentMethodEnum::cases();

        return view('payments.create', compact('invoice', 'methods'));
    }

    public function store(Request $request, Sell $invoice)
    {
    $data = $request->validate([
        'sell_id' => 'required|exists:sells,id',
        'date' => 'required|date',
        'payment_method' => ['required', new Enum(PaymentMethodEnum::class)],
        'details' => 'nullable|string',
        'amount' => 'required|numeric|min:0',
    ]);

    $data['user_id'] = auth()->id();

    $paidAmount = $request->input('paid_amount');

    if ($invoice->is_partial_payment) {
        if ($invoice->paid_amount + $paidAmount > $invoice->total_amount) {
            return redirect()->back()->with('error', 'El monto pagado no puede superar el monto total de la factura.');
        }
    } else {
        if ($invoice->paid_amount >= $invoice->total_amount) {
            return redirect()->back()->with('error', 'Esta factura ya está pagada en su totalidad.');
        }
    }

    $invoice->paid_amount += $paidAmount;
    $invoice->save();

    Payment::create($data);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Bien hecho!',
        'text' => 'El pago se ha registrado correctamente',
    ]);

    return redirect()->route('invoices.index');
}

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment, Sell $invoice)
    {
        $methods = PaymentMethodEnum::cases();

        return view('payments.edit', compact('payment', 'invoice', 'methods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'sell_id' => 'required|exists:sells,id',
            'date' => 'required|date',
            'payment_method' => ['required', new Enum(PaymentMethodEnum::class)],
            'details' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $data['user_id'] = auth()->id();

        $payment->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El pago se ha actualizado correctamente',
        ]);

        return redirect()->route('customers.edit', $payment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'El pago se ha eliminado correctamente',
        ]);

        return redirect()->route('payments.index');
    }
}
