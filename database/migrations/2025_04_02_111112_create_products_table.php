<?php

use App\Enums\ProductStatusEnum;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id')->nullable();
       
            $table->string('product_name'); //Nombre
            $table->text('details')->nullable(); //Descripción
            $table->decimal('sold_price', 10, 2); //Precio de Venta
            $table->integer('current_stock')->default(0);

            $table->enum('status', array_column(ProductStatusEnum::cases(), 'value'))
            ->default(ProductStatusEnum::ACTIVE->value); //Estado

            $table->string('image_path')->nullable(); //Imagen

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
