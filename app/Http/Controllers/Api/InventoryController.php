<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use Illuminate\Http\Request;
use Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangMasuk = BarangMasuk::with('detailBarang.perangkat')->get();
        $barangKeluar = BarangKeluar::with('detailBarang.perangkat')->get();

        // combine data out and in into 1 data set, filter
        $data = $barangMasuk->merge($barangKeluar);

        return response()->json([
            'success' => true,
            'message' => 'Data inventori berhasil diambil',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'id_perangkat' => 'required|exists:perangkats,id',
            'jenis_inventori' => 'required|in:masuk,keluar',
            'stok' => 'required|integer|min:1',
            'kategori' => 'required|string|in:Non-Listrik,Listrik',
            'serial_number' => 'required_if:kategori,Listrik|string|nullable',
            'catatan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'sumber' => 'required_if:jenis_inventori,masuk|string|in:Customer,Vendor',
            'perihal' => 'required_if:jenis_inventori,keluar|string|in:Pemeliharaan,Penjualan,Instalasi'
        ], [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'id_perangkat.required' => 'Perangkat harus diisi',
            'id_perangkat.exists' => 'Perangkat tidak ditemukan',
            'jenis_inventori.required' => 'Jenis inventori harus diisi',
            'jenis_inventori.in' => 'Jenis inventori harus berupa "masuk" atau "keluar"',
            'stok.required' => 'Stok harus diisi',
            'stok.integer' => 'Stok harus berupa angka',
            'stok.min' => 'Stok minimal 1',
            'kategori.required' => 'Kategori harus diisi',
            'kategori.in' => 'Kategori harus berupa "Non-Listrik" atau "Listrik"',
            'catatan.string' => 'Catatan harus berupa teks',
            'alamat.string' => 'Alamat harus berupa teks',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $detailBarang = DetailBarang::firstOrCreate(
                [
                    'id_perangkat' => $request->id_perangkat,
                    'serial_number' => $request->serial_number,
                    'kategori' => $request->kategori,
                ]
            );

            if ($request->jenis_inventori === 'masuk') {
                $inventory = BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => $request->sumber,
                ]);
            } else {
                $inventory = BarangKeluar::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                    'status' => $request->perihal,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data inventori berhasil ditambahkan',
                'data' => $inventory
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data inventori',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
