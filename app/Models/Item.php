<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id', 'nama_barang', 'tipe', 'harga', 'foto', 'kategori', 'kategori_lainnya',
        'jumlah', 'satuan', 'expiry_date', 'deskripsi',
        'alamat', 'kota', 'status'
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function donatur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}