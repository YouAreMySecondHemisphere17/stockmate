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
            CREATE PROCEDURE IF NOT EXISTS get_total_sold_products(OUT total INT)
            BEGIN
                SELECT SUM(sd.quantity_sold) INTO total
                FROM sell_details sd
                JOIN sells s ON sd.sell_id = s.id
                WHERE s.payment_status = 'pagado';
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_total_sold_products");
    }
};
