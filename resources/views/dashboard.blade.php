<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Pesan Peringatan untuk Supplier Belum Terverifikasi --}}
    @if(Auth::user()->hasRole('supplier') && Auth::user()->supplierProfile && !Auth::user()->supplierProfile->is_verified)
        {{-- ... (kode pesan peringatan tetap sama) ... --}}
    @endif

    {{-- =============================================== --}}
    {{-- ===== KONTEN DINAMIS BERDASARKAN ROLE ===== --}}
    {{-- =============================================== --}}
    @role('pimpinan')
        {{-- Tampilan Khusus untuk Pimpinan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Card Total Mitra --}}
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-gray-500 text-sm font-medium">Total Mitra (Supplier)</h3>
                <p class="text-3xl font-bold mt-2">{{ $totalSuppliers }}</p>
            </div>
            {{-- Card Total Produk --}}
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-gray-500 text-sm font-medium">Total Produk di Katalog</h3>
                <p class="text-3xl font-bold mt-2">{{ $totalProducts }}</p>
            </div>
        </div>
    @else
        {{-- Tampilan Default untuk Role Lain --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 h-64 flex items-center justify-center bg-cover bg-center text-white" style="background-image: url('https://picsum.photos/1200/400');">
                <div class="text-center bg-black bg-opacity-50 p-6 rounded-lg">
                    <h2 class="text-4xl font-bold">Selamat Datang di E-Katalog UNEJ</h2>
                    <p class="mt-2">Temukan berbagai barang dan jasa dari mitra terpercaya kami.</p>
                </div>
            </div>
        </div>
    @endrole

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-2xl font-semibold mb-4">Katalog Produk Terbaru</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="col-span-4 text-center text-gray-500">Belum ada produk yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-app-layout>