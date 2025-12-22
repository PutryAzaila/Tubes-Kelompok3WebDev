<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriPerangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 class KategoriPerangkatController extends Controller
{
    // GET /api/kategori-perangkat
    public function index()
    {
        try {
            $kategori = KategoriPerangkat::with('perangkats')->get();

            return response()->json([
                'success' => true,
                'message' => 'Data kategori perangkat berhasil diambil',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/kategori-perangkat
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255|unique:kategori_perangkats,nama_kategori'
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
            $kategori = KategoriPerangkat::create([
                'nama_kategori' => $request->nama_kategori
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori perangkat berhasil ditambahkan',
                'data' => $kategori
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan kategori perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/kategori-perangkat/{id}
    public function show($id)
    {
        try {
            $kategori = KategoriPerangkat::with('perangkats')->find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori perangkat tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data kategori perangkat berhasil diambil',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kategori perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/kategori-perangkat/{id}
    public function update(Request $request, $id)
    {
        try {
            $kategori = KategoriPerangkat::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori perangkat tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama_kategori' => 'required|string|max:255|unique:kategori_perangkats,nama_kategori,' . $id
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
                'message' => 'Kategori perangkat berhasil diupdate',
                'data' => $kategori
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate kategori perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/kategori-perangkat/{id}
    public function destroy($id)
    {
        try {
            $kategori = KategoriPerangkat::find($id);

            if (!$kategori) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori perangkat tidak ditemukan'
                ], 404);
            }

            if ($kategori->perangkats()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh '
                        . $kategori->perangkats()->count() . ' perangkat'
                ], 400);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori perangkat berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
