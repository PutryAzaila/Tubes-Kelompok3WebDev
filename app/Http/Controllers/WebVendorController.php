<?php

namespace App\Http\Controllers;

use App\Models\DataVendor;
use App\Models\KategoriVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebVendorController extends Controller
{
    /**
     * Display a listing of vendors
     */
    public function index()
    {
        $vendors = DataVendor::with('kategori')->latest()->get();
        $kategoris = KategoriVendor::all();
        
        return view('vendor.index', compact('vendors', 'kategoris'));
    }

    /**
     * Show the form for creating a new vendor
     */
    public function create()
    {
        $kategoris = KategoriVendor::all();
        
        return view('vendor.create', compact('kategoris'));
    }

    /**
     * Store a newly created vendor in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori_vendor' => 'required|integer|exists:kategori_vendors,id',
            'nama_vendor' => 'required|string|max:255',
            'alamat_vendor' => 'required|string',
            'no_telp_vendor' => 'required|string|max:255',
            'deskripsi_vendor' => 'nullable|string'
        ], [
            'id_kategori_vendor.required' => 'Kategori vendor harus diisi',
            'id_kategori_vendor.exists' => 'Kategori vendor tidak ditemukan',
            'nama_vendor.required' => 'Nama vendor harus diisi',
            'nama_vendor.max' => 'Nama vendor maksimal 255 karakter',
            'alamat_vendor.required' => 'Alamat vendor harus diisi',
            'no_telp_vendor.required' => 'Nomor telepon vendor harus diisi',
            'no_telp_vendor.max' => 'Nomor telepon maksimal 255 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DataVendor::create([
                'id_kategori_vendor' => $request->id_kategori_vendor,
                'nama_vendor' => $request->nama_vendor,
                'alamat_vendor' => $request->alamat_vendor,
                'no_telp_vendor' => $request->no_telp_vendor,
                'deskripsi_vendor' => $request->deskripsi_vendor,
            ]);

            return redirect()->route('vendor.index')
                ->with('success', 'Data vendor berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data vendor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified vendor
     */
    public function edit($id)
    {
        $vendor = DataVendor::with('kategori')->findOrFail($id);
        $kategoris = KategoriVendor::all();
        
        return view('vendor.edit', compact('vendor', 'kategoris'));
    }

    /**
     * Update the specified vendor in storage
     */
    public function update(Request $request, $id)
    {
        $vendor = DataVendor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id_kategori_vendor' => 'required|integer|exists:kategori_vendors,id',
            'nama_vendor' => 'required|string|max:255',
            'alamat_vendor' => 'required|string',
            'no_telp_vendor' => 'required|string|max:255',
            'deskripsi_vendor' => 'nullable|string'
        ], [
            'id_kategori_vendor.required' => 'Kategori vendor harus diisi',
            'id_kategori_vendor.exists' => 'Kategori vendor tidak ditemukan',
            'nama_vendor.required' => 'Nama vendor harus diisi',
            'nama_vendor.max' => 'Nama vendor maksimal 255 karakter',
            'alamat_vendor.required' => 'Alamat vendor harus diisi',
            'no_telp_vendor.required' => 'Nomor telepon vendor harus diisi',
            'no_telp_vendor.max' => 'Nomor telepon maksimal 255 karakter'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $vendor->update([
                'id_kategori_vendor' => $request->id_kategori_vendor,
                'nama_vendor' => $request->nama_vendor,
                'alamat_vendor' => $request->alamat_vendor,
                'no_telp_vendor' => $request->no_telp_vendor,
                'deskripsi_vendor' => $request->deskripsi_vendor,
            ]);

            return redirect()->route('vendor.index')
                ->with('success', 'Data vendor berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate data vendor: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified vendor from storage
     */
    public function destroy($id)
    {
        try {
            $vendor = DataVendor::findOrFail($id);

            if ($vendor->purchaseOrders()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Vendor tidak dapat dihapus karena masih memiliki ' . $vendor->purchaseOrders()->count() . ' purchase order');
            }

            $vendor->delete();

            return redirect()->route('vendor.index')
                ->with('success', 'Data vendor berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data vendor: ' . $e->getMessage());
        }
    }
}