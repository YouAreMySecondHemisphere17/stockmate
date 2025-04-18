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
        CREATE PROCEDURE IF NOT EXISTS filter_products(
            IN search_param VARCHAR(100),
            IN filter_type VARCHAR(20)
        )
        BEGIN
            IF filter_type = 'product_name' THEN
                SELECT p.*, c.*
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.product_name LIKE CONCAT('%', search_param, '%');
            
            ELSEIF filter_type = 'category_id' THEN
                SELECT p.*, c.*
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE c.category_name LIKE CONCAT('%', search_param, '%');
            
            ELSE
                SELECT p.*, c.*
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.product_name LIKE CONCAT('%', search_param, '%')
                   OR c.category_name LIKE CONCAT('%', search_param, '%');
            END IF;
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
