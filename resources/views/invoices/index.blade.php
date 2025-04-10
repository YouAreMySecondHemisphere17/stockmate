<x-layouts.app>

<div class="mb-4 flex justify-between items-center">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item :href="route('dashboard')">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>
            Facturas
        </flux:breadcrumbs.item>
    </flux:breadcrumbs> 

    <a href="{{route('invoices.create')}}" class="btn text-xs px-6 py-2 rounded-lg bg-[#fca311] text-black hover:bg-[#ff8c00]">
        Nueva Factura
    </a> 
</div>

<div class="relative overflow-x-auto bg-[#f9f8f6] p-4 rounded-lg border border-[#e5d3b3]">
    <table class="w-full text-sm text-left rtl:text-right text-black">
        <thead class="text-xs text-black uppercase bg-[#fca311]">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Cliente
                </th>
                <th scope="col" class="px-6 py-3">
                    Monto Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Monto Descuento
                </th>
                <th scope="col" class="px-6 py-3">
                    Monto Pagado
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha de Venta
                </th>
                <th scope="col" class="px-6 py-3">
                    Pago Parcial
                </th>
                <th scope="col" class="px-6 py-3">
                    Estado de Pago
                </th>
                <th scope="col" class="px-6 py-3">
                    Sucursal
                </th>
                <th scope="col" class="px-6 py-3 text-center">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr class="bg-white border-b border-[#e5d3b3]">
                    <th scope="row" class="px-6 py-4 font-medium text-[#3e3b36] whitespace-nowrap">
                        {{$invoice->id}}
                    </th>
                    <td class="px-6 py-4">
                        {{$invoice->customer->name}}
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->total_amount}} USD
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->discount_amount}} USD
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->paid_amount}} USD
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->sell_date}}
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->is_partial_payment ? 'Sí' : 'No'}}
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->payment_status}}
                    </td>
                    <td class="px-6 py-4">
                        {{$invoice->branch->branch_name}}
                    </td>     
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if ($invoice->is_partial_payment)
                                <!-- Si es un pago parcial, permitir múltiples pagos -->
                                <a href="{{ route('payments.create', $invoice) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#92df8f] text-black hover:bg-[#92df8f]">
                                    Abonar
                                </a>
                            @else
                                <!-- Si no es un pago parcial, solo permitir un pago -->
                                @if ($invoice->paid_amount < $invoice->total_amount)
                                    <a href="{{ route('payments.create', $invoice) }}" class="btn text-xs px-4 py-2 rounded-lg bg-[#92df8f] text-black hover:bg-[#92df8f]">
                                        Abonar
                                    </a>
                                @else
                                    <!-- Mostrar mensaje de que no se pueden hacer más pagos -->
                                    <span class="text-gray-500">Pago completo</span>
                                @endif
                            @endif
                    
                            <a href="{{route('invoices.edit', $invoice)}}" class="btn text-xs px-4 py-2 rounded-lg bg-[#fca311] text-black hover:bg-[#ff8c00]">
                                Actualizar Estado
                            </a>
                    
                            <form class="delete-form" action="{{route('invoices.destroy', $invoice)}}" method="POST">
                                @csrf
                                @method('DELETE')
                    
                                <button class="btn text-xs py-2 rounded-lg bg-[#d9534f] text-white hover:bg-[#c9302c]">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>      
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $invoices->links() }}
</div>

</x-layouts.app>