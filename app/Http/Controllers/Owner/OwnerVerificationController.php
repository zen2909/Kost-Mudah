<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Owner;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OwnerVerificationController extends Controller
{
    /**
     * Display a listing of identity verification documents.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil dokumen KTP milik owner (document_type = 'ktp')
        $documents = Document::where('user_id', $user->id)
            ->where('document_type', 'ktp')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Cek apakah owner sudah memiliki data owner
        $owner = Owner::where('user_id', $user->id)->first();
        
        // Hitung statistik
        $totalDocuments = $documents->count();
        $pendingDocuments = $documents->where('status', 'pending')->count();
        $verifiedDocuments = $documents->where('status', 'verified')->count();
        $rejectedDocuments = $documents->where('status', 'rejected')->count();
        
        // Status verifikasi dari owner
        $verificationStatus = $owner ? $owner->verification_status : 'unverified';
        
        $statusLabels = [
            'approved' => 'Terverifikasi',
            'pending' => 'Menunggu Verifikasi',
            'rejected' => 'Ditolak',
            'unverified' => 'Belum Verifikasi'
        ];
        
        $statusColors = [
            'approved' => 'bg-[#DCFCE7] text-[#15803D]',
            'pending' => 'bg-[#FEF3C7] text-[#92400E]',
            'rejected' => 'bg-[#FEE2E2] text-[#991B1B]',
            'unverified' => 'bg-[#F2F4F5] text-[#42474C]'
        ];
        
        // Trust score untuk verifikasi data diri
        $trustScore = 0;
        if ($verifiedDocuments > 0) {
            $trustScore = 100;
        } elseif ($pendingDocuments > 0) {
            $trustScore = 50;
        } elseif ($rejectedDocuments > 0) {
            $trustScore = 25;
        }
        
        return view('owner.verification.identity.index', compact(
            'documents',
            'totalDocuments',
            'pendingDocuments',
            'verifiedDocuments',
            'rejectedDocuments',
            'verificationStatus',
            'statusLabels',
            'statusColors',
            'trustScore'
        ));
    }

    /**
     * Show the specified identity document.
     */
    public function show($id)
    {
        $document = Document::where('user_id', Auth::id())
            ->where('document_type', 'ktp')
            ->findOrFail($id);
        
        return view('owner.verification.identity.show', compact('document'));
    }

    /**
     * Store a newly uploaded identity document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_number' => 'nullable|string|max:50',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = Auth::user();
        
        // Cek apakah sudah ada dokumen KTP yang pending atau verified
        $existingKtp = Document::where('user_id', $user->id)
            ->where('document_type', 'ktp')
            ->whereIn('status', ['pending', 'verified'])
            ->exists();
            
        if ($existingKtp) {
            return redirect()->route('owner.verification.identity.index')
                ->with('error', 'Anda sudah memiliki dokumen KTP yang sedang diproses atau sudah terverifikasi.');
        }
        
        // Upload file
        $file = $request->file('document');
        $fileName = time() . '_ktp_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $user->id . '/ktp', $fileName, 'public');

        Document::create([
            'user_id' => $user->id,
            'boarding_house_id' => null,
            'document_type' => 'ktp',
            'custom_type' => null,
            'document_number' => $request->document_number,
            'file_path' => $filePath,
            'expired_date' => null,
            'status' => 'pending',
            'notes' => null,
        ]);

        // Update status owner menjadi pending jika belum
        $owner = Owner::where('user_id', $user->id)->first();
        if ($owner && $owner->verification_status === 'unverified') {
            $owner->verification_status = 'pending';
            $owner->save();
        }

        return redirect()->route('owner.verification.identity.index')
            ->with('success', 'Dokumen KTP berhasil diupload dan menunggu verifikasi admin.');
    }

    /**
     * Remove the specified identity document.
     */
    public function destroy($id)
    {
        $document = Document::where('user_id', Auth::id())
            ->where('document_type', 'ktp')
            ->findOrFail($id);
        
        // Hapus file
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('owner.verification.identity.index')
            ->with('success', 'Dokumen KTP berhasil dihapus.');
    }
}