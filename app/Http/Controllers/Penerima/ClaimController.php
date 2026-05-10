<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // Cek apakah user sudah diverifikasi
        if (!auth()->user()->is_verified) {
            return back()->with('error', 'Akun Anda belum diverifikasi oleh admin. Anda tidak dapat mengajukan klaim.');
        }

        // User diizinkan melakukan klaim berkali-kali selama stok masih ada

        $request->validate([
            'alasan' => 'required|string|min:10|max:500',
            'jumlah' => 'required|integer|min:1|max:' . $item->jumlah,
        ]);

        // Kurangi stok seketika untuk mencegah race condition (overselling)
        $item->jumlah -= $request->jumlah;
        if ($item->jumlah <= 0) {
            $item->status = 'claimed';
        }
        $item->save();

        $claim = Claim::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'alasan'  => $request->alasan,
            'jumlah'  => $request->jumlah,
            'status'  => 'pending',
        ]);

          // Kalau barang jual → langsung ke halaman pembayaran
        if ($item->tipe === 'jual') {
            return redirect()->route('penerima.payment.show', $claim)
                             ->with('success', 'Pesanan dibuat! Silakan lakukan pembayaran.');
            }

            return redirect()->route('penerima.riwayat')
                             ->with('success', 'Klaim berhasil diajukan!');
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