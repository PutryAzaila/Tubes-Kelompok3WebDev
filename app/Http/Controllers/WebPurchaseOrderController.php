<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\DetailPurchaseOrder;
use App\Models\DataVendor;
use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WebPurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['vendor', 'karyawan', 'detailPO'])
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        return view('purchase-order.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $vendors = DataVendor::orderBy('nama_vendor')->get();
        $perangkats = Perangkat::orderBy('nama_perangkat')->get();

        return view('purchase-order.create', compact('vendors', 'perangkats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_vendor' => 'required|exists:data_vendors,id',
            'tanggal_pemesanan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_perangkat' => 'required|exists:perangkats,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::create([
                'id_vendor' => $request->id_vendor,
                'id_karyawan' => Auth::id(),
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                'status' => 'Diajukan',
            ]);

            foreach ($request->items as $item) {
                DetailPurchaseOrder::create([
                    'id_po' => $purchaseOrder->id,
                    'id_perangkat' => $item['id_perangkat'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('purchase-order.index')
                ->with('success', 'Purchase Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['vendor', 'karyawan', 'detailPO.perangkat'])
            ->findOrFail($id);

        // Tentukan label dan value tanggal berdasarkan status
        $dateInfo = $this->getDateInfo($purchaseOrder);

        return view('purchase-order.show', compact('purchaseOrder', 'dateInfo'));
    }

    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::with(['vendor', 'detailPO.perangkat'])
            ->findOrFail($id);

        if ($purchaseOrder->status !== 'Diajukan') {
            return redirect()->route('purchase-order.show', $id)
                ->with('error', 'Purchase Order tidak dapat diedit karena status ' . $purchaseOrder->status);
        }

        $vendors = DataVendor::orderBy('nama_vendor')->get();
        $perangkats = Perangkat::orderBy('nama_perangkat')->get();

        return view('purchase-order.edit', compact('purchaseOrder', 'vendors', 'perangkats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_vendor' => 'required|exists:data_vendors,id',
            'tanggal_pemesanan' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.id_perangkat' => 'required|exists:perangkats,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'Diajukan') {
                return redirect()->route('purchase-order.show', $id)
                    ->with('error', 'Purchase Order hanya bisa diubah saat status Diajukan');
            }

            $purchaseOrder->update([
                'id_vendor' => $request->id_vendor,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
            ]);

            $purchaseOrder->detailPO()->delete();

            foreach ($request->items as $item) {
                DetailPurchaseOrder::create([
                    'id_po' => $purchaseOrder->id,
                    'id_perangkat' => $item['id_perangkat'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('purchase-order.show', $id)
                ->with('success', 'Purchase Order berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengupdate Purchase Order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'Diajukan') {
                return redirect()->back()
                    ->with('error', 'Purchase Order hanya bisa dihapus saat status Diajukan');
            }

            $purchaseOrder->detailPO()->delete();
            $purchaseOrder->delete();

            DB::commit();

            return redirect()->route('purchase-order.index')
                ->with('success', 'Purchase Order berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus Purchase Order: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'Diajukan') {
                return redirect()->back()
                    ->with('error', 'Hanya PO dengan status Diajukan yang bisa disetujui');
            }

            $purchaseOrder->update(['status' => 'Disetujui']);

            DB::commit();

            return redirect()->route('purchase-order.show', $id)
                ->with('success', 'Purchase Order berhasil disetujui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyetujui Purchase Order: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'Diajukan') {
                return redirect()->back()
                    ->with('error', 'Hanya PO dengan status Diajukan yang bisa ditolak');
            }

            $purchaseOrder->update(['status' => 'Ditolak']);

            DB::commit();

            return redirect()->route('purchase-order.show', $id)
                ->with('success', 'Purchase Order berhasil ditolak!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menolak Purchase Order: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Get date info berdasarkan status
     */
    private function getDateInfo($purchaseOrder)
    {
        $dateInfo = [
            'label' => '',
            'value' => '',
            'icon' => '',
        ];

        if ($purchaseOrder->status === 'Diajukan') {
            $dateInfo['label'] = 'Tanggal Pengajuan';
            $dateInfo['value'] = date('d F Y', strtotime($purchaseOrder->tanggal_pemesanan));
            $dateInfo['icon'] = 'fa-calendar-plus';
        } elseif ($purchaseOrder->status === 'Disetujui') {
            $dateInfo['label'] = 'Tanggal Disetujui';
            $dateInfo['value'] = date('d F Y, H:i', strtotime($purchaseOrder->updated_at));
            $dateInfo['icon'] = 'fa-calendar-check';
        } elseif ($purchaseOrder->status === 'Ditolak') {
            $dateInfo['label'] = 'Tanggal Ditolak';
            $dateInfo['value'] = date('d F Y, H:i', strtotime($purchaseOrder->updated_at));
            $dateInfo['icon'] = 'fa-calendar-times';
        }

        return $dateInfo;
    }
}