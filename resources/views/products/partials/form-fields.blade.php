<div>
    <x-input-label for="name" value="Nama Produk" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $product->name ?? '')" required autofocus />
    <x-input-error class="mt-2" :messages="$errors->get('name')" />
</div>

<div>
    <x-input-label for="price" value="Harga (Rp)" />
    <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price', $product->price ?? '')" required />
    <x-input-error class="mt-2" :messages="$errors->get('price')" />
</div>

<div>
    <x-input-label for="category_id" value="Kategori Produk" />
    <select name="category_id" id="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
        <option value="">Pilih Kategori</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                {{ $category->nama }}
            </option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
</div>

<div>
    <x-input-label for="description" value="Deskripsi" />
    <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full h-32">{{ old('description', $product->description ?? '') }}</textarea>
    <x-input-error class="mt-2" :messages="$errors->get('description')" />
</div>

<div>
    <x-input-label for="image" value="Gambar Produk" />
    <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
    <p class="mt-1 text-sm text-gray-500">Tipe file: JPG, PNG, WEBP. Maks 2MB.</p>
    <x-input-error class="mt-2" :messages="$errors->get('image')" />

    @if(isset($product) && $product->image_path)
        <div class="mt-4">
            <p class="text-sm font-medium text-gray-700">Gambar Saat Ini:</p>
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="mt-2 h-32 w-32 object-cover rounded-md">
        </div>
    @endif
</div>