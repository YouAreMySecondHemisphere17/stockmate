<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
/*     public function up(): void
    {
        DB::unprepared("
        CREATE PROCEDURE IF NOT EXISTS get_gross_profit(OUT grossProfit DECIMAL(10,2))
        BEGIN
            SELECT 
                SUM((sd.sold_price - p.purchase_price) * sd.quantity_sold) INTO grossProfit
            FROM 
                sell_details sd
            JOIN 
                products p ON sd.product_id = p.id;
        END
    ");
    } */

    public function up(): void
    {
        DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS get_gross_profit(OUT grossProfit DECIMAL(10,2))
            BEGIN
                SELECT 
                    SUM(((sd.sold_price - p.purchase_price) * sd.quantity_sold) - sd.discount) INTO grossProfit
                FROM 
                    sell_details sd
                JOIN 
                    products p ON sd.product_id = p.id;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS get_gross_profit");
    }
};
