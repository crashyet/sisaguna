<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentVerifyController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('claim.item', function($q) {
            $q->where('user_id', auth()->id());
        })->with(['claim.item', 'claim.penerima'])->latest()->paginate(10);

        return view('donatur.payment', compact('payments'));
    }

    public function verify(Payment $payment)
    {
        abort_if($payment->claim->item->user_id !== auth()->id(), 403);
        abort_if($payment->status !== 'pending', 400, 'Pembayaran ini sudah diproses.');
        
        $payment->update(['status' => 'verified']);
        $payment->claim->update(['status' => 'approved']);
        
        return back()->with('success', 'Pembayaran dikonfirmasi, klaim disetujui!');
    }

    public function reject(Payment $payment)
    {
        abort_if($payment->claim->item->user_id !== auth()->id(), 403);
        abort_if($payment->status !== 'pending', 400, 'Pembayaran ini sudah diproses.');
        
        $payment->update(['status' => 'rejected']);
        
        $claim = $payment->claim;
        if ($claim->status === 'pending') {
            $claim->update(['status' => 'rejected']);
            
            $item = $claim->item;
            $item->jumlah += $claim->jumlah;
            $item->status = 'available';
            $item->save();
        }

        return back()->with('success', 'Pembayaran ditolak. Klaim dibatalkan dan stok dikembalikan.');
    }
}