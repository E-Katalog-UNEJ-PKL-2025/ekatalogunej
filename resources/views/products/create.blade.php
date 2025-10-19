<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Produk Baru
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form action="{{ route('products.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @include('products.partials.form-fields')

                <div class="flex items-center gap-4">
                    <x-primary-button class="bg-unej-action">{{ __('Simpan') }}</x-primary-button>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>