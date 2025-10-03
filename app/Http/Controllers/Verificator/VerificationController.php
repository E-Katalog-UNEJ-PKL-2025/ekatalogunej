<?php

namespace App\Http\Controllers\Verificator;

use App\Http\Controllers\Controller;
use App\Models\SupplierProfile;
use App\Models\SupplierDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $supplierProfile->load('user', 'documents.documentType', 'documents.documentStatus');

        // === TAMBAHKAN LOGIKA PENGECEKAN DI SINI ===
        // Asumsi dokumen wajib adalah KTP, NPWP, SIUP (ID 1, 2, 3)
        $requiredDocTypes = [1, 2, 3];
        $uploadedRequiredDocs = $supplierProfile->documents->whereIn('document_type_id', $requiredDocTypes);

        // Tombol verifikasi bisa aktif jika jumlah dokumen wajib yang diunggah sudah 3
        // DAN semuanya sudah berstatus 'Disetujui' (ID 2)
        $canBeVerified = ($uploadedRequiredDocs->count() >= count($requiredDocTypes)) && $uploadedRequiredDocs->every(function ($doc) {
            return $doc->document_status_id == 2;
        });
        // === BATAS AKHIR LOGIKA PENGECEKAN ===

        return view('verificator.suppliers.show', compact('supplierProfile', 'canBeVerified'));
    }

    /**
     * Mengubah status verifikasi sebuah dokumen.
     */
    public function updateDocumentStatus(Request $request, SupplierDocument $document)
    {
        $request->validate([
            'status_id' => 'required|in:1,2,3', // 2 = Disetujui, 3 = Ditolak
            'remarks' => 'nullable|string|max:500', // Validasi untuk pesan
        ]);

        $remarks = $request->input('remarks');

        // Jika disetujui, hapus pesan/remarks sebelumnya.
        if ($request->status_id == 2) {
            $remarks = null;
        }

        $document->update([
            'document_status_id' => $request->status_id,
            'remarks' => $remarks,
        ]);

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

    public function verifySupplier(Request $request, SupplierProfile $supplierProfile)
    {
        // Toggle status verifikasi (jika sudah true jadi false, begitu sebaliknya)
        $newStatus = !$supplierProfile->is_verified;
        $supplierProfile->update(['is_verified' => $newStatus]);

        $message = $newStatus ? 'Supplier berhasil diverifikasi.' : 'Verifikasi supplier berhasil dibatalkan.';

        return redirect()->back()->with('success', $message);
    }
    
    // app/Http/Controllers/Verificator/VerificationController.php
    public function updateSupplierRemarks(Request $request, SupplierProfile $supplierProfile)
    {
        $request->validate(['remarks' => 'nullable|string']);
        $supplierProfile->update(['remarks' => $request->remarks]);
        return redirect()->back()->with('success', 'Pesan untuk supplier berhasil diperbarui.');
    }

    public function destroyDocument(SupplierDocument $document)
    {
        if (Storage::disk('public')->exists($document->path_file)) {
            Storage::disk('public')->delete($document->path_file);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }
}