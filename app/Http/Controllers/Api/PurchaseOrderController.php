<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\DetailPurchaseOrder;
use App\Models\DataVendor;
use App\Models\Perangkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    // GET /api/purchase-orders
    public function index(Request $request)
    {
        try {
            $query = PurchaseOrder::with(['vendor', 'karyawan', 'detailPO.perangkat'])
                ->orderBy('tanggal_pemesanan', 'desc');

            // Filter status
            if ($request->has('status') && $request->status != 'all') {
                $query->where('status', $request->status);
            }

            // Filter vendor
            if ($request->has('vendor_id')) {
                $query->where('id_vendor', $request->vendor_id);
            }

            // Filter tanggal
            if ($request->has('start_date') && $request->has('end_date')) {
                $query->whereBetween('tanggal_pemesanan', [
                    $request->start_date,
                    $request->end_date
                ]);
            }

            $purchaseOrders = $query->get();

            // Format response
            $formattedData = $purchaseOrders->map(function ($po) {
                $totalItems = $po->detailPO->sum('jumlah');
                
                return [
                    'id' => $po->id,
                    'code' => 'PO-' . str_pad($po->id, 3, '0', STR_PAD_LEFT),
                    'vendor' => $po->vendor->nama_vendor ?? 'N/A',
                    'staff' => $po->karyawan->nama_lengkap ?? 'N/A',
                    'tanggal_pemesanan' => $po->tanggal_pemesanan,
                    'date_formatted' => date('d-m-Y', strtotime($po->tanggal_pemesanan)),
                    'status' => $po->status,
                    'status_label' => $this->getStatusLabel($po->status),
                    // Sesuai enum di migrasi: 'Diajukan', 'Disetujui','Ditolak'
                    'can_edit' => $po->status === 'Diajukan', // Bisa edit hanya di Diajukan
                    'can_delete' => $po->status === 'Diajukan', // Bisa hapus hanya di Diajukan
                    'can_apply' => false, // Tidak ada status Draft di migrasi
                    'can_approve' => $po->status === 'Diajukan', // Bisa approve dari Diajukan
                    'can_reject' => $po->status === 'Diajukan', // Bisa reject dari Diajukan
                    'can_revert' => false, // Tidak ada revert ke Draft
                    'total_items' => $totalItems,
                    'items_count' => $po->detailPO->count(),
                ];
            });

            // Hitung statistik
            $stats = [
                'total' => PurchaseOrder::count(),
                'diajukan' => PurchaseOrder::where('status', 'Diajukan')->count(),
                'disetujui' => PurchaseOrder::where('status', 'Disetujui')->count(),
                'ditolak' => PurchaseOrder::where('status', 'Ditolak')->count(),
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data Purchase Order berhasil diambil',
                'data' => $formattedData,
                'stats' => $stats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Purchase Order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/purchase-orders
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_vendor' => 'required|exists:data_vendor,id',
            'tanggal_pemesanan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_perangkat' => 'required|exists:perangkat,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Create Purchase Order
            $purchaseOrder = PurchaseOrder::create([
                'id_vendor' => $request->id_vendor,
                'id_karyawan' => Auth::id(),
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                // Langsung status Diajukan karena tidak ada Draft di migrasi
                'status' => 'Diajukan',
            ]);

            // Create Detail Purchase Order
            foreach ($request->items as $item) {
                DetailPurchaseOrder::create([
                    'id_po' => $purchaseOrder->id,
                    'id_perangkat' => $item['id_perangkat'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dibuat',
                'data' => $purchaseOrder->load(['vendor', 'karyawan', 'detailPO.perangkat'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Purchase Order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/purchase-orders/{id}
    public function show($id)
    {
        try {
            $purchaseOrder = PurchaseOrder::with([
                'vendor', 
                'karyawan', 
                'detailPO.perangkat'
            ])->find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Format detail items untuk tabel
            $formattedDetails = $purchaseOrder->detailPO->map(function ($detail, $index) {
                return [
                    'no' => $index + 1,
                    'nama_product' => $detail->perangkat->nama_perangkat ?? 'N/A',
                    'amount' => $detail->jumlah . ' Unit',
                ];
            });

            // Total items
            $totalItems = $purchaseOrder->detailPO->sum('jumlah');

            return response()->json([
                'success' => true,
                'message' => 'Detail Purchase Order berhasil diambil',
                'data' => [
                    'po_info' => [
                        'id' => $purchaseOrder->id,
                        'code' => 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT),
                        'date_of_apply' => date('d-m-Y', strtotime($purchaseOrder->tanggal_pemesanan)),
                        'status' => strtolower($purchaseOrder->status),
                        'status_label' => $this->getStatusLabel($purchaseOrder->status),
                        'vendor' => $purchaseOrder->vendor->nama_vendor ?? 'N/A',
                        'staff' => $purchaseOrder->karyawan->nama_lengkap ?? 'N/A',
                        // Sesuai enum di migrasi
                        'can_edit' => $purchaseOrder->status === 'Diajukan',
                        'can_delete' => $purchaseOrder->status === 'Diajukan',
                        'can_apply' => false,
                        'can_approve' => $purchaseOrder->status === 'Diajukan',
                        'can_reject' => $purchaseOrder->status === 'Diajukan',
                        'can_revert' => false,
                    ],
                    'table_data' => $formattedDetails,
                    'total_items' => $totalItems . ' Unit',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail Purchase Order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/purchase-orders/{id}/edit (untuk mengambil data edit)
    public function edit($id)
    {
        try {
            $purchaseOrder = PurchaseOrder::with(['vendor', 'detailPO.perangkat'])->find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Cek apakah PO bisa diedit (hanya Diajukan)
            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak dapat diedit karena status ' . $purchaseOrder->status
                ], 400);
            }

            // Format data untuk form edit
            $formattedDetails = $purchaseOrder->detailPO->map(function ($detail) {
                return [
                    'id_detail' => $detail->id,
                    'id_perangkat' => $detail->id_perangkat,
                    'nama_perangkat' => $detail->perangkat->nama_perangkat ?? 'N/A',
                    'tipe' => $detail->perangkat->tipe ?? 'N/A',
                    'merk' => $detail->perangkat->merk ?? 'N/A',
                    'stok' => $detail->perangkat->stok ?? 0,
                    'jumlah' => $detail->jumlah,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data edit Purchase Order berhasil diambil',
                'data' => [
                    'po_info' => [
                        'id' => $purchaseOrder->id,
                        'id_vendor' => $purchaseOrder->id_vendor,
                        'tanggal_pemesanan' => $purchaseOrder->tanggal_pemesanan,
                        'vendor' => $purchaseOrder->vendor->nama_vendor ?? 'N/A',
                        'status' => $purchaseOrder->status,
                        'status_label' => $this->getStatusLabel($purchaseOrder->status),
                    ],
                    'items' => $formattedDetails,
                    'total_items' => $purchaseOrder->detailPO->sum('jumlah'),
                    'total_products' => $purchaseOrder->detailPO->count(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data edit',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT /api/purchase-orders/{id}
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_vendor' => 'required|exists:data_vendor,id',
            'tanggal_pemesanan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_perangkat' => 'required|exists:perangkat,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Hanya bisa update jika status Diajukan
            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order hanya bisa diubah saat status Diajukan'
                ], 400);
            }

            // Update PO
            $purchaseOrder->update([
                'id_vendor' => $request->id_vendor,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
            ]);

            // Hapus detail lama
            $purchaseOrder->detailPO()->delete();

            // Buat detail baru
            foreach ($request->items as $item) {
                DetailPurchaseOrder::create([
                    'id_po' => $purchaseOrder->id,
                    'id_perangkat' => $item['id_perangkat'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil diupdate',
                'data' => $purchaseOrder->load(['vendor', 'karyawan', 'detailPO.perangkat'])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate Purchase Order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/purchase-orders/{id}
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Hanya bisa hapus jika status Diajukan
            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order hanya bisa dihapus saat status Diajukan'
                ], 400);
            }

            // Hapus detail terlebih dahulu
            $purchaseOrder->detailPO()->delete();
            
            // Hapus PO
            $purchaseOrder->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Purchase Order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PATCH /api/purchase-orders/{id}/approve (Approve PO)
    public function approveStatus($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::with('detailPO.perangkat')->find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Validasi: hanya bisa approve dari Diajukan
            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya PO dengan status Diajukan yang bisa disetujui'
                ], 400);
            }

            // Update status menjadi Disetujui
            $purchaseOrder->update(['status' => 'Disetujui']);

            DB::commit();

            // Format response untuk halaman detail
            $formattedDetails = $purchaseOrder->detailPO->map(function ($detail, $index) {
                return [
                    'no' => $index + 1,
                    'nama_product' => $detail->perangkat->nama_perangkat ?? 'N/A',
                    'amount' => $detail->jumlah . ' Unit',
                ];
            });

            $totalItems = $purchaseOrder->detailPO->sum('jumlah');

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil disetujui',
                'data' => [
                    'po_info' => [
                        'code' => 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT),
                        'date_of_apply' => date('d-m-Y', strtotime($purchaseOrder->tanggal_pemesanan)),
                        'status' => 'disetujui',
                        'vendor' => $purchaseOrder->vendor->nama_vendor ?? 'N/A',
                        'staff' => $purchaseOrder->karyawan->nama_lengkap ?? 'N/A',
                    ],
                    'table_data' => $formattedDetails,
                    'total_items' => $totalItems . ' Unit',
                    'status_update' => [
                        'old_status' => 'Diajukan',
                        'new_status' => 'Disetujui',
                        'updated_at' => now()->format('d-m-Y H:i:s'),
                        'updated_by' => Auth::check() ? Auth::user()->nama_lengkap : 'System',
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PATCH /api/purchase-orders/{id}/reject (Reject PO)
    public function rejectStatus($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::with('detailPO.perangkat')->find($id);

            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            // Validasi: hanya bisa reject dari Diajukan
            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya PO dengan status Diajukan yang bisa ditolak'
                ], 400);
            }

            // Update status menjadi Ditolak
            $purchaseOrder->update(['status' => 'Ditolak']);

            DB::commit();

            // Format response untuk halaman detail
            $formattedDetails = $purchaseOrder->detailPO->map(function ($detail, $index) {
                return [
                    'no' => $index + 1,
                    'nama_product' => $detail->perangkat->nama_perangkat ?? 'N/A',
                    'amount' => $detail->jumlah . ' Unit',
                ];
            });

            $totalItems = $purchaseOrder->detailPO->sum('jumlah');

            return response()->json([
                'success' => true,
                'message' => 'Purchase Order berhasil ditolak',
                'data' => [
                    'po_info' => [
                        'code' => 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT),
                        'date_of_apply' => date('d-m-Y', strtotime($purchaseOrder->tanggal_pemesanan)),
                        'status' => 'ditolak',
                        'vendor' => $purchaseOrder->vendor->nama_vendor ?? 'N/A',
                        'staff' => $purchaseOrder->karyawan->nama_lengkap ?? 'N/A',
                    ],
                    'table_data' => $formattedDetails,
                    'total_items' => $totalItems . ' Unit',
                    'status_update' => [
                        'old_status' => 'Diajukan',
                        'new_status' => 'Ditolak',
                        'reason' => $request->reason,
                        'updated_at' => now()->format('d-m-Y H:i:s'),
                        'updated_by' => Auth::check() ? Auth::user()->nama_lengkap : 'System',
                    ]
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/purchase-orders/stats/dashboard (Untuk Dashboard)
    public function getDashboardStats()
    {
        try {
            $stats = [
                'total_diajukan' => PurchaseOrder::where('status', 'Diajukan')->count(),
                'total_disetujui' => PurchaseOrder::where('status', 'Disetujui')->count(),
                'total_ditolak' => PurchaseOrder::where('status', 'Ditolak')->count(),
                'total_all' => PurchaseOrder::count(),
                'recent_orders' => PurchaseOrder::with('vendor')
                    ->orderBy('tanggal_pemesanan', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($po) {
                        return [
                            'id' => $po->id,
                            'code' => 'PO-' . str_pad($po->id, 3, '0', STR_PAD_LEFT),
                            'vendor' => $po->vendor->nama_vendor ?? 'N/A',
                            'tanggal' => date('d-m-Y', strtotime($po->tanggal_pemesanan)),
                            'status' => $po->status,
                            'status_label' => $this->getStatusLabel($po->status),
                        ];
                    })
            ];

            return response()->json([
                'success' => true,
                'message' => 'Statistik dashboard berhasil diambil',
                'data' => $stats
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil statistik dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ==================== HELPER METHODS ====================

    /**
     * Get label untuk status
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'Diajukan' => 'Diajukan',
            'Disetujui' => 'Disetujui',
            'Ditolak' => 'Ditolak',
        ];

        return $labels[$status] ?? $status;
    }
}