@props(['product'])

<div
    x-show="showModal"
    style="display: none;"
    x-on:keydown.escape.window="showModal = false"
    class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6"
>
    {{-- Latar Belakang Overlay --}}
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 bg-black/50"></div>

    {{-- Konten Modal --}}
    <div
        x-show="showModal"
        x-transition
        @click.outside="showModal = false"
        class="relative w-full max-w-2xl max-h-[90vh] overflow-y-auto bg-white rounded-lg shadow-xl"
    >
        {{-- Template ini akan diisi data saat produk di-klik --}}
        <template x-if="selectedProduct">
            <div>
                {{-- Tombol Tutup --}}
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <img :src="selectedProduct.image_path ? '/storage/' + selectedProduct.image_path : 'https://via.placeholder.com/800x400'" :alt="selectedProduct.name" class="w-full h-64 object-cover">

                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex items-center gap-2">
                             <h2 x-text="selectedProduct.name" class="text-3xl font-bold text-gray-900">Nama Produk</h2>
                             <span x-text="selectedProduct.category.nama" class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full" x-show="selectedProduct.category">Kategori</span>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Harga</p>
                        <p class="text-2xl font-semibold text-gray-800" x-text="'Rp ' + Number(selectedProduct.price).toLocaleString('id-ID')">Rp 0</p>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                        <p class="mt-1 text-gray-600 whitespace-pre-wrap" x-text="selectedProduct.description">Deskripsi produk akan muncul di sini.</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Disediakan oleh: <strong x-text="selectedProduct.supplier_profile.user.name">Nama Supplier</strong>
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>