<?php

namespace App\Http\Controllers\Verificator;

use App\Http\Controllers\Controller;
use App\Models\SupplierProfile;
use App\Models\SupplierDocument;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Menampilkan daftar semua supplier.
     */
    public function index()
    {
        $suppliers = SupplierProfile::with('user')->get();
        return view('verificator.suppliers.index', compact('suppliers'));
    }

    /**
     * Menampilkan detail dan dokumen dari satu supplier.
     */
    public function show(SupplierProfile $supplierProfile)
    {
        // Eager load relasi untuk efisiensi query
        $supplierProfile->load('user', 'documents.documentType', 'documents.documentStatus');
        return view('verificator.suppliers.show', compact('supplierProfile'));
    }

    /**
     * Mengubah status verifikasi sebuah dokumen.
     */
    public function updateDocumentStatus(Request $request, SupplierDocument $document)
    {
        $request->validate([
            'status_id' => 'required|in:2,3', // 2 = Disetujui, 3 = Ditolak
        ]);

        $document->update(['document_status_id' => $request->status_id]);

        // Cek apakah semua dokumen supplier sudah disetujui
        $this->checkAndUpdateSupplierVerificationStatus($document->supplierProfile);

        return redirect()->back()->with('success', 'Status dokumen berhasil diperbarui.');
    }

    /**
     * Helper function untuk mengecek dan mengupdate status verifikasi supplier.
     */
    private function checkAndUpdateSupplierVerificationStatus(SupplierProfile $supplierProfile)
    {
        // Ambil semua dokumen yang WAJIB (misal: KTP, NPWP, SIUP)
        // Asumsi ID 1, 2, 3 adalah KTP, NPWP, SIUP
        $requiredDocs = $supplierProfile->documents()
                            ->whereIn('document_type_id', [1, 2, 3])
                            ->get();

        // Cek jika jumlah dokumen wajib yang diunggah sudah 3
        if ($requiredDocs->count() < 3) {
            return; // Belum lengkap, jangan lakukan apa-apa
        }

        // Cek apakah SEMUA dokumen wajib sudah berstatus 'Disetujui' (ID 2)
        $allApproved = $requiredDocs->every(function ($doc) {
            return $doc->document_status_id == 2;
        });

        if ($allApproved) {
            $supplierProfile->update(['is_verified' => true]);
        } else {
            $supplierProfile->update(['is_verified' => false]);
        }
    }
}