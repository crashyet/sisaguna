<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Claim $claim)
    {
        // Pastikan hanya pemilik klaim yang bisa akses
        abort_if($claim->user_id !== auth()->id(), 403);
        abort_if($claim->item->tipe !== 'jual', 404);

        $payment = $claim->payment;
        return view('penerima.payment', compact('claim', 'payment'));
    }

    public function store(Request $request, Claim $claim)
    {
        abort_if($claim->user_id !== auth()->id(), 403);
        abort_if($claim->item->tipe !== 'jual', 404);
        abort_if($claim->status !== 'pending', 403, 'Klaim ini tidak valid atau sudah kadaluarsa.');

        $request->validate([
            'metode'          => 'required|in:transfer,cod',
            'bukti_transfer'  => 'required_if:metode,transfer|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $bukti = null;
        if ($request->hasFile('bukti_transfer')) {
            $bukti = $request->file('bukti_transfer')->store('payments', 'public');
        }

        Payment::updateOrCreate(
            ['claim_id' => $claim->id],
            [
                'user_id'         => auth()->id(),
                'jumlah'          => $claim->item->harga * $claim->jumlah,
                'metode'          => $request->metode,
                'bukti_transfer'  => $bukti,
                'status'          => 'pending',
            ]
        );

        return redirect()->route('penerima.riwayat')
                         ->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi penjual.');
    }
}