<?php

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
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
        Schema::create('sells', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id'); //Usuario
            $table->integer('customer_id'); //Cliente
            $table->integer('branch_id')->default(1); //Sucursal
            $table->double('total_amount'); //Monto total
            $table->double('paid_amount')->default(0); //Monto pagado
            $table->string('sell_date')->nullable(); //Fecha de la venta
            $table->double('discount_amount')->default(0); //Monto descuento

            $table->enum('payment_method', array_column(PaymentMethodEnum::cases(), 'value'))
            ->default(PaymentMethodEnum::CASH->value); //Método de pago

            $table->enum('payment_status', array_column(PaymentStatusEnum::cases(), 'value'))
            ->default(PaymentStatusEnum::PENDING->value); //Estado de pago
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
