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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            
            // Relasi
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('photographer_id')->constrained('photographers');
            $table->foreignId('location_id')->constrained('locations');
            $table->foreignId('user_id')->constrained('users'); // Kasir pembuat transaksi
            
            // Snapshot (Data history agar aman jika harga master berubah)
            $table->string('package_name_snapshot');
            $table->integer('package_price_snapshot');
            
            // Penjadwalan & Pembayaran
            $table->date('execution_date'); // Tanggal pemotretan
            $table->integer('amount_paid')->default(0); // Total uang yang sudah masuk (DP/Lunas)
            
            // Status
            $table->enum('payment_status', ['unpaid', 'down_payment', 'paid_off'])->default('unpaid');
            $table->enum('booking_status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
