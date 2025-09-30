@props(['product'])

<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <a href="#">
        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
    </a>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-gray-800 truncate">
            <a href="#" class="hover:text-unej-green">{{ $product->name }}</a>
        </h3>
        <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <div class="mt-2 text-sm text-gray-600">
            <p>Oleh: {{ $product->supplierProfile->user->name }}</p>
        </div>
    </div>
</div>