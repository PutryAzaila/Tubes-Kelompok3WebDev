<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebInventoryController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('detailBarang.perangkat')->get();
        $barangKeluar = BarangKeluar::with('detailBarang.perangkat')->get();
        
        $data = $barangMasuk->merge($barangKeluar)->sortByDesc('tanggal');
        
        return view('inventory.index', compact('data'));
    }

    public function create()
    {
        $perangkats = Perangkat::all();
        return view('inventory.create', compact('perangkats'));
    }

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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
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
                BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => $request->sumber,
                ]);
            } else {
                BarangKeluar::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                    'status' => $request->perihal,
                ]);
            }

            return redirect()->route('inventory.index')
                ->with('success', 'Data inventori berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id, $type)
    {
        $perangkats = Perangkat::all();
        
        if ($type === 'masuk') {
            $inventory = BarangMasuk::with('detailBarang.perangkat')->findOrFail($id);
        } else {
            $inventory = BarangKeluar::with('detailBarang.perangkat')->findOrFail($id);
        }
        
        return view('inventory.edit', compact('inventory', 'perangkats', 'type'));
    }

    public function update(Request $request, $id, $type)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'stok' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            if ($type === 'masuk') {
                $inventory = BarangMasuk::findOrFail($id);
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                ]);
            } else {
                $inventory = BarangKeluar::findOrFail($id);
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                ]);
            }

            return redirect()->route('inventory.index')
                ->with('success', 'Data inventori berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id, $type)
    {
        try {
            if ($type === 'masuk') {
                BarangMasuk::findOrFail($id)->delete();
            } else {
                BarangKeluar::findOrFail($id)->delete();
            }

            return redirect()->route('inventory.index')
                ->with('success', 'Data inventori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}