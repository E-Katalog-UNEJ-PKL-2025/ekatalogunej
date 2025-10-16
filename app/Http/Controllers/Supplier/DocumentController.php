<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SupplierDocument;
use App\Models\DocumentType;

class DocumentController extends Controller
{
    /**
     * Menampilkan halaman manajemen dokumen.
     */
    public function index()
    {
        // Cek jika pengguna BUKAN supplier
        if (!Auth::user()->hasRole('supplier')) {
            // Tampilkan view yang sama, tapi dengan pesan error
            return view('documents.index_for_non_supplier');
        }

        // Kode yang sudah ada untuk supplier
        $supplierProfile = Auth::user()->supplierProfile;
        $documents = SupplierDocument::where('supplier_profile_id', $supplierProfile->id)->get();
        $documentTypes = DocumentType::all(); 

        // Pisahkan dokumen yang ditolak (status ID 3) dari yang lain
        $rejectedDocuments = $documents->where('document_status_id', 3);
        $documents = $documents->where('document_status_id', '!=', 3);

        return view('documents.index', compact('documents', 'rejectedDocuments', 'documentTypes'));
    }

    /**
     * Menyimpan dokumen yang diunggah.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('supplier')) {
            abort(403, 'Hanya supplier yang bisa mengunggah dokumen.');
        }
        
        $request->validate([
            'document_type_id' => 'required|exists:document_types,id',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $supplierProfile = Auth::user()->supplierProfile;
        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $supplierProfile->id, $fileName, 'public');

        SupplierDocument::create([
            'supplier_profile_id' => $supplierProfile->id,
            'document_type_id' => $request->document_type_id,
            'document_status_id' => 1, // Default: "Menunggu Verifikasi"
            'name' => $fileName,
            'path_file' => $filePath,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diunggah.');
    }
}