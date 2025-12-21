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

    // Replace the store() method in WebInventoryController.php

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
        'has_serial' => 'required|in:0,1',
        'catatan' => 'nullable|string',
    ];

    // Tambah rules sesuai jenis
    if ($request->jenis_inventori === 'masuk') {
        $rules['sumber'] = 'required|string|in:Customer,Vendor';
        
        // PENTING: Jika tidak ada serial, stok HARUS ADA
        if ($request->has_serial == '0') {
            $rules['stok'] = 'required|integer|min:1';
            Log::info('Validation: Stok is REQUIRED (no serial)');
        }
    } else {
        $rules['perihal'] = 'required|string|in:Pemeliharaan,Penjualan,Instalasi';
        $rules['alamat'] = 'nullable|string';
        
        // PENTING: Jika tidak ada serial, stok HARUS ADA
        if ($request->has_serial == '0') {
            $rules['stok'] = 'required|integer|min:1';
            Log::info('Validation: Stok is REQUIRED (no serial)');
        }
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        Log::error('Validation Failed:', $validator->errors()->toArray());
        
        // Return JSON for AJAX
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
        
        // Determine success message based on type
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
                } else {
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

        // Return JSON for AJAX
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
        
        // Return JSON for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => '❌ Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
        
        return redirect()->back()
            ->with('error', '❌ Gagal menyimpan data: ' . $e->getMessage())
            ->withInput();
    }
}
    private function handleBarangMasuk($request)
    {
        Log::info('handleBarangMasuk - START');
        Log::info('Sumber: ' . $request->sumber);
        Log::info('Has Serial: ' . $request->has_serial);
        
        // Convert has_serial to boolean
        $hasSerial = $request->has_serial == '1';
        
        if ($request->sumber === 'Vendor') {
            if ($hasSerial) {
                // VENDOR dengan Serial Numbers
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
                // VENDOR tanpa Serial - PENTING: Cek stok
                Log::info('Vendor without Serial - Bulk quantity');
                Log::info('Stok value from request: ' . $request->stok);
                
                $stok = intval($request->stok);
                
                if (empty($stok) || $stok < 1) {
                    Log::error('Stok empty or invalid: ' . $stok);
                    throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
                }
                
                Log::info('Stok after intval: ' . $stok);
                
                // firstOrCreate untuk avoid duplikasi
                $detailBarang = DetailBarang::firstOrCreate([
                    'id_perangkat' => $request->id_perangkat,
                    'serial_number' => null,
                    'kategori' => $request->kategori,
                ]);

                Log::info('DetailBarang created/found, ID: ' . $detailBarang->id);

                $barangMasuk = BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => 'Vendor',
                ]);
                
                Log::info('BarangMasuk created successfully with ID: ' . $barangMasuk->id . ', jumlah: ' . $barangMasuk->jumlah);
            }
            
        } else {
            // CUSTOMER
            Log::info('Customer Source');
            
            if ($hasSerial) {
                $hasData = false;
                
                // Process RETURN serials
                $returnSerials = $request->return_serials ?? [];
                Log::info('Return Serials:', $returnSerials);
                
                if (!empty($returnSerials)) {
                    foreach ($returnSerials as $detailId) {
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
                $serialNumbers = array_filter($serialNumbers, function($serial) {
                    return !empty(trim($serial));
                });
                
                Log::info('New Serial Numbers from Customer:', $serialNumbers);
                
                if (!empty($serialNumbers)) {
                    foreach ($serialNumbers as $serial) {
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
                // CUSTOMER tanpa Serial - PENTING: Cek stok
                Log::info('Customer without Serial - Bulk quantity');
                Log::info('Stok value from request: ' . $request->stok);
                
                $stok = intval($request->stok);
                
                if (empty($stok) || $stok < 1) {
                    Log::error('Stok empty or invalid: ' . $stok);
                    throw new \Exception('Jumlah stok wajib diisi dan minimal 1');
                }
                
                Log::info('Stok after intval: ' . $stok);
                
                $detailBarang = DetailBarang::firstOrCreate([
                    'id_perangkat' => $request->id_perangkat,
                    'serial_number' => null,
                    'kategori' => $request->kategori,
                ]);

                Log::info('DetailBarang created/found, ID: ' . $detailBarang->id);

                $barangMasuk = BarangMasuk::create([
                    'detail_barang_id' => $detailBarang->id,
                    'tanggal' => $request->tanggal,
                    'jumlah' => $stok,
                    'catatan_barang_masuk' => $request->catatan,
                    'status' => 'Customer',
                ]);
                
                Log::info('BarangMasuk created successfully with ID: ' . $barangMasuk->id . ', jumlah: ' . $barangMasuk->jumlah);
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
            // Ada serial number - keluar per serial
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
            // Tidak ada serial number - keluar bulk
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

            // Check available stock
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
        Log::info('=== INVENTORY UPDATE START ===');
        Log::info('ID: ' . $id . ', Type: ' . $type);
        Log::info('Request Data:', $request->all());
        
        $rules = [
            'tanggal' => 'required|date',
            'stok' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'alamat' => 'nullable|string',
        ];
        
        // Tambahkan validasi serial number jika ada
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
                
                // Update BarangMasuk
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_masuk' => $request->catatan,
                ]);
                
                Log::info('BarangMasuk updated successfully');
                
            } else {
                $inventory = BarangKeluar::with('detailBarang')->findOrFail($id);
                
                // Update BarangKeluar
                $inventory->update([
                    'tanggal' => $request->tanggal,
                    'jumlah' => $request->stok,
                    'catatan_barang_keluar' => $request->catatan,
                    'alamat' => $request->alamat ?? '',
                ]);
                
                Log::info('BarangKeluar updated successfully');
            }
            
            // Update Serial Number jika ada perubahan
            if ($request->has('serial_number') && $inventory->detailBarang) {
                $oldSerial = $inventory->detailBarang->serial_number;
                $newSerial = $request->serial_number;
                
                if ($oldSerial !== $newSerial) {
                    // Cek apakah serial number baru sudah ada di database
                    $existingSerial = DetailBarang::where('serial_number', $newSerial)
                        ->where('id', '!=', $inventory->detailBarang->id)
                        ->first();
                    
                    if ($existingSerial) {
                        throw new \Exception('Serial number "' . $newSerial . '" sudah digunakan untuk barang lain!');
                    }
                    
                    // Update serial number
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