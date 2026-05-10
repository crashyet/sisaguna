<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Claim;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Item::where('user_id', auth()->id())->count();
        $totalDisalurkan = Claim::whereHas('item', function($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'approved')->count();
        $requestPending = Claim::whereHas('item', function($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'pending')->count();

        $recentItems = Item::where('user_id', auth()->id())->latest()->take(5)->get();
        $recentClaims = Claim::with(['item', 'penerima'])->whereHas('item', function($q) {
            $q->where('user_id', auth()->id());
        })->latest()->take(5)->get();

        return view('donatur.dashboard', compact(
            'totalBarang', 'totalDisalurkan', 'requestPending',
            'recentItems', 'recentClaims'
        ));
    }
}