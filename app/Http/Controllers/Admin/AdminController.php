<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Claim;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers   = User::whereIn('role', ['donatur', 'penerima'])->count();
        $totalItems   = Item::count();
        $totalClaims  = Claim::count();
        $itemTersalur = Claim::where('status', 'approved')->count();

        $recentUsers   = User::whereIn('role', ['donatur', 'penerima'])->latest()->take(5)->get();
        $recentItems   = Item::with('donatur')->latest()->take(5)->get();
        $pendingClaims = Claim::with(['item', 'penerima'])->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalItems', 'totalClaims', 'itemTersalur',
            'recentUsers', 'recentItems', 'pendingClaims'
        ));
    }

    public function users()
    {
        $users = User::whereIn('role', ['donatur', 'penerima'])
                     ->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => !$user->is_verified]);
        $status = $user->is_verified ? 'diverifikasi' : 'batal verifikasi';
        return back()->with('success', "User berhasil $status.");
    }

    public function items()
    {
        $items = Item::with('donatur')->latest()->paginate(15);
        return view('admin.items', compact('items'));
    }

    public function deleteItem(Item $item)
    {
        $hasActiveClaims = $item->claims()->whereIn('status', ['pending', 'approved'])->exists();
        if ($hasActiveClaims) {
            return back()->with('error', 'Tidak dapat menghapus barang yang memiliki klaim atau transaksi aktif.');
        }

        $item->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}