<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\DetailBarang;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('=== INVENTORY STORE START ===');
        Log::info('Request Data:', $request->all());

        // Validasi dinamis berdasarkan kondisi
        $rules = [
            'tanggal' => 'required|date',
            'id_perangkat' => 'required|exists:perangkats,id',
            'jenis_inventori' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|in:Non-Listrik,Listrik',
            'has_serial' => 'required|boolean',
            'catatan' => 'nullable|string',
        ];

        // Tambah rules sesuai jenis
        if ($request->jenis_inventori === 'masuk') {
            $rules['sumber'] = 'required|string|in:Customer,Vendor';
            
            // Jika tidak ada serial, wajib ada stok
            if ($request->has_serial == 0) {
                $rules['stok'] = 'required|integer|min:1';
            }
        } else {
            $rules['perihal'] = 'required|string|in:Pemeliharaan,Penjualan,Instalasi';
            $rules['alamat'] = 'nullable|string';
            
            // Jika tidak ada serial, wajib ada stok
            if ($request->has_serial == 0) {
                $rules['stok'] = 'required|integer|min:1';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Log::info('Validation Passed');

        try {
            DB::beginTransaction();
            Log::info('Transaction Started');

            if ($request->jenis_inventori === 'masuk') {
                Log::info('Processing Barang Masuk...');
                $this->handleBarangMasuk($request);
            } else {
                Log::info('Processing Barang Keluar...');
                $this->handleBarangKeluar($request);
            }

            DB::commit();
            Log::info('Transaction Committed Successfully');
            Log::info('=== INVENTORY STORE SUCCESS ===');
            
            return redirect()->route('inventory.index')
                ->with('success', 'Data inventori berhasil ditambahkan');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== INVENTORY STORE ERROR ===');
            Log::error('Error Message: ' . $e->getMessage());
            Log::error('Error File: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function handleBarangMasuk($request)
    {
        Log::info('handleBarangMasuk - Sumber: ' . $request->sumber);
        Log::info('handleBarangMasuk - Has Serial: ' . $request->has_serial);
        
        if ($request->sumber === 'Vendor') {
            if ($request->has_serial) {
                // VENDOR dengan Serial Numbers
                Log::info('Vendor with Serial Numbers');
                
                $serialNumbers = $request->serial_numbers ?? [];
                // Filter serial numbers yang tidak kosong
                $serialNumbers = array_filter($serialNumbers, function($serial) {
                    return !empty(trim($serial));
                });
                
                Log::info('Serial Numbers:', $serialNumbers);
                
                if (empty($serialNumbers)) {
                    throw new \Exception('Serial number wajib diisi untuk barang dari Vendor');
                }

                foreach ($serialNumbers as $serial) {
                    Log::info('Creating DetailBarang for serial: ' . $serial);
                    
                    $detailBarang = DetailBarang::create([
                        'id_perangkat' => $request->id_perangkat,
                        'serial_number' => trim($serial),
                        'kategori' => $request->kategori,
                    ]);

                    Log::info('Creating BarangMasuk for detail_id: ' . $detailBarang->id);

                    BarangMasuk::create([
                        'detail_barang_id' => $detailBarang->id,
                        'tanggal' => $request->tanggal,
                        'jumlah' => 1,
                        'catatan_barang_masuk' => $request->catatan,
                        'status' => 'Vendor',
                    ]);
                }
            } else {
                // VENDOR tanpa Serial - bulk quantity
                Log::info('Vendor without Serial - Bulk quantity');
                Log::info('Stok value: ' . $request->stok);
                
                if (empty($request->stok) || $request->stok < 1) {
                    throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
                }
                
                $detailBarang = DetailBarang::firstOrCreate([
                    'id_perangkat' => $request->id_perangkat,
                    'serial_number' => null,
                    'kategori' => $request->kategori,
                ]);

                Log::info('DetailBarang ID: ' . $detailBarang->id);

                BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => 'Vendor',
                ]);
                
                Log::info('BarangMasuk created with stok: ' . $request->stok);
            }
            
        } else {
            // CUSTOMER
            Log::info('Customer Source');
            
            if ($request->has_serial) {
                $hasData = false;
                
                // Process RETURN serials (existing)
                $returnSerials = $request->return_serials ?? [];
                Log::info('Return Serials:', $returnSerials);
                
                if (!empty($returnSerials)) {
                    foreach ($returnSerials as $detailId) {
                        Log::info('Creating BarangMasuk for return serial, detail_id: ' . $detailId);
                        
                        BarangMasuk::create([
                            'detail_barang_id' => $detailId,
                            'tanggal' => $request->tanggal,
                            'jumlah' => 1,
                            'catatan_barang_masuk' => $request->catatan,
                            'status' => 'Customer',
                        ]);
                        $hasData = true;
                    }
                }
                
                // Process NEW serials from customer
                $serialNumbers = $request->serial_numbers ?? [];
                // Filter serial numbers yang tidak kosong
                $serialNumbers = array_filter($serialNumbers, function($serial) {
                    return !empty(trim($serial));
                });
                
                Log::info('New Serial Numbers from Customer:', $serialNumbers);
                
                if (!empty($serialNumbers)) {
                    foreach ($serialNumbers as $serial) {
                        Log::info('Creating new DetailBarang for customer serial: ' . $serial);
                        
                        $detailBarang = DetailBarang::create([
                            'id_perangkat' => $request->id_perangkat,
                            'serial_number' => trim($serial),
                            'kategori' => $request->kategori,
                        ]);

                        BarangMasuk::create([
                            'detail_barang_id' => $detailBarang->id,
                            'tanggal' => $request->tanggal,
                            'jumlah' => 1,
                            'catatan_barang_masuk' => $request->catatan,
                            'status' => 'Customer',
                        ]);
                        $hasData = true;
                    }
                }

                if (!$hasData) {
                    throw new \Exception('Minimal pilih 1 serial return atau input 1 serial baru');
                }
            } else {
                // CUSTOMER tanpa Serial - bulk quantity
                Log::info('Customer without Serial - Bulk quantity');
                Log::info('Stok value: ' . $request->stok);
                
                if (empty($request->stok) || $request->stok < 1) {
                    throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
                }
                
                $detailBarang = DetailBarang::firstOrCreate([
                    'id_perangkat' => $request->id_perangkat,
                    'serial_number' => null,
                    'kategori' => $request->kategori,
                ]);

                BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => 'Customer',
                ]);
                
                Log::info('BarangMasuk created with stok: ' . $request->stok);
            }
        }
        
        Log::info('handleBarangMasuk completed');
    }

    private function handleBarangKeluar($request)
    {
        Log::info('handleBarangKeluar - Has Serial: ' . $request->has_serial);
        
        if ($request->has_serial) {
            // Ada serial number - keluar per serial
            $selectedSerials = $request->selected_serials ?? [];
            Log::info('Selected Serials:', $selectedSerials);
            
            if (empty($selectedSerials)) {
                throw new \Exception('Pilih minimal 1 serial number yang akan keluar');
            }

            foreach ($selectedSerials as $detailId) {
                Log::info('Creating BarangKeluar for detail_id: ' . $detailId);
                
                BarangKeluar::create([
                    'detail_barang_id' => $detailId,
                    'tanggal' => $request->tanggal,
                    'jumlah' => 1,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                    'status' => $request->perihal,
                ]);
            }
        } else {
            // Tidak ada serial number - keluar bulk
            Log::info('Barang Keluar without Serial - Bulk');
            Log::info('Stok value: ' . $request->stok);
            
            if (empty($request->stok) || $request->stok < 1) {
                throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
            }
            
            $detailBarang = DetailBarang::where('id_perangkat', $request->id_perangkat)
                ->whereNull('serial_number')
                ->where('kategori', $request->kategori)
                ->first();

            if (!$detailBarang) {
                throw new \Exception('Barang tidak ditemukan di inventory');
            }

            Log::info('DetailBarang found, ID: ' . $detailBarang->id);

            // Check available stock
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $available = $totalMasuk - $totalKeluar;
            
            Log::info("Stock check - Masuk: $totalMasuk, Keluar: $totalKeluar, Available: $available");

            if ($available < $request->stok) {
                throw new \Exception("Stok tidak mencukupi. Tersedia: {$available}");
            }

            BarangKeluar::create([
                'detail_barang_id' => $detailBarang->id,
                'tanggal' => $request->tanggal,
                'jumlah' => $request->stok,
                'catatan_barang_keluar' => $request->catatan,
                'alamat' => $request->alamat ?? '',
                'status' => $request->perihal,
            ]);
            
            Log::info('BarangKeluar created with stok: ' . $request->stok);
        }
        
        Log::info('handleBarangKeluar completed');
    }

    public function getAvailableSerials(Request $request)
    {
        $perangkatId = $request->id_perangkat;
        $kategori = $request->kategori;

        $detailBarangs = DetailBarang::where('id_perangkat', $perangkatId)
            ->where('kategori', $kategori)
            ->whereNotNull('serial_number')
            ->with('perangkat')
            ->get();

        $available = $detailBarangs->filter(function($detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            return $totalMasuk > $totalKeluar;
        })->map(function($detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            $detail->available_stock = $totalMasuk - $totalKeluar;
            return $detail;
        });

        return response()->json([
            'success' => true,
            'data' => $available->values()
        ]);
    }

    public function getReturnableSerials(Request $request)
    {
        $perangkatId = $request->id_perangkat;
        $kategori = $request->kategori;

        $detailBarangs = DetailBarang::where('id_perangkat', $perangkatId)
            ->where('kategori', $kategori)
            ->whereNotNull('serial_number')
            ->with('perangkat')
            ->get();

        $returnable = $detailBarangs->filter(function($detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            return $totalKeluar > $totalMasuk;
        })->map(function($detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            $detail->out_stock = $totalKeluar - $totalMasuk;
            return $detail;
        });

        return response()->json([
            'success' => true,
            'data' => $returnable->values()
        ]);
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