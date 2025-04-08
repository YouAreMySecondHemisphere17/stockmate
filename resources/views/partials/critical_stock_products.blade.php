@foreach($criticalStockProducts as $product)
    <div class="border-b border-gray-300 px-4 py-2">
        <div class="flex justify-between">
            <span>{{ $product->product_name }}</span>
            <span>{{ $product->current_stock }} / {{ $product->minimum_stock }}</span>
        </div>
    </div>
@endforeach
