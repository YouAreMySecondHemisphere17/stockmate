<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sell_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sell_id');
            $table->unsignedBigInteger('product_id');

            $table->integer('quantity_sold'); // Cantidad vendida
            $table->double('sold_price'); // Precio de venta por unidad
            $table->double('total_sold_price'); // Precio total (cantidad * precio por unidad)
            $table->double('discount')->default(0); // Descuento aplicado

            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');;
            $table->foreign('product_id')->references('id')->on('products');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_details');
    }
};
