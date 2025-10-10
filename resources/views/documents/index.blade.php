<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dokumen Verifikasi
        </h2>
    </x-slot>

    <div class="space-y-6">
        {{-- ====================================================== --}}
        {{-- ===== BLOK NOTIFIKASI YANG SUDAH DIPERBAIKI (SATU BLOK SAJA) ===== --}}
        {{-- ====================================================== --}}
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @php($remarks = Auth::user()->supplierProfile->remarks ?? null)
        @if($remarks)
            <div class="p-4 bg-blue-100 text-blue-800 rounded-lg shadow-sm">
                <p class="font-bold">Pesan dari Verifikator:</p>
                <p>{{ $remarks }}</p>
            </div>
        @endif

        @if(Auth::user()->hasRole('supplier') && !Auth::user()->supplierProfile->is_verified)
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg shadow-sm">
                <p class="font-medium">Peringatan: Akun Anda masih belum terverifikasi.</p>
                <p class="text-sm">Silakan unggah dokumen yang diperlukan dan tunggu pesan atau persetujuan dari Verifikator atau Admin.</p>
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
                 @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                <h3 class="text-lg font-medium mb-4">Dokumen Terunggah</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Unggah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($documents as $doc)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doc->documentType->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doc->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $doc->uploaded_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($doc->documentStatus->name == 'Disetujui') bg-green-100 text-green-800 
                                        @elseif($doc->documentStatus->name == 'Ditolak') bg-red-100 text-red-800 
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $doc->documentStatus->name }}
                                    </span>
                                    @if($doc->document_status_id == 3 && $doc->remarks)
                                        <div class="mt-2 text-xs text-red-700 p-2 bg-red-50 rounded-md">
                                            <p class="font-bold">Alasan:</p>
                                            <p class="whitespace-normal">{{ $doc->remarks }}</p>
                                        </div>
                                    @endif
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
        @if($rejectedDocuments->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4 text-red-700">Dokumen yang Perlu Diperbaiki</h3>
                    <div class="space-y-4">
                        @foreach($rejectedDocuments as $doc)
                            <div class="p-4 bg-red-50 border-l-4 border-red-400">
                                <p class="font-bold text-red-800">{{ $doc->documentType->name }} - Ditolak</p>
                                @if($doc->remarks)
                                    <p class="text-sm text-red-700 mt-1">
                                        <span class="font-semibold">Pesan dari Verifikator:</span> {{ $doc->remarks }}
                                    </p>
                                @else
                                    <p class="text-sm text-red-700 mt-1">Dokumen ditolak tanpa pesan tambahan.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>