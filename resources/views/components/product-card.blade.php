@props(['product'])

<div class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 h-full flex flex-col cursor-pointer">
    <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://via.placeholder.com/400x300' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
    <div class="p-4 flex flex-col flex-grow">
        <h3 class="font-bold text-lg text-gray-800 truncate">{{ $product->name }}</h3>
        <p class="text-md font-semibold text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        <div class="mt-auto pt-2">
             <p class="text-sm text-gray-500">{{ $product->supplierProfile->user->name ?? 'N/A' }}</p>
        </div>
    </div>
</div>