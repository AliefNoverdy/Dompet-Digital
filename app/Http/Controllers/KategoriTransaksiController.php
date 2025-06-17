<?php

namespace App\Http\Controllers;

use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        $data = KategoriTransaksi::all();
        return view('kategori.index', compact('data'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ], [
            'nama_kategori.required' => 'Kategori wajib diisi.'
        ]);

        KategoriTransaksi::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = KategoriTransaksi::findOrFail($id);
        return view('kategori.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ], [
            'nama_kategori.required' => 'Kategori wajib diisi.'
        ]);

        $item = KategoriTransaksi::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = KategoriTransaksi::findOrFail($id);
        $item->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
