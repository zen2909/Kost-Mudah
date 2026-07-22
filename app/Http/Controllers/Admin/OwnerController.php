<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        // Gunakan JOIN langsung untuk memastikan filter status berfungsi
        $query = User::query()
            ->join('owners', 'owners.user_id', '=', 'users.id')
            ->select('users.*')
            ->where('users.role', 'owner')
            ->whereIn('owners.verification_status', ['approved', 'rejected']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('users.phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status (approved/rejected saja)
        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->where('owners.verification_status', 'approved');
            } elseif ($request->status === 'rejected') {
                $query->where('owners.verification_status', 'rejected');
            }
        }

        $owners = $query->with(['owner', 'boardingHouses', 'documents'])
            ->orderBy('users.created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Hitung statistik
        $totalOwners = User::where('role', 'owner')
            ->orWhereHas('roles', function ($q) {
                $q->where('name', 'owner');
            })
            ->count();

        // Pending: user yang verification_status = pending
        $pendingVerifications = Owner::where('verification_status', 'pending')->count();

        // Approved
        $verifiedOwners = Owner::where('verification_status', 'approved')->count();

        // Rejected
        $rejectedOwners = Owner::where('verification_status', 'rejected')->count();

        $totalProperties = BoardingHouse::count();

        $totalOwnersWithOwnerRecord = Owner::count();
        $retentionRate = $totalOwnersWithOwnerRecord > 0 
            ? round(($verifiedOwners / $totalOwnersWithOwnerRecord) * 100, 1) 
            : 0;

        return view('admin.owner.index', compact(
            'owners',
            'totalOwners',
            'pendingVerifications',
            'totalProperties',
            'retentionRate',
            'verifiedOwners',
            'rejectedOwners'
        ));
    }

    public function show($id)
    {
        $owner = User::with(['owner', 'boardingHouses', 'documents'])
            ->findOrFail($id);

        return view('admin.owner.show-owner', compact('owner'));
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user->isOwner()) {
            return redirect()->back()->with('error', 'User ini bukan pemilik properti');
        }

        DB::beginTransaction();

        try {
            if ($user->owner) {
                $user->owner->delete();
            }

            if ($user->boardingHouses) {
                foreach ($user->boardingHouses as $house) {
                    if ($house->documents) {
                        foreach ($house->documents as $doc) {
                            if ($doc->file_path && Storage::exists($doc->file_path)) {
                                Storage::delete($doc->file_path);
                            }
                            $doc->delete();
                        }
                    }
                    $house->delete();
                }
            }

            if ($user->documents) {
                foreach ($user->documents as $doc) {
                    if ($doc->file_path && Storage::exists($doc->file_path)) {
                        Storage::delete($doc->file_path);
                    }
                    $doc->delete();
                }
            }

            $user->delete();

            DB::commit();

            return redirect()->route('admin.owners.index')
                ->with('success', 'Pemilik berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}