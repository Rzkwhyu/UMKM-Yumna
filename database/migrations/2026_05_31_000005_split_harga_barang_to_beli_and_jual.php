<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->integer('harga_beli')->default(0)->after('kategori_id');
            $table->integer('harga_jual')->default(0)->after('harga_beli');
        });

        DB::table('barangs')->update([
            'harga_jual' => DB::raw('harga'),
            'harga_beli' => DB::raw('harga'),
        ]);

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->integer('harga')->default(0)->after('kategori_id');
        });

        DB::table('barangs')->update([
            'harga' => DB::raw('harga_jual'),
        ]);

        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['harga_beli', 'harga_jual']);
        });
    }
};
