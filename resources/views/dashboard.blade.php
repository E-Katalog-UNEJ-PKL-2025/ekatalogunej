<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->hasRole('supplier') && Auth::user()->supplierProfile && !Auth::user()->supplierProfile->is_verified)
        <div class="mb-6 p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow-sm">
            <p class="font-medium">Peringatan: Akun Anda masih belum terverifikasi.</p>
            <p class="text-sm">
                <a href="{{ route('documents.index') }}" class="underline hover:text-yellow-900 font-semibold">Silakan unggah dokumen yang diperlukan</a> untuk dapat mulai mengelola produk Anda.
            </p>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
        <div class="p-6 h-64 flex items-center justify-center bg-cover bg-center text-white" style="background-image: url('https://picsum.photos/1200/400');">
            <div class="text-center bg-black bg-opacity-50 p-6 rounded-lg">
                <h2 class="text-4xl font-bold">Selamat Datang di E-Katalog UNEJ</h2>
                <p class="mt-2">Temukan berbagai barang dan jasa dari mitra terpercaya kami.</p>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-2xl font-semibold mb-4">Produk Terbaru</h3>
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