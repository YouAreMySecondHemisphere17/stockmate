<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS get_total_sales_amount(OUT totalAmount DECIMAL(10,2))
            BEGIN
                SELECT SUM(amount) INTO totalAmount
                FROM payments;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_total_sales_amount");
    }
};
