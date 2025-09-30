<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dokumen Verifikasi
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if(Auth::user()->hasRole('supplier') && !Auth::user()->supplierProfile->is_verified)
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow-sm">
                <p class="font-medium">Peringatan: Akun Anda masih belum terverifikasi.</p>
                <p class="text-sm">Silakan unggah dokumen yang diperlukan untuk dapat mulai mengelola produk Anda.</p>
            </div>
        @endif

        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Unggah Dokumen Baru</h3>
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="document_type_id" value="Tipe Dokumen" />
                            <select name="document_type_id" id="document_type_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="">Pilih Tipe Dokumen</option>
                                @foreach($documentTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('document_type_id')" />
                        </div>

                        <div>
                            <x-input-label for="document_file" value="Pilih File" />
                            <input id="document_file" name="document_file" type="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                            <p class="mt-1 text-sm text-gray-500">Tipe file: PDF, JPG, PNG. Maks 2MB.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('document_file')" />
                        </div>
                    </div>
                    <div class="mt-6">
                        <x-primary-button class="bg-unej-green">Unggah</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Dokumen Terunggah</h3>
                <table class="min-w-full divide-y divide-gray-200">
                     <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview & Nama File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Unggah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($documents as $doc)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doc->documentType->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $extension = pathinfo($doc->path_file, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                                    @endphp

                                    @if($isImage)
                                        <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $doc->path_file) }}" alt="{{ $doc->name }}" class="h-12 w-16 object-cover rounded-md inline-block mr-2">
                                            {{ Str::limit($doc->name, 30) }}
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 underline">
                                            {{ Str::limit($doc->name, 40) }}
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doc->uploaded_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($doc->documentStatus->name == 'Disetujui') bg-green-100 text-green-800 
                                        @elseif($doc->documentStatus->name == 'Ditolak') bg-red-100 text-red-800 
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $doc->documentStatus->name }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada dokumen yang diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>