<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\Claim;

#[Signature('claims:cleanup')]
#[Description('Membersihkan klaim berstatus pending untuk barang berbayar yang tidak kunjung dibayar dalam 24 jam.')]
class CleanupExpiredClaims extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredClaims = Claim::where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(24))
            ->whereHas('item', function ($query) {
                $query->where('tipe', 'jual');
            })
            ->whereDoesntHave('payment', function ($query) {
                $query->whereIn('status', ['pending', 'verified']);
            })
            ->get();

        $count = 0;
        foreach ($expiredClaims as $claim) {
            $claim->update(['status' => 'rejected']);
            
            $item = $claim->item;
            $item->jumlah += $claim->jumlah;
            $item->status = 'available';
            $item->save();

            $count++;
        }

        $this->info("Berhasil membersihkan $count klaim yang kadaluarsa.");
    }
}
