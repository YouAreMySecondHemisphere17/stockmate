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
        CREATE PROCEDURE IF NOT EXISTS filter_categories(IN search_param VARCHAR(50))
        BEGIN
            SELECT * FROM categories
            WHERE category_name LIKE CONCAT('%', search_param, '%');
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS filter_categories");
    }
};
