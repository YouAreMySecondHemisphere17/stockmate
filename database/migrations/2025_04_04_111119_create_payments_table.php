<?php

use App\Enums\PaymentMethodEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sell_id');
            $table->unsignedBigInteger('user_id');
            
            $table->string('date');

            $table->enum('payment_method', array_column(PaymentMethodEnum::cases(), 'value'))
            ->default(PaymentMethodEnum::CASH->value);

            $table->text('details')->nullable();
            $table->double('amount');

            $table->foreign('sell_id')->references('id')->on('sells')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
