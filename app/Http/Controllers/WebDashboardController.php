<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use App\Models\DataVendor;
use App\Models\PurchaseOrder;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\DetailBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WebDashboardController extends Controller
{
    public function index()
    {
        $totalPerangkat = Perangkat::count();
        $totalVendor = DataVendor::count();
        $poThisMonth = PurchaseOrder::whereMonth('tanggal_pemesanan', Carbon::now()->month)
            ->whereYear('tanggal_pemesanan', Carbon::now()->year)
            ->count();
        
        // ========================================
        // HITUNG TOTAL STOK TERSEDIA (SAMA DENGAN INVENTORY)
        // ========================================
        $stockData = $this->calculateTotalStock();
        
        // Low stock items untuk informasi
        $lowStockItems = $this->getLowStockItems();

        Log::info('=== DEBUG DASHBOARD STOCK ===');
        Log::info('Total Stock Available: ' . $stockData['total_available']);
        Log::info('Low Stock Items Count: ' . $lowStockItems->count());

        $pendingPOs = collect();
        
        if (Auth::check()) {
            $user = Auth::user();
            
            if (isset($user->jabatan) && strtolower(trim($user->jabatan)) === 'manajer') {
                $pendingPOs = PurchaseOrder::with(['vendor', 'detailPO.perangkat'])
                    ->where('status', 'Diajukan')
                    ->orderBy('tanggal_pemesanan', 'desc')
                    ->get();
            }
        }

        $poChartData = $this->getPOChartData();
        $statusData = $this->getStatusChartData();
        $recentActivities = $this->getUserRecentActivities();

        return view('dashboard', [
            'totalPerangkat' => $totalPerangkat,
            'totalVendor' => $totalVendor,
            'poThisMonth' => $poThisMonth,
            
            // Data stok baru (sama dengan inventory)
            'totalStockAvailable' => $stockData['total_available'],
            'totalStockIn' => $stockData['total_in'],
            'totalStockOut' => $stockData['total_out'],
            'stockPercentage' => $stockData['percentage'],
            
            // Low stock items (untuk informasi)
            'lowStockCount' => $lowStockItems->count(),
            'lowStockItems' => $lowStockItems,
            
            'pendingPOs' => $pendingPOs,
            'poChartLabels' => $poChartData['labels'],
            'poDiajukan' => $poChartData['diajukan'],
            'poDisetujui' => $poChartData['disetujui'],
            'poDitolak' => $poChartData['ditolak'],
            'statusDiajukan' => $statusData['diajukan'],
            'statusDisetujui' => $statusData['disetujui'],
            'statusDitolak' => $statusData['ditolak'],
            'recentActivities' => $recentActivities,
        ]);
    }

    /**
     * HITUNG TOTAL STOK TERSEDIA - SAMA DENGAN INVENTORY
     */
    private function calculateTotalStock()
    {
        Log::info('=== DASHBOARD: calculateTotalStock (MATCH INVENTORY) ===');
        
        $detailBarangs = DetailBarang::all();
        
        $totalIn = 0;
        $totalOut = 0;
        
        foreach ($detailBarangs as $detail) {
            $masuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $keluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            
            $totalIn += $masuk;
            $totalOut += $keluar;
        }
        
        $available = max(0, $totalIn - $totalOut);
        
        $percentage = 0;
        if ($totalIn > 0) {
            $percentage = round(($available / $totalIn) * 100, 1);
        }
        
        Log::info("Stock Data => In: {$totalIn}, Out: {$totalOut}, Available: {$available}, Percentage: {$percentage}%");
        
        return [
            'total_in' => $totalIn,
            'total_out' => $totalOut,
            'total_available' => $available,
            'percentage' => $percentage,
        ];
    }

    /**
     * Low Stock Items - SAMA DENGAN INVENTORY
     */
    private function getLowStockItems()
    {
        Log::info('=== DASHBOARD: getLowStockItems (MATCH INVENTORY) ===');
        
        $detailBarangs = DetailBarang::with('perangkat')->get();
        Log::info('Total DetailBarang: ' . $detailBarangs->count());

        $lowStock = collect();

        foreach ($detailBarangs as $detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            $stok = $totalMasuk - $totalKeluar;

            $isLowStock = false;
            
            if ($detail->serial_number !== null) {
                // SERIAL: Tampilkan jika sudah keluar (out of stock)
                if ($stok <= 0 && $totalMasuk > 0) {
                    $isLowStock = true;
                    Log::info("✅ Serial Out: {$detail->perangkat->nama_perangkat} - {$detail->serial_number}");
                }
            } else {
                // NON-SERIAL: Tampilkan jika stok 1-5 saja (sangat rendah)
                if ($stok > 0 && $stok <= 5) {
                    $isLowStock = true;
                    Log::info("✅ Low Stock: {$detail->perangkat->nama_perangkat} (stok: {$stok})");
                }
                // Atau stok habis tapi pernah ada
                elseif ($stok == 0 && $totalMasuk > 0) {
                    $isLowStock = true;
                    Log::info("✅ Empty Stock: {$detail->perangkat->nama_perangkat}");
                }
            }

            if ($isLowStock) {
                $item = clone $detail->perangkat;
                $item->stok = $stok;
                $item->serial_number = $detail->serial_number;
                $item->detail_id = $detail->id;
                
                if ($detail->serial_number !== null) {
                    $item->display_name = $detail->perangkat->nama_perangkat . " (SN: {$detail->serial_number})";
                    $item->stock_type = 'serial';
                    $item->status_badge = 'Habis';
                    $item->badge_color = 'danger';
                    $item->icon = 'barcode';
                } else {
                    $item->display_name = $detail->perangkat->nama_perangkat;
                    $item->stock_type = 'bulk';
                    $item->icon = 'box';
                    
                    if ($stok == 0) {
                        $item->status_badge = 'Habis';
                        $item->badge_color = 'danger';
                    } else {
                        $item->status_badge = 'Menipis';
                        $item->badge_color = 'warning';
                    }
                }
                
                $lowStock->push($item);
            }
        }

        Log::info('Total Low Stock Items: ' . $lowStock->count());

        return $lowStock->sortBy('stok')->take(10)->values();
    }

    private function getPOChartData()
    {
        $labels = [];
        $diajukan = [];
        $disetujui = [];
        $ditolak = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M');

            $diajukan[] = PurchaseOrder::where('status', 'Diajukan')
                ->whereMonth('tanggal_pemesanan', $date->month)
                ->whereYear('tanggal_pemesanan', $date->year)
                ->count();

            $disetujui[] = PurchaseOrder::where('status', 'Disetujui')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->count();

            $ditolak[] = PurchaseOrder::where('status', 'Ditolak')
                ->whereMonth('updated_at', $date->month)
                ->whereYear('updated_at', $date->year)
                ->count();
        }

        return [
            'labels' => $labels,
            'diajukan' => $diajukan,
            'disetujui' => $disetujui,
            'ditolak' => $ditolak,
        ];
    }

    private function getStatusChartData()
    {
        return [
            'diajukan' => PurchaseOrder::where('status', 'Diajukan')->count(),
            'disetujui' => PurchaseOrder::where('status', 'Disetujui')->count(),
            'ditolak' => PurchaseOrder::where('status', 'Ditolak')->count(),
        ];
    }

    private function getUserRecentActivities()
    {
        Log::info('=== STARTING getUserRecentActivities ===');
        
        if (!Auth::check()) {
            Log::warning('User not authenticated');
            return collect();
        }

        $userId = Auth::id();
        $activities = collect();

        // 1. Purchase Order yang dibuat user ini
        $userPOs = PurchaseOrder::with(['vendor', 'karyawan'])
            ->where('id_karyawan', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        foreach ($userPOs as $po) {
            $statusType = match($po->status) {
                'Disetujui' => 'success',
                'Ditolak' => 'danger',
                default => 'warning'
            };

            $statusIcon = match($po->status) {
                'Disetujui' => 'check-circle',
                'Ditolak' => 'times-circle',
                default => 'clock'
            };

            $activities->push([
                'type' => $statusType,
                'icon' => $statusIcon,
                'title' => 'Purchase Order ' . $po->status,
                'description' => 'PO-' . str_pad($po->id, 3, '0', STR_PAD_LEFT) . ' untuk vendor ' . ($po->vendor->nama_vendor ?? 'N/A'),
                'time' => $po->created_at->diffForHumans(),
                'timestamp' => $po->created_at,
            ]);
        }

        // 2. Barang Masuk
        $barangMasukTable = (new BarangMasuk)->getTable();
        $hasMasukUserId = DB::getSchemaBuilder()->hasColumn($barangMasukTable, 'user_id');

        if ($hasMasukUserId) {
            $userMasuk = BarangMasuk::with(['detailBarang.perangkat'])
                ->where('user_id', $userId)
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            foreach ($userMasuk as $masuk) {
                $activities->push([
                    'type' => 'primary',
                    'icon' => 'arrow-down',
                    'title' => 'Barang Masuk',
                    'description' => $masuk->jumlah . ' unit ' . ($masuk->detailBarang->perangkat->nama_perangkat ?? 'N/A'),
                    'time' => Carbon::parse($masuk->tanggal)->diffForHumans(),
                    'timestamp' => Carbon::parse($masuk->tanggal),
                ]);
            }
        } else {
            $recentMasuk = BarangMasuk::with(['detailBarang.perangkat'])
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            foreach ($recentMasuk as $masuk) {
                $activities->push([
                    'type' => 'primary',
                    'icon' => 'arrow-down',
                    'title' => 'Barang Masuk',
                    'description' => $masuk->jumlah . ' unit ' . ($masuk->detailBarang->perangkat->nama_perangkat ?? 'N/A'),
                    'time' => Carbon::parse($masuk->tanggal)->diffForHumans(),
                    'timestamp' => Carbon::parse($masuk->tanggal),
                ]);
            }
        }

        // 3. Barang Keluar
        $barangKeluarTable = (new BarangKeluar)->getTable();
        $hasKeluarUserId = DB::getSchemaBuilder()->hasColumn($barangKeluarTable, 'user_id');

        if ($hasKeluarUserId) {
            $userKeluar = BarangKeluar::with(['detailBarang.perangkat'])
                ->where('user_id', $userId)
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            foreach ($userKeluar as $keluar) {
                $activities->push([
                    'type' => 'warning',
                    'icon' => 'arrow-up',
                    'title' => 'Barang Keluar',
                    'description' => $keluar->jumlah . ' unit ' . ($keluar->detailBarang->perangkat->nama_perangkat ?? 'N/A'),
                    'time' => Carbon::parse($keluar->tanggal)->diffForHumans(),
                    'timestamp' => Carbon::parse($keluar->tanggal),
                ]);
            }
        } else {
            $recentKeluar = BarangKeluar::with(['detailBarang.perangkat'])
                ->orderBy('tanggal', 'desc')
                ->take(3)
                ->get();

            foreach ($recentKeluar as $keluar) {
                $activities->push([
                    'type' => 'warning',
                    'icon' => 'arrow-up',
                    'title' => 'Barang Keluar',
                    'description' => $keluar->jumlah . ' unit ' . ($keluar->detailBarang->perangkat->nama_perangkat ?? 'N/A'),
                    'time' => Carbon::parse($keluar->tanggal)->diffForHumans(),
                    'timestamp' => Carbon::parse($keluar->tanggal),
                ]);
            }
        }

        // 4. Aktivitas Manajer
        $user = Auth::user();
        if (isset($user->jabatan) && strtolower(trim($user->jabatan)) === 'manajer') {
            $approvedPOs = PurchaseOrder::with(['vendor'])
                ->whereIn('status', ['Disetujui', 'Ditolak'])
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get();

            foreach ($approvedPOs as $po) {
                $statusType = $po->status === 'Disetujui' ? 'success' : 'danger';
                $statusIcon = $po->status === 'Disetujui' ? 'check-circle' : 'times-circle';

                $activities->push([
                    'type' => $statusType,
                    'icon' => $statusIcon,
                    'title' => 'PO ' . $po->status,
                    'description' => 'Anda ' . strtolower($po->status) . ' PO-' . str_pad($po->id, 3, '0', STR_PAD_LEFT),
                    'time' => $po->updated_at->diffForHumans(),
                    'timestamp' => $po->updated_at,
                ]);
            }
        }

        return $activities->sortByDesc('timestamp')->take(10)->values();
    }
}