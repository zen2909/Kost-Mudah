<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVerificationOwnerController extends Controller
{
    /**
     * Display a listing of pending owner verification documents (KTP).
     */
    public function index()
    {
        // Ambil dokumen KTP yang pending
        $pendingDocuments = Document::with(['user'])
            ->where('document_type', 'ktp')
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik
        $totalPending = Document::where('document_type', 'ktp')->pending()->count();
        $newToday = Document::where('document_type', 'ktp')
            ->pending()
            ->whereDate('created_at', today())
            ->count();

        return view('admin.verification.owner.index', compact(
            'pendingDocuments',
            'totalPending',
            'newToday'
        ));
    }

    /**
     * Display the specified document.
     */
    public function show($id)
    {
        $document = Document::with(['user', 'verifiedBy'])
            ->where('document_type', 'ktp')
            ->findOrFail($id);

        return response()->json($document);
    }

    /**
     * Verify or reject an owner document.
     */
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'rejection_reason' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();

        try {
            $document = Document::where('document_type', 'ktp')->findOrFail($id);

            // Update document status
            $document->status = $request->status;
            $document->verified_at = now();
            $document->verified_by = auth()->id();

            if ($request->status === 'rejected') {
                $document->rejection_reason = $request->rejection_reason;
            }

            $document->save();

            // If document is verified, update owner verification status
            if ($request->status === 'verified' && $document->user) {
                if ($document->user->isOwner()) {
                    $owner = Owner::where('user_id', $document->user_id)->first();
                    if ($owner) {
                        $owner->verification_status = 'approved';
                        $owner->verified_at = now();
                        $owner->save();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->status === 'verified' 
                    ? 'KTP pemilik berhasil diverifikasi' 
                    : 'KTP pemilik berhasil ditolak'
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

        $documents = Document::with(['user'])
            ->where('document_type', 'ktp')
            ->pending()
            ->where(function ($q) use ($query) {
                $q->where('document_number', 'LIKE', "%{$query}%")
                    ->orWhereHas('user', function ($userQuery) use ($query) {
                        $userQuery->where('name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($documents);
    }
}