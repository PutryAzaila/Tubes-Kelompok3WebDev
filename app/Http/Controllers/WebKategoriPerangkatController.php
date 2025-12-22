<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriPerangkat;
use Illuminate\Http\Request;

class WebKategoriPerangkatController extends Controller
{
    // GET /kategori-perangkat
    public function index()
    {
        $kategoriPerangkats = KategoriPerangkat::withCount('perangkats')->latest()->get();
        return view('kategori-perangkat.index', compact('kategoriPerangkats'));
    }

    // GET /kategori-perangkat/create
    public function create()
    {
        return view('kategori-perangkat.create');
    }

    // POST /kategori-perangkat
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_perangkats,nama_kategori'
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        try {
            KategoriPerangkat::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return redirect()->route('kategori-perangkat.index')
                ->with('success', 'Kategori perangkat berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori perangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    // GET /kategori-perangkat/{id}/edit
    public function edit($id)
    {
        $kategori = KategoriPerangkat::findOrFail($id);
        return view('kategori-perangkat.edit', compact('kategori'));
    }

    // PUT /kategori-perangkat/{id}
    public function update(Request $request, $id)
    {
        $kategori = KategoriPerangkat::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_perangkats,nama_kategori,' . $id
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        try {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori
            ]);

            return redirect()->route('kategori-perangkat.index')
                ->with('success', 'Kategori perangkat berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate kategori perangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    // DELETE /kategori-perangkat/{id}
    public function destroy($id)
    {
        try {
            $kategori = KategoriPerangkat::findOrFail($id);

            if ($kategori->perangkats()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $kategori->perangkats()->count() . ' perangkat');
            }

            $kategori->delete();

            return redirect()->route('kategori-perangkat.index')
                ->with('success', 'Kategori perangkat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kategori perangkat: ' . $e->getMessage());
        }
    }
}