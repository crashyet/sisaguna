<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Claim;

class ClaimApprovalController extends Controller
{
    public function index()
    {
        $claims = Claim::whereHas('item', function($q) {
            $q->where('user_id', auth()->id());
        })->with(['item', 'penerima'])->latest()->paginate(10);

        return view('donatur.claims.index', compact('claims'));
    }

    public function approve(Claim $claim)
    {
        abort_if($claim->item->user_id !== auth()->id(), 403);
        
        $claim->update(['status' => 'approved']);

        return back()->with('success', 'Klaim disetujui!');
    }

    public function reject(Claim $claim)
    {
        abort_if($claim->item->user_id !== auth()->id(), 403);
        $claim->update(['status' => 'rejected']);
        
        // Kembalikan stok karena klaim ditolak
        $item = $claim->item;
        $item->jumlah += $claim->jumlah;
        $item->status = 'available';
        $item->save();

        return back()->with('success', 'Klaim ditolak. Stok telah dikembalikan.');
    }
}