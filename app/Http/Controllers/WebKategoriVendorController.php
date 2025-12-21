<?php

namespace App\Http\Controllers;

use App\Models\KategoriVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebKategoriVendorController extends Controller
{
    public function index()
    {
        $kategoris = KategoriVendor::withCount('vendors')->get();
        return view('kategori-vendor.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori-vendor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255|unique:kategori_vendors,nama_kategori'
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            KategoriVendor::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return redirect()->route('kategori-vendor.index')
                ->with('success', 'Kategori vendor berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan kategori vendor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $kategori = KategoriVendor::findOrFail($id);
        return view('kategori-vendor.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriVendor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255|unique:kategori_vendors,nama_kategori,' . $id
        ], [
            'nama_kategori.required' => 'Nama kategori harus diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori
            ]);

            return redirect()->route('kategori-vendor.index')
                ->with('success', 'Kategori vendor berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate kategori vendor: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $kategori = KategoriVendor::findOrFail($id);

            if ($kategori->vendors()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $kategori->vendors()->count() . ' vendor');
            }

            $kategori->delete();

            return redirect()->route('kategori-vendor.index')
                ->with('success', 'Kategori vendor berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus kategori vendor: ' . $e->getMessage());
        }
    }
}