<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailPurchaseOrder;
use App\Models\PurchaseOrder;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailPurchaseOrderController extends Controller
{
    /**
     * GET /api/detail-purchase-orders/by-po/{id_po}
     */
    public function getByPurchaseOrder($id_po)
    {
        try {
            $purchaseOrder = PurchaseOrder::with('vendor')->find($id_po);
            
            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            $details = DetailPurchaseOrder::with('perangkat')
                ->where('id_po', $id_po)
                ->orderBy('created_at', 'asc')
                ->get();

            $formattedDetails = $details->map(function ($detail, $index) {
                return [
                    'no' => $index + 1,
                    'nama_product' => $detail->perangkat->nama_perangkat ?? 'N/A',
                    'amount' => $detail->jumlah . ' Unit',
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Detail Purchase Order berhasil diambil',
                'data' => [
                    'po_info' => [
                        'id' => $purchaseOrder->id,
                        'code' => 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT),
                        'vendor' => $purchaseOrder->vendor->nama_vendor ?? 'N/A',
                        'tanggal_pemesanan' => date('d-m-Y', strtotime($purchaseOrder->tanggal_pemesanan)),
                        'status' => $purchaseOrder->status,
                        'created_at' => $purchaseOrder->created_at->format('d-m-Y H:i:s'),
                    ],
                    'table_data' => $formattedDetails,
                    'total_items' => $details->sum('jumlah') . ' Unit',
                    'item_count' => $details->count(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/detail-purchase-orders
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_po' => 'required|exists:purchase_orders,id',
            'id_perangkat' => 'required|exists:perangkat,id',
            'jumlah' => 'required|integer|min:1',
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
            
            $purchaseOrder = PurchaseOrder::find($request->id_po);
            
            if (!$purchaseOrder) {
                return response()->json([
                    'success' => false,
                    'message' => 'Purchase Order tidak ditemukan'
                ], 404);
            }

            if ($purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa menambah item pada PO dengan status Diajukan'
                ], 400);
            }

            $existingDetail = DetailPurchaseOrder::where('id_po', $request->id_po)
                ->where('id_perangkat', $request->id_perangkat)
                ->first();

            if ($existingDetail) {
                $existingDetail->increment('jumlah', $request->jumlah);
                $detail = $existingDetail;
            } else {
                $detail = DetailPurchaseOrder::create($request->all());
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke Purchase Order',
                'data' => $detail->load('perangkat')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/detail-purchase-orders/{id}
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_perangkat' => 'required|exists:perangkat,id',
            'jumlah' => 'required|integer|min:1',
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
            
            $detail = DetailPurchaseOrder::with('purchaseOrder')->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail Purchase Order tidak ditemukan'
                ], 404);
            }

            if ($detail->purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa mengubah item pada PO dengan status Diajukan'
                ], 400);
            }

            $detail->update($request->only(['id_perangkat', 'jumlah']));
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil diupdate',
                'data' => $detail->load('perangkat')
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/detail-purchase-orders/{id}
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $detail = DetailPurchaseOrder::with('purchaseOrder')->find($id);

            if (!$detail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Detail Purchase Order tidak ditemukan'
                ], 404);
            }

            if ($detail->purchaseOrder->status !== 'Diajukan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya bisa menghapus item pada PO dengan status Diajukan'
                ], 400);
            }

            $detail->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/detail-purchase-orders/check-stock/{id_perangkat}
     */
    public function checkStock($id_perangkat)
    {
        try {
            $perangkat = Perangkat::find($id_perangkat);

            if (!$perangkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perangkat tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stok perangkat berhasil diambil',
                'data' => [
                    'id_perangkat' => $perangkat->id,
                    'nama_perangkat' => $perangkat->nama_perangkat,
                    'stok_tersedia' => $perangkat->stok ?? 0,
                    'tipe' => $perangkat->tipe,
                    'merk' => $perangkat->merk,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil stok perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}