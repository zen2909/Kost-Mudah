<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KostVerificationController extends Controller
{
    /**
     * Display a listing of property verification documents.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua dokumen properti (bukan KTP)
        $documents = Document::where('user_id', $user->id)
            ->where('document_type', '!=', 'ktp')
            ->with(['boardingHouse'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Ambil daftar properti milik owner
        $properties = BoardingHouse::where('user_id', $user->id)->get();
        
        // Hitung statistik
        $totalDocuments = $documents->count();
        $pendingDocuments = $documents->where('status', 'pending')->count();
        $verifiedDocuments = $documents->where('status', 'verified')->count();
        $rejectedDocuments = $documents->where('status', 'rejected')->count();
        
        // Hitung properti yang sudah terverifikasi (memiliki dokumen verified)
        $verifiedProperties = $properties->filter(function($property) {
            return $property->documents->where('status', 'verified')->count() > 0;
        })->count();
        
        // Trust score untuk verifikasi properti
        $trustScore = 0;
        if ($totalDocuments > 0) {
            $trustScore = round(($verifiedDocuments / $totalDocuments) * 100);
        }
        
        // Document types (tanpa KTP)
        $documentTypes = [
            'imb' => 'IMB (Izin Mendirikan Bangunan)',
            'pbb' => 'PBB (Pajak Bumi Bangunan)',
            'sertifikat' => 'Sertifikat Properti',
            'akta' => 'Akta Tanah',
            'other' => 'Lainnya',
        ];
        
        return view('owner.verification.kost.index', compact(
            'documents',
            'totalDocuments',
            'pendingDocuments',
            'verifiedDocuments',
            'rejectedDocuments',
            'verifiedProperties',
            'trustScore',
            'properties',
            'documentTypes'
        ));
    }

    /**
     * Show the specified property document.
     */
    public function show($id)
    {
        $document = Document::where('user_id', Auth::id())
            ->where('document_type', '!=', 'ktp')
            ->with(['boardingHouse'])
            ->findOrFail($id);
        
        return view('owner.verification.kost.show', compact('document'));
    }

    /**
     * Store a newly uploaded property document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string|in:imb,pbb,sertifikat,akta,other',
            'custom_type' => 'nullable|string|max:100',
            'document_number' => 'nullable|string|max:50',
            'boarding_house_id' => 'nullable|exists:boarding_houses,id',
            'expired_date' => 'nullable|date',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = Auth::user();
        
        // Upload file
        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $user->id . '/kost', $fileName, 'public');

        Document::create([
            'user_id' => $user->id,
            'boarding_house_id' => $request->boarding_house_id,
            'document_type' => $request->document_type,
            'custom_type' => $request->document_type === 'other' ? $request->custom_type : null,
            'document_number' => $request->document_number,
            'file_path' => $filePath,
            'expired_date' => $request->expired_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('owner.verification.kost.index')
            ->with('success', 'Dokumen properti berhasil diupload dan menunggu verifikasi admin.');
    }

    /**
     * Remove the specified property document.
     */
    public function destroy($id)
    {
        $document = Document::where('user_id', Auth::id())
            ->where('document_type', '!=', 'ktp')
            ->findOrFail($id);
        
        // Hapus file
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('owner.verification.kost.index')
            ->with('success', 'Dokumen properti berhasil dihapus.');
    }
}