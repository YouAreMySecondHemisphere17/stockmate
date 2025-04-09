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
        CREATE PROCEDURE IF NOT EXISTS filter_vendors(
            IN search_param VARCHAR(50),
            IN filter_type VARCHAR(20)
        )
        BEGIN
            IF filter_type = 'name' THEN
                SELECT * FROM vendors WHERE name LIKE CONCAT('%', search_param, '%');
            ELSEIF filter_type = 'email' THEN
                SELECT * FROM vendors WHERE email LIKE CONCAT('%', search_param, '%');
            ELSEIF filter_type = 'phone' THEN
                SELECT * FROM vendors WHERE phone LIKE CONCAT('%', search_param, '%');
            ELSE
                SELECT * FROM vendors
                WHERE name LIKE CONCAT('%', search_param, '%')
                   OR email LIKE CONCAT('%', search_param, '%')
                   OR phone LIKE CONCAT('%', search_param, '%');
            END IF;
        END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS filter_vendors");
    }
};
