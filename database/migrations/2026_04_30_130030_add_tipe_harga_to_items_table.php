<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->enum('tipe', ['donasi', 'jual'])->default('donasi')->after('nama_barang');
            $table->unsignedInteger('harga')->default(0)->after('tipe');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'harga']);
        });
    }
};