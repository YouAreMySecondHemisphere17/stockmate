<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS get_net_income(OUT total DECIMAL(10,2))
        BEGIN
            SELECT SUM(amount) INTO total
            FROM payments;
        END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_net_income");
    }
};

