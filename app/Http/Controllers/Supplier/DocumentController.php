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
        $supplierProfile = Auth::user()->supplierProfile;
        $allDocuments = SupplierDocument::where('supplier_profile_id', $supplierProfile->id)
                                ->with('documentType', 'documentStatus')
                                ->get();

        // Pisahkan dokumen yang ditolak (status ID 3) dari yang lain
        $rejectedDocuments = $allDocuments->where('document_status_id', 3);
        $documents = $allDocuments->where('document_status_id', '!=', 3);

        $documentTypes = DocumentType::all();

        return view('documents.index', compact('documents', 'rejectedDocuments', 'documentTypes'));
    }

    /**
     * Menyimpan dokumen yang diunggah.
     */
    public function store(Request $request)
    {
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