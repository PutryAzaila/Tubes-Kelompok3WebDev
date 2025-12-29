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

        $stockData = $this->calculateActualStock();
        
        return view('inventory.index', array_merge(
            compact('data'),
            $stockData
        ));
    }

    private function calculateActualStock()
    {
        Log::info('=== CALCULATE ACTUAL STOCK (INVENTORY INDEX) ===');
        
        $detailBarangs = DetailBarang::all();
        
        $totalMasuk = 0;
        $totalKeluar = 0;
        $totalStokTersedia = 0;
        
        $itemsWithStock = 0;
        $itemsOutOfStock = 0;
        
        foreach ($detailBarangs as $detail) {
            $masuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $keluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            $stok = $masuk - $keluar;
            
            $totalMasuk += $masuk;
            $totalKeluar += $keluar;
            
            if ($stok > 0) {
                $totalStokTersedia += $stok;
                $itemsWithStock++;
            } elseif ($masuk > 0) { 
                $itemsOutOfStock++;
            }
            
            $serialInfo = $detail->serial_number ? "SN: {$detail->serial_number}" : "Non-Serial";
            Log::info("Detail ID {$detail->id} ({$serialInfo}) - Masuk: {$masuk}, Keluar: {$keluar}, Stok: {$stok}");
        }
        
        $stokStatus = '';
        $stokIcon = 'fa-box';
        
        if ($totalStokTersedia === 0) {
            $stokStatus = 'Stok Habis';
            $stokIcon = 'fa-exclamation-triangle';
        } elseif ($totalStokTersedia < 10) {
            $stokStatus = 'Stok Menipis';
            $stokIcon = 'fa-exclamation-circle';
        } else {
            $stokStatus = 'Stok Aman';
            $stokIcon = 'fa-box';
        }
        
        Log::info("RESULT => Total Masuk: {$totalMasuk}, Total Keluar: {$totalKeluar}, Stok Tersedia: {$totalStokTersedia}");
        Log::info("Items with stock: {$itemsWithStock}, Items out of stock: {$itemsOutOfStock}");
        
        return [
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'totalStok' => $totalStokTersedia,
            'stokStatus' => $stokStatus,
            'stokIcon' => $stokIcon,
            'itemsWithStock' => $itemsWithStock,
            'itemsOutOfStock' => $itemsOutOfStock,
        ];
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

        $rules = [
            'tanggal' => 'required|date',
            'id_perangkat' => 'required|exists:perangkats,id',
            'jenis_inventori' => 'required|in:masuk,keluar',
            'kategori' => 'required|string|in:Non-Listrik,Listrik',
            'has_serial' => 'required|in:0,1',
            'catatan' => 'nullable|string',
        ];

        if ($request->jenis_inventori === 'masuk') {
            $rules['sumber'] = 'required|string|in:Customer,Vendor';
            
            if ($request->has_serial == '0') {
                $rules['stok'] = 'required|integer|min:1';
                Log::info('Validation: Stok is REQUIRED (no serial)');
            }
        } else {
            $rules['perihal'] = 'required|string|in:Pemeliharaan,Penjualan,Instalasi';
            $rules['alamat'] = 'nullable|string';
            
            if ($request->has_serial == '0') {
                $rules['stok'] = 'required|integer|min:1';
                Log::info('Validation: Stok is REQUIRED (no serial)');
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            
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
            
            $jenisText = $request->jenis_inventori === 'masuk' ? 'masuk' : 'keluar';
            $itemCount = 1; 

            if ($request->has_serial == '0') {
                $itemCount = intval($request->stok);
            } else {
                if ($request->jenis_inventori === 'masuk') {
                    if ($request->sumber === 'Vendor') {
                        $itemCount = count(array_filter($request->serial_numbers ?? [], function($s) {
                            return !empty(trim($s));
                        }));
                    } else if ($request->sumber === 'Customer') {
                        $returnCount = count($request->return_serials ?? []);
                        $newCount = count(array_filter($request->serial_numbers ?? [], function($s) {
                            return !empty(trim($s));
                        }));
                        $itemCount = $returnCount + $newCount;
                    }
                } else {
                    $itemCount = count($request->selected_serials ?? []);
                }
            }

            $perangkat = Perangkat::find($request->id_perangkat);
            $perangkatName = $perangkat ? $perangkat->nama_perangkat : 'barang';

            $successMessage = "Berhasil! {$itemCount} unit {$perangkatName} telah ditambahkan sebagai barang {$jenisText}.";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'data' => [
                        'item_count' => $itemCount,
                        'perangkat_name' => $perangkatName,
                        'jenis' => $jenisText
                    ]
                ]);
            }
            
            return redirect()->route('inventory.index')
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== INVENTORY STORE ERROR ===');
            Log::error('Error Message: ' . $e->getMessage());
            Log::error('Error File: ' . $e->getFile() . ':' . $e->getLine());
            Log::error('Stack Trace: ' . $e->getTraceAsString());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

private function handleBarangMasuk($request)
{
    Log::info('handleBarangMasuk - START');
    Log::info('Sumber: ' . $request->sumber);
    Log::info('Has Serial: ' . $request->has_serial);
    
    $hasSerial = $request->has_serial == '1';
    
    if ($request->sumber === 'Vendor') {
        if ($hasSerial) {
            Log::info('Vendor with Serial Numbers');
            
            $serialNumbers = $request->serial_numbers ?? [];
            $serialNumbers = array_filter($serialNumbers, function($serial) {
                return !empty(trim($serial));
            });
            
            Log::info('Serial Numbers:', $serialNumbers);
            
            if (empty($serialNumbers)) {
                throw new \Exception('Serial number wajib diisi untuk barang dari Vendor');
            }

            foreach ($serialNumbers as $serial) {
                Log::info('Creating DetailBarang for serial: ' . $serial);
                
                $existingDetail = DetailBarang::where('serial_number', trim($serial))
                    ->where('id_perangkat', $request->id_perangkat)
                    ->where('kategori', $request->kategori)
                    ->first();
                
                if ($existingDetail) {
                    throw new \Exception("Serial number '{$serial}' sudah terdaftar di sistem!");
                }
                
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
                    'status' => 'Vendor',
                ]);
            }
        } else {
            Log::info('Vendor without Serial - Bulk quantity');
            $stok = intval($request->stok);
            
            if (empty($stok) || $stok < 1) {
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
                'jumlah' => $stok,
                'catatan_barang_masuk' => $request->catatan,
                'status' => 'Vendor',
            ]);
        }
        
    } else { 
        Log::info('Customer Source - Return Only');
        
        if ($hasSerial) {

            $returnSerials = $request->return_serials ?? [];
            Log::info('Return Serials (Detail IDs):', $returnSerials);
            
            if (empty($returnSerials)) {
                throw new \Exception('Pilih minimal 1 serial number yang akan di-return!');
            }
            
            foreach ($returnSerials as $detailId) {
                $detail = DetailBarang::find($detailId);
                if (!$detail) {
                    throw new \Exception("Detail barang ID {$detailId} tidak ditemukan!");
                }
                
                $allMasuk = BarangMasuk::where('detail_barang_id', $detailId)->get();
                $allKeluar = BarangKeluar::where('detail_barang_id', $detailId)->get();
                
                $totalMasuk = $allMasuk->sum('jumlah');
                $totalKeluar = $allKeluar->sum('jumlah');
                
                $customerReturns = $allMasuk->where('status', 'Customer')->sum('jumlah');
                
                $currentlyOut = $totalKeluar - $customerReturns;
                
                Log::info("=== VALIDATION RETURN FOR SERIAL: {$detail->serial_number} ===");
                Log::info("Total Masuk: {$totalMasuk}");
                Log::info("Total Keluar: {$totalKeluar}");
                Log::info("Customer Returns (existing): {$customerReturns}");
                Log::info("Currently Out (calculation): {$currentlyOut}");
                
                if ($currentlyOut <= 0) {
                    throw new \Exception("Serial '{$detail->serial_number}' tidak sedang disewa! (Semua sudah dikembalikan)");
                }
                
                BarangMasuk::create([
                    'detail_barang_id' => $detailId,
                    'tanggal' => $request->tanggal,
                    'jumlah' => 1,
                    'catatan_barang_masuk' => 'RETURN - ' . ($request->catatan ?? ''),
                    'status' => 'Customer',
                ]);
                
                Log::info("✓ Successfully recorded return for serial: {$detail->serial_number}");
            }
            
        } else {
            Log::info('Customer without Serial - Bulk quantity return');
            $stok = intval($request->stok);
            
            if (empty($stok) || $stok < 1) {
                throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
            }
            
            $detailBarang = DetailBarang::where('id_perangkat', $request->id_perangkat)
                ->whereNull('serial_number')
                ->where('kategori', $request->kategori)
                ->first();
            
            if (!$detailBarang) {
                throw new \Exception('Barang tidak ditemukan di sistem!');
            }
            
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $currentlyOut = $totalKeluar - $totalMasuk;
            
            if ($currentlyOut < $stok) {
                throw new \Exception("Tidak bisa return {$stok} unit. Barang yang sedang keluar: {$currentlyOut} unit");
            }

            BarangMasuk::create([
                'detail_barang_id' => $detailBarang->id,
                'tanggal' => $request->tanggal,
                'jumlah' => $stok,
                'catatan_barang_masuk' => 'RETURN - ' . ($request->catatan ?? ''),
                'status' => 'Customer',
            ]);
        }
    }
    
    Log::info('handleBarangMasuk - COMPLETED');
}
    private function handleBarangKeluar($request)
    {
        Log::info('handleBarangKeluar - START');
        Log::info('Has Serial: ' . $request->has_serial);
        
        $hasSerial = $request->has_serial == '1';
        
        if ($hasSerial) {
            $selectedSerials = $request->selected_serials ?? [];
            Log::info('Selected Serials:', $selectedSerials);
            
            if (empty($selectedSerials)) {
                throw new \Exception('Pilih minimal 1 serial number yang akan keluar');
            }

            foreach ($selectedSerials as $detailId) {
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
            Log::info('Barang Keluar without Serial - Bulk');
            Log::info('Stok value from request: ' . $request->stok);
            
            $stok = intval($request->stok);
            
            if (empty($stok) || $stok < 1) {
                Log::error('Stok empty or invalid: ' . $stok);
                throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
            }
            
            Log::info('Stok after intval: ' . $stok);
            
            $detailBarang = DetailBarang::where('id_perangkat', $request->id_perangkat)
                ->whereNull('serial_number')
                ->where('kategori', $request->kategori)
                ->first();

            if (!$detailBarang) {
                throw new \Exception('Barang tidak ditemukan di inventory');
            }

            Log::info('DetailBarang found, ID: ' . $detailBarang->id);

            $totalMasuk = BarangMasuk::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detailBarang->id)->sum('jumlah');
            $available = $totalMasuk - $totalKeluar;
            
            Log::info("Stock check - Masuk: $totalMasuk, Keluar: $totalKeluar, Available: $available");

            if ($available < $stok) {
                throw new \Exception("Stok tidak mencukupi. Tersedia: {$available}");
            }

            $barangKeluar = BarangKeluar::create([
                'detail_barang_id' => $detailBarang->id,
                'tanggal' => $request->tanggal,
                'jumlah' => $stok,
                'catatan_barang_keluar' => $request->catatan,
                'alamat' => $request->alamat ?? '',
                'status' => $request->perihal,
            ]);
            
            Log::info('BarangKeluar created successfully with ID: ' . $barangKeluar->id . ', jumlah: ' . $barangKeluar->jumlah);
        }
        
        Log::info('handleBarangKeluar - COMPLETED');
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

    Log::info('=== GET RETURNABLE SERIALS (FIXED FOR RENTAL) ===');
    Log::info("Perangkat ID: {$perangkatId}, Kategori: {$kategori}");

    $detailBarangs = DetailBarang::where('id_perangkat', $perangkatId)
        ->where('kategori', $kategori)
        ->whereNotNull('serial_number')
        ->with('perangkat')
        ->get();

    Log::info("Total DetailBarang found: " . $detailBarangs->count());

    $returnableData = [];
    
    foreach ($detailBarangs as $detail) {
        // Ambil semua transaksi
        $barangMasukRecords = BarangMasuk::where('detail_barang_id', $detail->id)->get();
        $barangKeluarRecords = BarangKeluar::where('detail_barang_id', $detail->id)->get();
        
        // Total transaksi
        $totalMasuk = $barangMasukRecords->sum('jumlah');
        $totalKeluar = $barangKeluarRecords->sum('jumlah');
        
        Log::info("─────────────────────────────────────");
        Log::info("Detail ID: {$detail->id}");
        Log::info("Serial Number: {$detail->serial_number}");
        Log::info("Total Masuk: {$totalMasuk}");
        Log::info("Total Keluar: {$totalKeluar}");
        
        // Detail transaksi masuk
        if ($barangMasukRecords->count() > 0) {
            Log::info("Detail Barang Masuk:");
            foreach ($barangMasukRecords as $masuk) {
                Log::info("  - ID: {$masuk->id}, Tanggal: {$masuk->tanggal}, Jumlah: {$masuk->jumlah}, Status: {$masuk->status}");
            }
        }
        
        // Detail transaksi keluar
        if ($barangKeluarRecords->count() > 0) {
            Log::info("Detail Barang Keluar:");
            foreach ($barangKeluarRecords as $keluar) {
                Log::info("  - ID: {$keluar->id}, Tanggal: {$keluar->tanggal}, Jumlah: {$keluar->jumlah}, Status: {$keluar->status}");
            }
        }
        
        $customerReturns = $barangMasukRecords->whereIn('status', ['Customer Return', 'Customer', 'Customer New'])->sum('jumlah');
        
        $currentlyOut = $totalKeluar - $customerReturns;
        
        Log::info("Customer Returns: {$customerReturns}");
        Log::info("Currently Out (Keluar - Customer Returns): {$currentlyOut}");
        
        if ($totalKeluar > 0 && $currentlyOut > 0) {
            Log::info("✓ RETURNABLE - Barang sedang disewa (belum di-return)");
            
            $lastKeluar = $barangKeluarRecords->sortByDesc('tanggal')->first();
            
            $returnableData[] = [
                'id' => $detail->id,
                'serial_number' => $detail->serial_number,
                'out_stock' => $currentlyOut,
                'last_out_date' => $lastKeluar ? $lastKeluar->tanggal : null,
                'last_out_status' => $lastKeluar ? $lastKeluar->status : null,
                'last_out_alamat' => $lastKeluar ? $lastKeluar->alamat : null,
                'perangkat' => $detail->perangkat,
            ];
        } else {
            Log::info("✗ NOT RETURNABLE");
            if ($totalKeluar === 0) {
                Log::info("  → Belum pernah keluar");
            } else if ($currentlyOut <= 0) {
                Log::info("  → Semua yang keluar sudah di-return");
            }
        }
    }

    Log::info("Total Returnable Items: " . count($returnableData));

    return response()->json([
        'success' => true,
        'data' => $returnableData,
        'message' => count($returnableData) > 0 
            ? "Ditemukan " . count($returnableData) . " barang yang sedang disewa" 
            : "Tidak ada barang yang sedang disewa",
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
        Log::info('=== INVENTORY UPDATE START ===');
        Log::info('ID: ' . $id . ', Type: ' . $type);
        Log::info('Request Data:', $request->all());
        
        $rules = [
            'tanggal' => 'required|date',
            'stok' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'alamat' => 'nullable|string',
        ];
        
        if ($request->has('serial_number')) {
            $rules['serial_number'] = 'required|string|max:255';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::error('Validation Failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();
            
            if ($type === 'masuk') {
                $inventory = BarangMasuk::with('detailBarang')->findOrFail($id);
                
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                ]);
                
                Log::info('BarangMasuk updated successfully');
                
            } else {
                $inventory = BarangKeluar::with('detailBarang')->findOrFail($id);
                
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                ]);
                
                Log::info('BarangKeluar updated successfully');
            }
            
            if ($request->has('serial_number') && $inventory->detailBarang) {
                $oldSerial = $inventory->detailBarang->serial_number;
                $newSerial = $request->serial_number;
                
                if ($oldSerial !== $newSerial) {
                    $existingSerial = DetailBarang::where('serial_number', $newSerial)
                        ->where('id', '!=', $inventory->detailBarang->id)
                        ->first();
                    
                    if ($existingSerial) {
                        throw new \Exception('Serial number "' . $newSerial . '" sudah digunakan untuk barang lain!');
                    }
                    
                    $inventory->detailBarang->update([
                        'serial_number' => $newSerial
                    ]);
                    
                    Log::info('Serial Number updated from "' . $oldSerial . '" to "' . $newSerial . '"');
                }
            }
            
            DB::commit();
            Log::info('=== INVENTORY UPDATE SUCCESS ===');

            $jenisText = $type === 'masuk' ? 'masuk' : 'keluar';
            $perangkatName = $inventory->detailBarang->perangkat->nama_perangkat ?? 'barang';

            return redirect()->route('inventory.index')
                ->with('success', "Berhasil! Data {$perangkatName} ({$jenisText}) telah diperbarui.");
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== INVENTORY UPDATE ERROR ===');
            Log::error('Error Message: ' . $e->getMessage());
            Log::error('Error File: ' . $e->getFile() . ':' . $e->getLine());
            
            return redirect()->back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }
}