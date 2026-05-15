<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Produk: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @include('products.partials.form-fields', ['product' => $product])

                <div class="border-t pt-4 mt-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Spesifikasi Tambahan</h3>
                    <p class="text-sm text-gray-500 mb-4">Edit spesifikasi yang sudah ada atau tambahkan yang baru.</p>
                    
                    <div id="specifications-container" class="space-y-2">
                        @if($product->specifications && is_array($product->specifications))
                            @foreach($product->specifications as $key => $value)
                                <div class="flex gap-2 items-center mb-2">
                                    <input type="text" oninput="updateName(this)" value="{{ $key }}" placeholder="Atribut (Misal: RAM)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-1/3" required>
                                    <input type="text" name="specifications[{{ $key }}]" value="{{ $value }}" placeholder="Nilai (Misal: 8GB)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-2/3" required>
                                    <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold px-2">X</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button type="button" onclick="addSpecRow()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 border border-blue-600 px-3 py-1 rounded shadow-sm">
                        + Tambah Spesifikasi
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <x-primary-button class="bg-unej-green">{{ __('Update') }}</x-primary-button>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addSpecRow() {
            const container = document.getElementById('specifications-container');
            const row = document.createElement('div');
            row.className = 'flex gap-2 items-center mb-2';
            
            row.innerHTML = `
                <input type="text" oninput="updateName(this)" placeholder="Atribut (Misal: RAM)" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-1/3" required>
                <input type="text" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-2/3" placeholder="Nilai (Misal: 8GB DDR4)" required>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold px-2">X</button>
            `;
            container.appendChild(row);
        }

        function updateName(element) {
            const valueInput = element.nextElementSibling;
            if (element.value.trim() !== '') {
                valueInput.name = "specifications[" + element.value + "]";
            } else {
                valueInput.removeAttribute('name');
            }
        }
    </script>
</x-app-layout>