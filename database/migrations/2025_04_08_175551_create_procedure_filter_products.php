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
            DROP PROCEDURE IF EXISTS filter_products;
        ");

        DB::unprepared("
            CREATE PROCEDURE filter_products(
                IN search_param VARCHAR(100),
                IN filter_type VARCHAR(20)
            )
            BEGIN
                IF filter_type = 'product_name' THEN
                    SELECT p.*, c.category_name, v.name AS vendor_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN vendors v ON p.vendor_id = v.id
                    WHERE p.product_name LIKE CONCAT('%', search_param, '%');

                ELSEIF filter_type = 'category_id' THEN
                    SELECT p.*, c.category_name, v.name AS vendor_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN vendors v ON p.vendor_id = v.id
                    WHERE c.category_name LIKE CONCAT('%', search_param, '%');

                ELSEIF filter_type = 'vendor_id' THEN
                    SELECT p.*, c.category_name, v.name AS vendor_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN vendors v ON p.vendor_id = v.id
                    WHERE v.name LIKE CONCAT('%', search_param, '%');

                ELSEIF filter_type = 'details' THEN
                    SELECT p.*, c.category_name, v.name AS vendor_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN vendors v ON p.vendor_id = v.id
                    WHERE p.details LIKE CONCAT('%', search_param, '%');

                ELSE
                    SELECT p.*, c.category_name, v.name AS vendor_name
                    FROM products p
                    LEFT JOIN categories c ON p.category_id = c.id
                    LEFT JOIN vendors v ON p.vendor_id = v.id
                    WHERE p.product_name LIKE CONCAT('%', search_param, '%')
                       OR c.category_name LIKE CONCAT('%', search_param, '%')
                       OR v.name LIKE CONCAT('%', search_param, '%')
                       OR p.details LIKE CONCAT('%', search_param, '%');
                END IF;
            END;
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
