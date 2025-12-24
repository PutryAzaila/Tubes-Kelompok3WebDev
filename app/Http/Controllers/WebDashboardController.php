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
        
        $lowStockItems = $this->getLowStockItems();
        $lowStockCount = $lowStockItems->count();

        $pendingPOs = collect();
        
        if (Auth::check()) {
            $user = Auth::user();
            
            // Debug log
            Log::info('DASHBOARD DEBUG');
            Log::info('User ID: ' . $user->id);
            Log::info('User Email: ' . $user->email);
            Log::info('User Jabatan: ' . ($user->jabatan ?? 'NULL'));
            
            if (isset($user->jabatan) && strtolower(trim($user->jabatan)) === 'manajer') {
                Log::info('User IS manajer, querying pending POs...');
                
                $pendingPOs = PurchaseOrder::with(['vendor', 'detailPO.perangkat'])
                    ->where('status', 'Diajukan')
                    ->orderBy('tanggal_pemesanan', 'desc')
                    ->get();
                
                Log::info('Pending POs Count: ' . $pendingPOs->count());
                
                if ($pendingPOs->count() > 0) {
                    Log::info('PO IDs: ' . $pendingPOs->pluck('id')->implode(', '));
                } else {
                    Log::warning('No pending POs found!');
                    
                    $allPOs = PurchaseOrder::all();
                    Log::info('Total POs in DB: ' . $allPOs->count());
                    Log::info('All statuses: ' . $allPOs->pluck('status')->unique()->implode(', '));
                }
            } else {
                Log::info('User is NOT manajer (jabatan: ' . ($user->jabatan ?? 'NULL') . ')');
            }
        }

        $poChartData = $this->getPOChartData();
        $statusData = $this->getStatusChartData();
        
        $recentActivities = $this->getUserRecentActivities();

        return view('dashboard', [
            'totalPerangkat' => $totalPerangkat,
            'totalVendor' => $totalVendor,
            'poThisMonth' => $poThisMonth,
            'lowStockCount' => $lowStockCount,
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

    private function getLowStockItems()
    {
        $detailBarangs = DetailBarang::whereNull('serial_number')
            ->with('perangkat')
            ->get();

        $lowStock = collect();

        foreach ($detailBarangs as $detail) {
            $totalMasuk = BarangMasuk::where('detail_barang_id', $detail->id)->sum('jumlah');
            $totalKeluar = BarangKeluar::where('detail_barang_id', $detail->id)->sum('jumlah');
            $stok = $totalMasuk - $totalKeluar;

            if ($stok > 0) {
                $isLowStock = false;
                
                if ($stok < 10) {
                    $isLowStock = true;
                }
                elseif ($totalMasuk > 50 && $stok < ($totalMasuk * 0.2)) {
                    $isLowStock = true;
                }
                
                if ($isLowStock) {
                    $item = $detail->perangkat;
                    $item->stok = $stok;
                    $item->tipe = $detail->kategori;
                    $item->total_masuk = $totalMasuk; 
                    $lowStock->push($item);
                }
            }
        }

        return $lowStock->sortBy('stok')->take(5);
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
        if (!Auth::check()) {
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

        $barangMasukTable = (new BarangMasuk)->getTable();
        if (DB::getSchemaBuilder()->hasColumn($barangMasukTable, 'user_id')) {
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
        }

        $barangKeluarTable = (new BarangKeluar)->getTable();
        if (DB::getSchemaBuilder()->hasColumn($barangKeluarTable, 'user_id')) {
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
        }

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