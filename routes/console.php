<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Claim;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Auto-cancel klaim hantu (lebih dari 24 jam)
Schedule::call(function () {
    $expiredClaims = Claim::where('status', 'pending')
        ->where('created_at', '<', now()->subHours(24))
        // Jangan batalkan jika penerima sudah upload bukti pembayaran yang sedang menunggu verifikasi
        ->whereDoesntHave('payment', function($q) {
            $q->whereIn('status', ['pending', 'verified']);
        })
        ->get();

    foreach ($expiredClaims as $claim) {
        // Ubah status klaim menjadi kadaluarsa/ditolak otomatis
        $claim->update(['status' => 'expired']);

        // Kembalikan stok
        $item = $claim->item;
        if ($item) {
            $item->jumlah += $claim->jumlah;
            $item->status = 'available';
            $item->save();
        }
    }
})->hourly();
