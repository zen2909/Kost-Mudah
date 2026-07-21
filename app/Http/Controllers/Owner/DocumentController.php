<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\BoardingHouse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua dokumen milik owner
        $documents = Document::with(['boardingHouse'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Hitung statistik
        $totalDocuments = $documents->count();
        $pendingDocuments = $documents->where('status', 'pending')->count();
        $verifiedDocuments = $documents->where('status', 'verified')->count();
        $rejectedDocuments = $documents->where('status', 'rejected')->count();
        
        // Ambil daftar properti untuk filter
        $properties = BoardingHouse::where('user_id', $user->id)->get();
        
        // Trust score (contoh: berdasarkan persentase dokumen terverifikasi)
        $trustScore = $totalDocuments > 0 ? round(($verifiedDocuments / $totalDocuments) * 100) : 0;
        
        // Document types
        $documentTypes = [
            'ktp' => 'Kartu Tanda Penduduk',
            'imb' => 'IMB (Izin Mendirikan Bangunan)',
            'pbb' => 'PBB (Pajak Bumi Bangunan)',
            'sertifikat' => 'Sertifikat Properti',
            'akta' => 'Akta Tanah',
            'other' => 'Lainnya',
        ];
        
        return view('owner.document', compact(
            'documents',
            'totalDocuments',
            'pendingDocuments',
            'verifiedDocuments',
            'rejectedDocuments',
            'trustScore',
            'properties',
            'documentTypes'
        ));
    }

    /**
     * Store a newly uploaded document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'custom_type' => 'nullable|string|max:100',
            'document_number' => 'nullable|string|max:50',
            'expired_date' => 'nullable|date',
            'boarding_house_id' => 'nullable|exists:boarding_houses,id',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $user = Auth::user();
        
        // Upload file
        $file = $request->file('document');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents/' . $user->id, $fileName, 'public');

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

        return redirect()->route('owner.document.index')
            ->with('success', 'Dokumen berhasil diupload dan menunggu verifikasi admin.');
    }

    /**
     * Show the specified document.
     */
   public function show(string $id)
{
    $document = Document::with(['boardingHouse'])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
    
    return view('owner.document.show', compact('document'));
}

    /**
     * Update the specified document.
     */
    public function update(Request $request, string $id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'document_number' => 'nullable|string|max:50',
            'expired_date' => 'nullable|date',
        ]);

        $document->update([
            'document_number' => $request->document_number,
            'expired_date' => $request->expired_date,
        ]);

        return redirect()->route('owner.document.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified document.
     */
    public function destroy(string $id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);
        
        // Hapus file
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('owner.document.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}