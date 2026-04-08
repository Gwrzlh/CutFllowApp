<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // 1. Hapus Foreign Key-nya dulu (Ini kuncinya!)
            $table->dropForeign(['location_id']); 
            
            // 2. Baru hapus kolomnya
            $table->dropColumn(['location_id', 'package_name_snapshot']);

            // 3. Rename kolom snapshot harga agar lebih umum
            $table->renameColumn('package_price_snapshot', 'total_amount');

            // 4. Tambah kolom kembalian (untuk audit)
            $table->integer('cash_change')->default(0)->after('amount_paid');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Balikkan keadaan jika rollback (Opsional tapi disarankan)
            $table->renameColumn('total_amount', 'package_price_snapshot');
            $table->dropColumn('cash_change');
            
            $table->unsignedBigInteger('location_id')->after('photographer_id');
            $table->string('package_name_snapshot')->after('location_id');
            
            $table->foreign('location_id')->references('id')->on('lokasi');
        });
    }
};
