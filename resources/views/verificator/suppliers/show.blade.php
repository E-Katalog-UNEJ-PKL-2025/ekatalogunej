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

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Dokumen Terunggah</h3>
                @forelse($supplierProfile->documents as $doc)
                    <div class="border rounded-lg p-4 mb-4 flex justify-between items-center">
                        <div>
                            <p class="font-bold">{{ $doc->documentType->name }}</p>
                            <a href="{{ asset('storage/' . $doc->path_file) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                {{ $doc->name }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">Diunggah pada: {{ $doc->uploaded_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($doc->documentStatus->name == 'Disetujui') bg-green-100 text-green-800 
                                @elseif($doc->documentStatus->name == 'Ditolak') bg-red-100 text-red-800 
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $doc->documentStatus->name }}
                            </span>
                            <form action="{{ route('verificator.documents.updateStatus', $doc) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status_id" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                                    <option value="">Ubah Status</option>
                                    <option value="2">Setujui</option>
                                    <option value="3">Tolak</option>
                                </select>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Supplier ini belum mengunggah dokumen apapun.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>