<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::where('user_id', auth()->id())->latest()->paginate(10);
        return view('donatur.items.index', compact('items'));
    }

    public function create()
    {
        if (!auth()->user()->is_verified) {
            return redirect()->route('donatur.dashboard')->with('error', 'Akun Anda belum diverifikasi oleh admin. Anda tidak dapat mengupload barang.');
        }
        return view('donatur.items.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->is_verified) {
            return redirect()->route('donatur.dashboard')->with('error', 'Akun Anda belum diverifikasi oleh admin. Anda tidak dapat mengupload barang.');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required',
            'kategori_lainnya' => 'required_if:kategori,lainnya|nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'expiry_date' => 'nullable|date|after:today',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:donasi,jual',
            'harga' => 'nullable|integer|min:0',
        ]);

        $foto = $request->file('foto')->store('items', 'public');

        Item::create([
            'user_id' => auth()->id(),
            'nama_barang' => $request->nama_barang,
            'foto' => $foto,
            'kategori' => $request->kategori,
            'kategori_lainnya' => $request->kategori === 'lainnya' ? $request->kategori_lainnya : null,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'expiry_date' => $request->expiry_date,
            'deskripsi' => $request->deskripsi,
            'status' => 'available',
            'tipe' => $request->tipe,
            'harga'           => $request->tipe === 'jual' ? (int) $request->harga : 0,
        ]);

        return redirect()->route('donatur.items.index')
            ->with('success', 'Barang berhasil diupload!');
    }

    public function edit(Item $item)
    {
        abort_if($item->user_id !== auth()->id(), 403);
        return view('donatur.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        abort_if($item->user_id !== auth()->id(), 403);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori' => 'required',
            'kategori_lainnya' => 'required_if:kategori,lainnya|nullable|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'alamat' => 'required|string',
            'kota' => 'required|string',
            'tipe' => 'required|in:donasi,jual',
            'harga' => 'nullable|integer|min:0',
        ]);

        $hasPendingClaims = $item->claims()->where('status', 'pending')->exists();
        if ($hasPendingClaims) {
            if ($request->tipe !== $item->tipe || $request->harga != $item->harga || $request->jumlah != $item->jumlah) {
                return back()->with('error', 'Tidak dapat mengubah tipe, harga, atau jumlah stok karena sedang ada transaksi/klaim yang berjalan.');
            }
        }

        $data = $request->except('foto');
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('items', 'public');
        }

        if ($data['kategori'] !== 'lainnya') {
            $data['kategori_lainnya'] = null;
        }

        // Pastikan harga selalu tersimpan sebagai integer (hindari floating-point dari JS)
        if (isset($data['harga'])) {
            $data['harga'] = (int) $data['harga'];
        }

        $item->update($data);
        return redirect()->route('donatur.items.index')
            ->with('success', 'Barang berhasil diupdate!');
    }

    public function destroy(Item $item)
    {
        abort_if($item->user_id !== auth()->id(), 403);
        
        $hasPendingClaims = $item->claims()->where('status', 'pending')->exists();
        if ($hasPendingClaims) {
            return back()->with('error', 'Tidak dapat menghapus barang karena sedang ada transaksi/klaim yang berjalan.');
        }

        $item->delete();
        return redirect()->route('donatur.items.index')
            ->with('success', 'Barang berhasil dihapus!');
    }
}