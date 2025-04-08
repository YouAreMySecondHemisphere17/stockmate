<?php

use App\Enums\CustomerStatusEnum;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('customer_name', 50)->unique();
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();

            $table->enum('status', array_column(CustomerStatusEnum::cases(), 'value'))
                  ->default(CustomerStatusEnum::ACTIVE->value); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
