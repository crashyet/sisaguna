<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = ['item_id', 'user_id', 'alasan', 'status', 'jumlah'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}