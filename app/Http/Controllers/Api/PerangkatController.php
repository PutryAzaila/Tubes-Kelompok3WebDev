<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Perangkat;
use App\Models\KategoriPerangkat;

class PerangkatController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $search = $request->input('search', '');
            $kategori = $request->input('kategori', '');
            $status = $request->input('status', '');
            
            $query = Perangkat::with('kategoriPerangkat');
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_perangkat', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
                });
            }
            
            if ($kategori) {
                $query->where('id_kategori_perangkat', $kategori);
            }
            
            if ($status) {
                $query->where('status', $status);
            }
            
            $perangkat = $query->orderBy('created_at', 'desc')->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'message' => 'Data perangkats retrieved successfully',
                'data' => $perangkat->items(),
                'pagination' => [
                    'total' => $perangkat->total(),
                    'per_page' => $perangkat->perPage(),
                    'current_page' => $perangkat->currentPage(),
                    'last_page' => $perangkat->lastPage(),
                    'from' => $perangkat->firstItem(),
                    'to' => $perangkat->lastItem()
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve perangkats',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/perangkats/{id}
    public function show($id)
    {
        try {
            $perangkat = Perangkat::with('kategoriPerangkat')->find($id);

            if (!$perangkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perangkat not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Perangkat data retrieved successfully',
                'data' => $perangkat
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_kategori_perangkat' => 'required|exists:kategori_perangkats,id',
                'nama_perangkat' => 'required|string|max:255',
                'status' => 'required|in:rusak,hilang,retur,berfungsi',
                'catatan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $perangkat = Perangkat::create($request->only([
                'id_kategori_perangkat',
                'nama_perangkat',
                'status',
                'catatan'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Perangkat created successfully',
                'data' => $perangkat->load('kategoriPerangkat')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // PUT/PATCH /api/perangkats/{id}
    public function update(Request $request, $id)
    {
        try {
            $perangkat = Perangkat::find($id);

            if (!$perangkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perangkat not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'id_kategori_perangkat' => 'sometimes|required|exists:kategori_perangkats,id',
                'nama_perangkat' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|required|in:rusak,hilang,retur,berfungsi',
                'catatan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $perangkat->update($request->only([
                'id_kategori_perangkat',
                'nama_perangkat',
                'status',
                'catatan'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Perangkat updated successfully',
                'data' => $perangkat->load('kategoriPerangkat')
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/perangkats/{id}
    public function destroy($id)
    {
        try {
            $perangkat = Perangkat::find($id);

            if (!$perangkat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Perangkat not found'
                ], 404);
            }

            $perangkat->delete();

            return response()->json([
                'success' => true,
                'message' => 'Perangkat deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete perangkat',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/perangkats/statistics
    public function statistics()
    {
        try {
            $totalDevices = Perangkat::count();
            $availableDevices = Perangkat::where('status', 'berfungsi')->count();
            $damagedDevices = Perangkat::where('status', 'rusak')->count();
            $returDevices = Perangkat::where('status', 'retur')->count();
            $missingDevices = Perangkat::where('status', 'hilang')->count();

            // Get devices by category
            $devicesByCategory = KategoriPerangkat::withCount('perangkat')->get();

            return response()->json([
                'success' => true,
                'message' => 'Statistics retrieved successfully',
                'data' => [
                    'total_devices' => $totalDevices,
                    'available' => $availableDevices,
                    'damaged' => $damagedDevices,
                    'retur' => $returDevices,
                    'missing' => $missingDevices,
                    'by_category' => $devicesByCategory
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // GET /api/perangkats/export
    public function export(Request $request)
    {
        try {
            $perangkat = Perangkat::with('kategoriPerangkat')->get();

            $exportData = $perangkat->map(function($item) {
                return [
                    'Nama Perangkat' => $item->nama_perangkat,
                    'Kategori' => $item->KategoriPerangkat->nama_kategori ?? '-',
                    'Status' => ucfirst($item->status),
                    'Catatan' => $item->catatan ?? '-',
                    'Created At' => $item->created_at->format('Y-m-d H:i:s')
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data prepared for export',
                'data' => $exportData
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
