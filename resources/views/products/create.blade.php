<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('products.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    @include('products.partials.form-fields')

                    <div class="border-t pt-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Spesifikasi Tambahan (Opsional)</h3>
                        <p class="text-sm text-gray-500 mb-4">Tambahkan spesifikasi sedetail mungkin untuk mempermudah Verifikator HPS.</p>
                        
                        <div id="specifications-container" class="space-y-2">
                            </div>
                        
                        <button type="button" onclick="addSpecRow()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 border border-blue-600 px-3 py-1 rounded">
                            + Tambah Spesifikasi
                        </button>
                    </div>

                    <div class="flex items-center gap-4 mt-6">
                        <x-primary-button class="bg-green-600 hover:bg-green-700">{{ __('Simpan & Ajukan Verifikasi') }}</x-primary-button>
                        <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addSpecRow() {
            const container = document.getElementById('specifications-container');
            const row = document.createElement('div');
            row.className = 'flex gap-2 items-center';
            
            // Trik jitu: Nama input value akan berubah sesuai Nama Atribut yang diketik
            row.innerHTML = `
                <input type="text" oninput="updateName(this)" placeholder="Atribut (Misal: RAM)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-1/3" required>
                <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-2/3" placeholder="Nilai (Misal: 8GB DDR4)" required>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold px-2">X</button>
            `;
            container.appendChild(row);
        }

        function updateName(element) {
            // Mengubah atribut name pada input nilai di sebelahnya
            // Hasilnya akan terkirim ke Laravel sebagai array: specifications['RAM'] = '8GB DDR4'
            const valueInput = element.nextElementSibling;
            if (element.value.trim() !== '') {
                valueInput.name = "specifications[" + element.value + "]";
            } else {
                valueInput.removeAttribute('name');
            }
        }
    </script>
</x-app-layout>