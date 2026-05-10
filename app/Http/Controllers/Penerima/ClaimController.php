<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // Cek apakah user sudah diverifikasi
        if (!auth()->user()->is_verified) {
            return back()->with('error', 'Akun Anda belum diverifikasi oleh admin. Anda tidak dapat mengajukan klaim.');
        }

        // User diizinkan melakukan klaim berkali-kali selama stok masih ada

        return DB::transaction(function () use ($request, $item) {
            $lockedItem = Item::where('id', $item->id)->lockForUpdate()->first();

            if (!$lockedItem || $lockedItem->jumlah < $request->jumlah) {
                return back()->with('error', 'Maaf, stok barang tidak mencukupi atau barang sudah habis.');
            }

            $request->validate([
                'alasan' => 'required|string|min:10|max:500',
                'jumlah' => 'required|integer|min:1|max:' . $lockedItem->jumlah,
            ]);

            $lockedItem->jumlah -= $request->jumlah;
            if ($lockedItem->jumlah <= 0) {
                $lockedItem->status = 'claimed';
            }
            $lockedItem->save();

            $claim = Claim::create([
                'item_id' => $lockedItem->id,
                'user_id' => auth()->id(),
                'alasan'  => $request->alasan,
                'jumlah'  => $request->jumlah,
                'status'  => 'pending',
            ]);

            if ($lockedItem->tipe === 'jual') {
                return redirect()->route('penerima.payment.show', $claim)
                                 ->with('success', 'Pesanan dibuat! Silakan lakukan pembayaran.');
            }

            return redirect()->route('penerima.riwayat')
                             ->with('success', 'Klaim berhasil diajukan!');
        });
    }


    public function riwayat()
    {
        $claims = Claim::where('user_id', auth()->id())
                       ->with('item')
                       ->latest()
                       ->paginate(10);

        return view('penerima.riwayat', compact('claims'));
    }
}