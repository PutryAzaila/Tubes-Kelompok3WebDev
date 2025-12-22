<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use App\Models\KategoriPerangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebPerangkatController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /perangkat
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search', '');
            $kategori = $request->input('kategori', '');
            $status = $request->input('status', '');
            
            $query = Perangkat::with('kategoriPerangkat');
            
            // Search filter
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_perangkat', 'like', "%{$search}%")
                      ->orWhere('catatan_perangkat', 'like', "%{$search}%");
                });
            }
            
            // Category filter
            if ($kategori) {
                $query->where('id_kategori_perangkat', $kategori);
            }
            
            // Status filter
            if ($status) {
                $query->where('status', $status);
            }
            
            $perangkat = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            // Get statistics
            $totalDevices = Perangkat::count();
            $availableDevices = Perangkat::where('status', 'Berfungsi')->count();
            $damagedDevices = Perangkat::where('status', 'Rusak')->count();
            $missingDevices = Perangkat::where('status', 'Hilang')->count();
            $returnDevices = Perangkat::where('status', 'Return')->count();
            
            // Get all categories for filter
            $categories = KategoriPerangkat::orderBy('nama_kategori')->get();
            
            $statistics = [
                'total' => $totalDevices,
                'available' => $availableDevices,
                'damaged' => $damagedDevices,
                'missing' => $missingDevices,
                'return' => $returnDevices
            ];
            
            return view('perangkat.index', compact('perangkat', 'statistics', 'categories'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data perangkat: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     * GET /perangkat/create
     */
    public function create()
    {
        try {
            $categories = KategoriPerangkat::orderBy('nama_kategori')->get();
            return view('perangkat.create', compact('categories'));
        } catch (\Exception $e) {
            return redirect()->route('perangkat.index')->with('error', 'Gagal memuat form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     * POST /perangkat
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_kategori_perangkat' => 'required|exists:kategori_perangkats,id',
                'nama_perangkat' => 'required|string|max:255',
                'status' => 'required|in:Rusak,Hilang,Return,Berfungsi',
                'catatan_perangkat' => 'nullable|string'
            ], [
                'id_kategori_perangkat.required' => 'Kategori perangkat harus dipilih',
                'id_kategori_perangkat.exists' => 'Kategori perangkat tidak valid',
                'nama_perangkat.required' => 'Nama perangkat harus diisi',
                'nama_perangkat.max' => 'Nama perangkat maksimal 255 karakter',
                'status.required' => 'Status perangkat harus dipilih',
                'status.in' => 'Status perangkat tidak valid'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $perangkat = Perangkat::create([
                'id_kategori_perangkat' => $request->id_kategori_perangkat,
                'nama_perangkat' => $request->nama_perangkat,
                'status' => $request->status,
                'catatan_perangkat' => $request->catatan_perangkat
            ]);

            return redirect()->route('perangkat.index')
                ->with('success', 'Perangkat berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan perangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     * GET /perangkat/{id}/edit
     */
    public function edit($id)
    {
        try {
            $perangkat = Perangkat::with('kategoriPerangkat')->findOrFail($id);
            $categories = KategoriPerangkat::orderBy('nama_kategori')->get();
            return view('perangkat.edit', compact('perangkat', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('perangkat.index')
                ->with('error', 'Perangkat tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /perangkat/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $perangkat = Perangkat::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'id_kategori_perangkat' => 'required|exists:kategori_perangkats,id',
                'nama_perangkat' => 'required|string|max:255',
                'status' => 'required|in:Rusak,Hilang,Return,Berfungsi',
                'catatan_perangkat' => 'nullable|string'
            ], [
                'id_kategori_perangkat.required' => 'Kategori perangkat harus dipilih',
                'id_kategori_perangkat.exists' => 'Kategori perangkat tidak valid',
                'nama_perangkat.required' => 'Nama perangkat harus diisi',
                'nama_perangkat.max' => 'Nama perangkat maksimal 255 karakter',
                'status.required' => 'Status perangkat harus dipilih',
                'status.in' => 'Status perangkat tidak valid'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $perangkat->update([
                'id_kategori_perangkat' => $request->id_kategori_perangkat,
                'nama_perangkat' => $request->nama_perangkat,
                'status' => $request->status,
                'catatan_perangkat' => $request->catatan_perangkat
            ]);

            return redirect()->route('perangkat.index')
                ->with('success', 'Perangkat berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui perangkat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /perangkat/{id}
     */
    public function destroy($id)
    {
        try {
            $perangkat = Perangkat::findOrFail($id);
            $nama = $perangkat->nama_perangkat;
            
            $perangkat->delete();

            return redirect()->route('perangkat.index')
                ->with('success', "Perangkat '{$nama}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->route('perangkat.index')
                ->with('error', 'Gagal menghapus perangkat: ' . $e->getMessage());
        }
    }

    /**
     * Export data perangkat
     * GET /perangkat-export
     */
    public function export()
    {
        try {
            $perangkat = Perangkat::with('kategoriPerangkat')->get();

            $exportData = $perangkat->map(function($item) {
                return [
                    'Nama Perangkat' => $item->nama_perangkat,
                    'Kategori' => $item->kategoriPerangkat->nama_kategori ?? '-',
                    'Status' => $item->status,
                    'Catatan' => $item->catatan_perangkat ?? '-',
                    'Dibuat' => $item->created_at->format('d-m-Y H:i:s')
                ];
            });

            // For now, just return JSON. You can implement CSV/Excel export later
            return response()->json([
                'success' => true,
                'data' => $exportData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal export data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get statistics
     * GET /perangkat-statistics
     */
    public function statistics()
    {
        try {
            $totalDevices = Perangkat::count();
            $availableDevices = Perangkat::where('status', 'Berfungsi')->count();
            $damagedDevices = Perangkat::where('status', 'Rusak')->count();
            $returDevices = Perangkat::where('status', 'Return')->count();
            $missingDevices = Perangkat::where('status', 'Hilang')->count();

            $devicesByCategory = KategoriPerangkat::withCount('perangkat')->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_devices' => $totalDevices,
                    'available' => $availableDevices,
                    'damaged' => $damagedDevices,
                    'retur' => $returDevices,
                    'missing' => $missingDevices,
                    'by_category' => $devicesByCategory
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan statistik: ' . $e->getMessage()
            ], 500);
        }
    }
}