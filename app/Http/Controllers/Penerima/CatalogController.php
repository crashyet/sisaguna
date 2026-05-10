<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Claim;

class CatalogController extends Controller
{
    public function index()
    {
        // Dashboard: statistik personal + barang terbaru
        $totalKlaim = Claim::where('user_id', auth()->id())->count();
        $klaimDisetujui = Claim::where('user_id', auth()->id())
                               ->where('status', 'approved')->count();
        $barangTerbaru = Item::withSum(['claims' => function($q) {
                                 $q->where('status', 'approved');
                             }], 'jumlah')
                             ->where('status', 'available')
                             ->latest()->take(6)->get();

        $recentClaims = Claim::with('item')->where('user_id', auth()->id())->latest()->take(5)->get();

        return view('penerima.dashboard', compact(
            'totalKlaim', 'klaimDisetujui', 'barangTerbaru', 'recentClaims'
        ));
    }

    public function katalog()
    {
        $query = Item::with('donatur')
                     ->withSum(['claims' => function($q) {
                         $q->where('status', 'approved');
                     }], 'jumlah')
                     ->where('status', 'available')
                     ->latest();

        // Filter kota
        if (request('kota')) {
            $query->where('kota', 'like', '%' . request('kota') . '%');
        }

        // Filter kategori
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        //Filter Tipe 
        if (request('tipe')) {
            $query->where('tipe', request('tipe'));
        }

        $items = $query->paginate(12);

        return view('penerima.katalog', compact('items'));
    }
}