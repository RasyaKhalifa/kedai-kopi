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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meja_id')
                ->constrained('mejas');
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans');
             $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admins');
            $table->dateTime('tanggal_pesanan');
            $table->integer('total_harga');
            $table->enum('status_pesanan',['Pending','Memasak','Selesai','Dibatalkan']);
            $table->enum('status_pembayaran',['Belum Bayar','Lunas']);
            $table->enum('metode_pembayaran',['Tunai','QRIS'])->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
