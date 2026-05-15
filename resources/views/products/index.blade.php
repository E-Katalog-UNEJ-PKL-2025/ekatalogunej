<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Produk Saya
        </h2>
    </x-slot>

    @can('products.create')
        <div class="mb-4 flex justify-end mt-6 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 shadow-sm mr-2">
                + Tambah Produk
            </a>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-sm">
                📥 Import Excel
            </button>
        </div>
    @endcan

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4" x-data="{ modalOpen: false, modalData: {} }">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                
                <table class="min-w-full divide-y divide-gray-200 shadow-sm border border-gray-100">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded-md border border-gray-100">
                                    @else
                                        <span class="text-xs text-gray-500 italic">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($product->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                                    @elseif($product->status == 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tayang</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click="modalOpen = true; modalData = {{ \Illuminate\Support\Js::from(['desc' => $product->description, 'specs' => $product->specifications ?? [], 'image' => $product->image_path]) }}" class="text-blue-600 hover:text-blue-900 mr-4 font-semibold">
                                        👁️ Detail
                                    </button>

                                    @can('products.edit')
                                        <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan

                                    @can('products.delete')
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Hapus</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Anda belum memiliki produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak style="display: none;">
            <div @click.away="modalOpen = false" class="bg-white rounded-lg p-6 w-1/2 max-h-[80vh] overflow-y-auto shadow-2xl">
                <h3 class="text-lg font-bold mb-4 text-gray-700 border-b pb-2">Detail & Spesifikasi Barang</h3>

                <template x-if="modalData.image">
                    <div class="mb-4">
                        <img :src="'/storage/' + modalData.image" alt="Gambar Produk" class="w-full h-auto rounded-md shadow-sm border border-gray-100 object-contain max-h-[400px]">
                    </div>
                </template>

                <h4 class="font-semibold text-gray-700">Deskripsi:</h4>
                <p class="text-gray-600 mb-4" x-text="modalData.desc || 'Tidak ada deskripsi'"></p>

                <h4 class="font-semibold text-gray-700">Spesifikasi:</h4>
                <ul class="list-disc pl-5 text-gray-600">
                    <template x-for="(value, key) in modalData.specs" :key="key">
                        <li><strong x-text="key + ': '"></strong> <span x-text="value"></span></li>
                    </template>
                    <template x-if="Object.keys(modalData.specs || {}).length === 0">
                        <li>Tidak ada spesifikasi khusus.</li>
                    </template>
                </ul>

                <div class="mt-6 flex justify-end">
                    <button @click="modalOpen = false" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Tutup</button>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>