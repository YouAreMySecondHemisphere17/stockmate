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

            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');

            $table->double('total_amount'); //Monto total
            $table->string('sell_date')->nullable(); 
            $table->double('discount_amount')->default(0); 

            $table->enum('payment_status', array_column(PaymentStatusEnum::cases(), 'value'))
            ->default(PaymentStatusEnum::CANCELLED->value);
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users');

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
