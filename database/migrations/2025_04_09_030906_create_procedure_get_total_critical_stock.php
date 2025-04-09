<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS get_total_critical_stock(OUT total INT)
        BEGIN
            SELECT COUNT(*) INTO total FROM products WHERE current_stock <= minimum_stock;
        END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_total_critical_stock");
    }
};

