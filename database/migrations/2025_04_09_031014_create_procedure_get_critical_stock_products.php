<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS get_critical_stock_products()
        BEGIN
            SELECT * FROM products WHERE current_stock <= minimum_stock;
        END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_critical_stock_products");
    }
};

