<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\BoardingHouse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVerificationKostController extends Controller
{
    /**
     * Display a listing of pending property verification documents.
     */
    public function index()
    {
        // Ambil dokumen properti (bukan KTP) yang pending
        $pendingDocuments = Document::with(['user', 'boardingHouse'])
            ->where('document_type', '!=', 'ktp')
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik
        $totalPending = Document::where('document_type', '!=', 'ktp')->pending()->count();
        $newToday = Document::where('document_type', '!=', 'ktp')
            ->pending()
            ->whereDate('created_at', today())
            ->count();

        // Hitung total properti yang terdaftar
        $totalProperties = BoardingHouse::count();

        // Hitung properti yang sudah terverifikasi (memiliki dokumen verified)
        $verifiedProperties = BoardingHouse::whereHas('documents', function ($q) {
            $q->where('status', 'verified');
        })->count();

        return view('admin.verification.kost.index', compact(
            'pendingDocuments',
            'totalPending',
            'newToday',
            'totalProperties',
            'verifiedProperties'
        ));
    }

    /**
     * Display the specified property document.
     */
    public function show($id)
    {
        $document = Document::with(['user', 'boardingHouse', 'verifiedBy'])
            ->where('document_type', '!=', 'ktp')
            ->findOrFail($id);

        return response()->json($document);
    }

    /**
     * Verify or reject a property document.
     */
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $document = Document::where('document_type', '!=', 'ktp')->findOrFail($id);

            // Update document status
            $document->status = $request->status;
            $document->verified_at = now();
            $document->verified_by = auth()->id();

            if ($request->status === 'rejected') {
                $document->rejection_reason = $request->rejection_reason;
            }

            $document->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->status === 'verified' 
                    ? 'Dokumen properti berhasil diverifikasi' 
                    : 'Dokumen properti berhasil ditolak'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search documents for verification page.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');

        $documents = Document::with(['user', 'boardingHouse'])
            ->where('document_type', '!=', 'ktp')
            ->pending()
            ->where(function ($q) use ($query) {
                $q->where('document_number', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('boardingHouse', function ($houseQuery) use ($query) {
                        $houseQuery->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($documents);
    }
}