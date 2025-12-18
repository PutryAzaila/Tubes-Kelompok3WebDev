{{-- resources/views/inventory.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Inventory')
@section('page-title', 'Inventory Management')
@section('page-subtitle', 'Kelola semua barang inventory Anda di sini')

@section('content')
<!-- Action Bar -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex items-center justify-between border border-gray-100 max-md:flex-col max-md:gap-3">
    <div class="flex items-center gap-3 max-md:w-full max-md:flex-col">
        <div class="relative max-md:w-full">
            <input type="text" placeholder="Cari barang..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent max-md:w-full">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 max-md:w-full">
            <option>Semua Kategori</option>
            <option>Elektronik</option>
            <option>Furniture</option>
            <option>Alat Tulis</option>
        </select>
    </div>
    <button class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:shadow-lg transition-all flex items-center gap-2 max-md:w-full max-md:justify-center">
        <i class="fas fa-plus"></i>
        <span>Tambah Barang</span>
    </button>
</div>

<!-- Inventory Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Row 1 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">INV-001</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-laptop text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Laptop Dell Latitude 5420</p>
                                <p class="text-xs text-gray-500">Intel Core i5, 8GB RAM</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">Elektronik</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">15 unit</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full flex items-center gap-1 w-fit">
                            <i class="fas fa-check-circle text-xs"></i>
                            Tersedia
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-yellow-50 text-yellow-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">INV-002</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-mouse text-purple-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Mouse Wireless Logitech M720</p>
                                <p class="text-xs text-gray-500">Bluetooth & USB Receiver</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Aksesoris</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">32 unit</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full flex items-center gap-1 w-fit">
                            <i class="fas fa-check-circle text-xs"></i>
                            Tersedia
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-yellow-50 text-yellow-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 3 - Low Stock -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">INV-003</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plug text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Kabel HDMI 2.0</p>
                                <p class="text-xs text-gray-500">2 Meter, 4K Support</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">Aksesoris</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-red-600">3 unit</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full flex items-center gap-1 w-fit">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            Stok Rendah
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-yellow-50 text-yellow-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-mono text-gray-900">INV-004</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chair text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Kursi Kantor Ergonomis</p>
                                <p class="text-xs text-gray-500">Adjustable Height, Lumbar Support</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Furniture</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">8 unit</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full flex items-center gap-1 w-fit">
                            <i class="fas fa-check-circle text-xs"></i>
                            Tersedia
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-blue-50 text-blue-600 transition-colors">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-yellow-50 text-yellow-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-red-600 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between max-md:flex-col max-md:gap-3">
        <p class="text-sm text-gray-600">Menampilkan <span class="font-medium">1-4</span> dari <span class="font-medium">24</span> barang</p>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                Previous
            </button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                1
            </button>
            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                2
            </button>
            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                3
            </button>
            <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                Next
            </button>
        </div>
    </div>
</div>
@endsection