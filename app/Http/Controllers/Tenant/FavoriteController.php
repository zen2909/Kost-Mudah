<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Menampilkan daftar kost favorit tenant.
     */
    public function index()
    {
        $tenant = Auth::user()->tenant;

        $favorites = Favorite::with([
                'boardingHouse.primaryPhoto',
                'boardingHouse.reviews',
                'boardingHouse.user'
            ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->get();

        return view('tenant.favorit.index', compact('favorites'));
    }

    /**
     * Tambah / Hapus favorit.
     */
    public function toggle(BoardingHouse $boardingHouse)
    {
        $tenant = Auth::user()->tenant;

        $favorite = Favorite::where('tenant_id', $tenant->id)
            ->where('boarding_house_id', $boardingHouse->id)
            ->first();

        if ($favorite) {

            $favorite->delete();

            return response()->json([
                'success' => true,
                'favorited' => false,
                'message' => 'Favorit dihapus.'
            ]);
        }

        Favorite::create([
            'tenant_id' => $tenant->id,
            'boarding_house_id' => $boardingHouse->id,
        ]);

        return response()->json([
            'success' => true,
            'favorited' => true,
            'message' => 'Berhasil ditambahkan ke favorit.'
        ]);
    }
}