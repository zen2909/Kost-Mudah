<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua boarding house dari owner yang verification_status = approved
        $query = BoardingHouse::query()
            ->whereHas('user', function ($q) {
                $q->where('role', 'owner')
                    ->orWhereHas('roles', function ($r) {
                        $r->where('name', 'owner');
                    });
            })
            ->whereHas('owner', function ($q) {
                $q->where('verification_status', 'approved');
            });

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active');
            } elseif ($request->status === 'inactive') {
                $query->where('status', 'inactive');
            }
        }

        $kosts = $query->with(['user', 'owner', 'photos'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Hitung statistik
        $totalProperties = BoardingHouse::count();

        // Active: kost dengan status active
        $activeProperties = BoardingHouse::where('status', 'active')->count();

        // Inactive: kost dengan status inactive
        $inactiveProperties = BoardingHouse::where('status', 'inactive')->count();

        // Pending Review: kost dari owner yang verification_status = pending
        $pendingReview = BoardingHouse::whereHas('owner', function ($q) {
            $q->where('verification_status', 'pending');
        })->count();

        // Growth (contoh: tambahan bulan ini)
        $growthThisMonth = BoardingHouse::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.kost.index', compact(
            'kosts',
            'totalProperties',
            'activeProperties',
            'inactiveProperties',
            'pendingReview',
            'growthThisMonth'
        ));
    }

    public function show($id)
    {
        $kost = BoardingHouse::with(['user', 'owner', 'photos', 'rentals'])
            ->whereHas('owner', function ($q) {
                $q->where('verification_status', 'approved');
            })
            ->findOrFail($id);

        return view('admin.kost.show', compact('kost'));
    }

    public function destroy($id)
    {
        $kost = BoardingHouse::whereHas('owner', function ($q) {
            $q->where('verification_status', 'approved');
        })->findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus foto-foto terkait
            if ($kost->photos) {
                foreach ($kost->photos as $photo) {
                    if ($photo->path && Storage::exists($photo->path)) {
                        Storage::delete($photo->path);
                    }
                    $photo->delete();
                }
            }

            // Hapus dokumen terkait
            if ($kost->documents) {
                foreach ($kost->documents as $doc) {
                    if ($doc->file_path && Storage::exists($doc->file_path)) {
                        Storage::delete($doc->file_path);
                    }
                    $doc->delete();
                }
            }

            $kost->delete();

            DB::commit();

            return redirect()->route('admin.kost.index')
                ->with('success', 'Kost berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}