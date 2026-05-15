<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Harga Perkiraan Sendiri (HPS)
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <h3 class="font-bold text-lg mb-4 text-gray-700 border-b pb-2">Daftar Produk Menunggu Verifikasi HPS</h3>
                
                <table class="min-w-full divide-y divide-gray-200 shadow-sm border border-gray-100">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jml. Supplier</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Harga Terendah</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Harga Rata-rata</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($hpsProducts as $hps)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $hps->name }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    <span class="px-2 py-1 bg-gray-200 text-xs rounded-md">{{ $hps->category->nama ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-blue-600 rounded-full">{{ $hps->jumlah_supplier }}</span>
                                </td>
                                <td class="px-6 py-4 text-green-600 font-bold">Rp {{ number_format($hps->harga_terendah, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-gray-600">Rp {{ number_format($hps->harga_rata_rata, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    
                                    <form action="{{ route('verificator.hps.update', $hps->name) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menetapkan barang ini sebagai HPS Resmi?')">
                                        @csrf 
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-3 py-1.5 bg-green-500 text-white font-semibold rounded hover:bg-green-600 text-xs shadow-sm transition-transform active:scale-95">ACC HPS</button>
                                    </form>
                                    
                                    <form action="{{ route('verificator.hps.update', $hps->name) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Yakin ingin menolak usulan harga barang ini?')">
                                        @csrf 
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white font-semibold rounded hover:bg-red-600 text-xs shadow-sm transition-transform active:scale-95">Tolak</button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                    Belum ada produk yang menunggu verifikasi HPS.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>