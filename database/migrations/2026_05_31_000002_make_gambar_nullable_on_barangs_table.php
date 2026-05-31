<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE barangs MODIFY gambar VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement("UPDATE barangs SET gambar = '' WHERE gambar IS NULL");
        DB::statement('ALTER TABLE barangs MODIFY gambar VARCHAR(255) NOT NULL');
    }
};
