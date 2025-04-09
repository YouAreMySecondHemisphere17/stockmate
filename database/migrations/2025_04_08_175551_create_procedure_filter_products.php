<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS filter_products(IN search_param VARCHAR(100))
        BEGIN
            SELECT * FROM products
            WHERE product_name LIKE CONCAT('%', search_param, '%');
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS filter_products");
    }
};
