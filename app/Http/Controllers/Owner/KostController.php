<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\BoardingHousePhoto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boardingHouses = BoardingHouse::with(['photos', 'user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        $totalUnits = $boardingHouses->count();
        $totalAvailable = $boardingHouses->sum('available_rooms');
        $totalRooms = $boardingHouses->sum('total_rooms');
        $occupancyRate = $totalRooms > 0 ? round(($totalRooms - $totalAvailable) / $totalRooms * 100) : 0;
        $expiringSoon = 3;
        
        return view('owner.kost.index', compact(
            'boardingHouses',
            'totalUnits',
            'totalAvailable',
            'occupancyRate',
            'expiringSoon'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.kost.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'required|in:putra,putri,campur',
            'price_per_month' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'facilities' => 'nullable|array',
            'rules' => 'nullable|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $user = Auth::user();
        
        if (!$user->hasRole('owner')) {
            return back()->with('error', 'Anda tidak memiliki akses sebagai owner.');
        }

        $boardingHouse = BoardingHouse::create([
            'user_id' => $user->id,
            'slug' => Str::slug($request->name) . '-' . time(),
            'name' => $request->name,
            'address' => $request->address,
            'kelurahan' => $request->kelurahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => $request->type,
            'price_per_month' => $request->price_per_month,
            'total_rooms' => $request->total_rooms,
            'available_rooms' => $request->total_rooms,
            'description' => $request->description,
            'rules' => $request->rules,
            'facilities' => $request->facilities ?? [],
            'status' => 'active'
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('boarding-houses', 'public');
                BoardingHousePhoto::create([
                    'boarding_house_id' => $boardingHouse->id,
                    'path' => $path,
                    'is_primary' => $index === 0
                ]);
            }
        }

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $boardingHouse = BoardingHouse::with(['photos', 'user'])
        ->where('user_id', Auth::id())
        ->findOrFail($id);
        
    // Hitung statistik untuk detail
    $totalTenants = 20; // Static untuk sementara
    $totalRevenue = 'Rp 70.0M'; // Static untuk sementara
    
    return view('owner.kost.show', compact('boardingHouse', 'totalTenants', 'totalRevenue'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $boardingHouse = BoardingHouse::with('photos')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
        return view('owner.kost.edit', compact('boardingHouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $boardingHouse = BoardingHouse::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'kelurahan' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'required|in:putra,putri,campur',
            'price_per_month' => 'required|numeric|min:0',
            'total_rooms' => 'required|integer|min:1',
            'facilities' => 'nullable|array',
            'rules' => 'nullable|string',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $boardingHouse->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'address' => $request->address,
            'kelurahan' => $request->kelurahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => $request->type,
            'price_per_month' => $request->price_per_month,
            'total_rooms' => $request->total_rooms,
            'description' => $request->description,
            'rules' => $request->rules,
            'facilities' => $request->facilities ?? [],
            'status' => $request->status ?? 'active'
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('boarding-houses', 'public');
                BoardingHousePhoto::create([
                    'boarding_house_id' => $boardingHouse->id,
                    'path' => $path,
                    'is_primary' => false
                ]);
            }
        }

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $boardingHouse = BoardingHouse::where('user_id', Auth::id())->findOrFail($id);
        
        foreach ($boardingHouse->photos as $photo) {
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
            $photo->delete();
        }
        
        $boardingHouse->delete();

        return redirect()->route('owner.kost.index')
            ->with('success', 'Kost berhasil dihapus!');
    }

    /**
     * Delete a specific photo from boarding house.
     */
    public function deletePhoto(Request $request, $id)
{
    try {
        $photo = BoardingHousePhoto::findOrFail($id);
        
        $boardingHouse = BoardingHouse::where('user_id', Auth::id())->find($photo->boarding_house_id);
        
        if (!$boardingHouse) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke foto ini.'
            ], 403);
        }
        
        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }
        
        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus!'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
}