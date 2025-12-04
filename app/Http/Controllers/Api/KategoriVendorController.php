<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriVendorController extends Controller
{
//    GET /api/kategori-vendor
    public function index()
    {
        try {
            $kategori = KategoriVendor::with('vendors')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Data kategori vendor berhasil diambil',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/kategori-vendor
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
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $kategori = KategoriVendor::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori vendor berhasil ditambahkan',
                'data' => $kategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/kategori-vendor/{id}
    public function show($id)
    {
        try {
            $kategori = KategoriVendor::with('vendors')->find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori vendor tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori vendor berhasil diambil',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT/PATCH /api/kategori-vendor/{id}
    public function update(Request $request, $id)
    {
        try {
            $kategori = KategoriVendor::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori vendor tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required|string|max:255|unique:kategori_vendors,nama_kategori,' . $id
            ], [
                'nama_kategori.required' => 'Nama kategori harus diisi',
                'nama_kategori.unique' => 'Nama kategori sudah digunakan',
                'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $kategori->update([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori vendor berhasil diupdate',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kategori vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/kategori-vendor/{id}
    public function destroy($id)
    {
        try {
            $kategori = KategoriVendor::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori vendor tidak ditemukan'
                ], 404);
            }

            if ($kategori->vendors()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $kategori->vendors()->count() . ' vendor'
                ], 400);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori vendor berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori vendor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}