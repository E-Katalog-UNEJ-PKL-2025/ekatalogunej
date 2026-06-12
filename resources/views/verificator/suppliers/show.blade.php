<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Dokumen: {{ $supplierProfile->user->name }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kotak Status Verifikasi Supplier --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium">Status Verifikasi Supplier</h3>
                    @if($supplierProfile->is_verified)
                        <p class="text-sm text-green-600 font-semibold mt-1">
                            TERVERIFIKASI (Bisa mengelola produk)
                        </p>
                    @else
                        <p class="text-sm text-yellow-600 font-semibold mt-1">
                            BELUM TERVERIFIKASI
                        </p>
                    @endif
                </div>

                <form action="{{ route('verificator.suppliers.verify', $supplierProfile) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    @if($supplierProfile->is_verified)
                         <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Batalkan Verifikasi
                        </button>
                    @else
                        <button type="submit" 
                                @if(!$canBeVerified) disabled @endif
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Setujui Verifikasi
                        </button>
                    @endif
                </form>
            </div>
            @if(!$supplierProfile->is_verified && !$canBeVerified)
                <p class="text-xs text-gray-500 mt-2">Tombol "Setujui Verifikasi" akan aktif jika semua dokumen wajib (KTP, NPWP, SIUP) telah diunggah dan disetujui.</p>
            @endif
        </div>

        {{-- Dokumen Terunggah --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Dokumen Terunggah</h3>
                @forelse($supplierProfile->documents as $doc)
                    <div class="border rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-bold">{{ $doc->documentType->name }}</p>
                                <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    {{ $doc->name }}
                                </a>
                                <p class="text-xs text-gray-500 mt-1">Diunggah pada: {{ $doc->uploaded_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($doc->documentStatus->name == 'Disetujui') bg-green-100 text-green-800 
                                    @elseif($doc->documentStatus->name == 'Ditolak') bg-red-100 text-red-800 
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $doc->documentStatus->name }}
                                </span>
                                <form action="{{ route('verificator.documents.updateStatus', $doc) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_id" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                                        <option value="1" @selected($doc->document_status_id == 1)>Menunggu</option>
                                        <option value="2" @selected($doc->document_status_id == 2)>Setujui</option>
                                        <option value="3" @selected($doc->document_status_id == 3)>Tolak</option>
                                    </select>
                                </form>
                                <form action="{{ route('verificator.documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium p-2 rounded-md hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Supplier ini belum mengunggah dokumen apapun.</p>
                @endforelse
            </div>
        </div>

        {{-- Kirim Pesan ke Supplier --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('verificator.suppliers.updateRemarks', $supplierProfile) }}" method="POST">
                @csrf
                @method('PATCH')
                <label for="remarks" class="text-lg font-medium text-gray-900">Kirim Pesan ke Supplier</label>
                <p class="text-sm text-gray-600 mt-1">Gunakan kotak ini untuk memberi instruksi atau alasan penolakan secara umum.</p>
                <textarea name="remarks" id="remarks" rows="3" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm">{{ $supplierProfile->remarks }}</textarea>
                <x-primary-button class="mt-3 bg-blue-600">Kirim Pesan</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>