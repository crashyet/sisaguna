<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('foto')->nullable();
            $table->enum('kategori', ['bahan_baku', 'makanan_jadi', 'pakaian', 'peralatan', 'lainnya']);
            $table->integer('jumlah');
            $table->string('satuan');
            $table->date('expiry_date')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alamat');
            $table->string('kota');
            $table->enum('status', ['available', 'claimed', 'done', 'expired'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};