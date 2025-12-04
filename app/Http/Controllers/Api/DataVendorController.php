<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataVendor;
use App\Models\KategoriVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataVendorController extends Controller
{
//   GET /api/vendor
    public function index()
    {
        try {
            $vendors = DataVendor::with('kategori')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil diambil',
                'data' => $vendors
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

// POST /api/vendor
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
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $vendor = DataVendor::create([
                'id_kategori_vendor' => $request->id_kategori_vendor,
                'nama_vendor' => $request->nama_vendor,
                'alamat_vendor' => $request->alamat_vendor,
                'no_telp_vendor' => $request->no_telp_vendor,
                'deskripsi_vendor' => $request->deskripsi_vendor,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil ditambahkan',
                'data' => $vendor->load('kategori')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

//  GET /api/vendor/{id}
    public function show($id)
    {
        try {
            $vendor = DataVendor::with('kategori')->find($id);

            if (!$vendor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data vendor tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil diambil',
                'data' => $vendor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

//PUT/PATCH /api/vendor/{id}
    public function update(Request $request, $id)
    {
        try {
            $vendor = DataVendor::find($id);

            if (!$vendor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data vendor tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'id_kategori_vendor' => 'sometimes|required|integer|exists:kategori_vendors,id',
                'nama_vendor' => 'sometimes|required|string|max:255',
                'alamat_vendor' => 'sometimes|required|string',
                'no_telp_vendor' => 'sometimes|required|string|max:255',
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
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $vendor->update($request->only([
                'id_kategori_vendor',
                'nama_vendor',
                'alamat_vendor',
                'no_telp_vendor',
                'deskripsi_vendor'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil diupdate',
                'data' => $vendor->load('kategori')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

//DELETE /api/vendor/{id}
    public function destroy($id)
    {
        try {
            $vendor = DataVendor::find($id);

            if (!$vendor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data vendor tidak ditemukan'
                ], 404);
            }

            if ($vendor->purchaseOrders()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vendor tidak dapat dihapus karena masih memiliki ' . $vendor->purchaseOrders()->count() . ' purchase order'
                ], 400);
            }

            $vendor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

//GET /api/vendor/kategori/{kategoriId}
    public function getByCategory($kategoriId)
    {
        try {
            $kategori = KategoriVendor::find($kategoriId);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan'
                ], 404);
            }

            $vendors = DataVendor::where('id_kategori_vendor', $kategoriId)
                                 ->with('kategori')
                                 ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data vendor berhasil diambil',
                'kategori' => $kategori->nama_kategori,
                'jumlah_vendor' => $vendors->count(),
                'data' => $vendors
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}