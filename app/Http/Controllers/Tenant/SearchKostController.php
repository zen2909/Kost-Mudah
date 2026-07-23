<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Favorite;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchKostController extends Controller
{
    /**
     * Display a listing of boarding houses with filters
     */
    public function index(Request $request)
    {
        $query = BoardingHouse::with(['primaryPhoto', 'reviews', 'owner.user'])
            ->where('status', 'active')
            ->where('available_rooms', '>', 0);

        // SEARCH - PostgreSQL compatible
        if ($request->filled('location')) {
            $searchTerm = trim($request->location);
            
            $query->where(function($q) use ($searchTerm) {
                // Search di name, kelurahan, address (case-insensitive)
                $q->where(DB::raw('LOWER(name)'), 'LIKE', '%' . strtolower($searchTerm) . '%')
                  ->orWhere(DB::raw('LOWER(kelurahan)'), 'LIKE', '%' . strtolower($searchTerm) . '%')
                  ->orWhere(DB::raw('LOWER(address)'), 'LIKE', '%' . strtolower($searchTerm) . '%');
                
                // Search di facilities (PostgreSQL JSON array)
                // facilities disimpan sebagai JSON array di PostgreSQL
                $q->orWhere(function($subQ) use ($searchTerm) {
                    $subQ->whereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(facilities::jsonb) AS elem WHERE LOWER(elem) LIKE ?)", ['%' . strtolower($searchTerm) . '%']);
                });
            });
        }

        // Filter by price range
        if ($request->filled('price_min') && $request->price_min !== '') {
            $query->where('price_per_month', '>=', (int) $request->price_min);
        }
        if ($request->filled('price_max') && $request->price_max !== '') {
            $query->where('price_per_month', '<=', (int) $request->price_max);
        }

        // Filter by facilities - PostgreSQL JSON array
        if ($request->filled('facilities') && $request->facilities !== '') {
            $facility = $request->facilities;
            $query->whereRaw("EXISTS (SELECT 1 FROM jsonb_array_elements_text(facilities::jsonb) AS elem WHERE LOWER(elem) = ?)", [strtolower($facility)]);
        }

        // Filter by type (putra/putri/campur)
        if ($request->filled('type') && $request->type !== '') {
            $query->where('type', $request->type);
        }

        // Sorting
        $sort = $request->sort ?? 'popular';
        switch ($sort) {
            case 'popular':
                $query->withCount('rentals')->orderBy('rentals_count', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price_per_month', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_per_month', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $boardingHouses = $query->paginate(9)->withQueryString();

        // Get favorite IDs for current tenant
        $favoriteIds = [];
        if (Auth::check() && Auth::user()->isTenant()) {
            $tenant = Tenant::where('user_id', Auth::id())->first();
            if ($tenant) {
                $favoriteIds = Favorite::where('tenant_id', $tenant->id)
                    ->pluck('boarding_house_id')
                    ->toArray();
            }
        }

        // Get unique facilities for filter
        $allFacilities = $this->getAllFacilities();

        // Get distinct locations untuk autocomplete suggestion
        $locations = BoardingHouse::where('status', 'active')
            ->whereNotNull('kelurahan')
            ->where('kelurahan', '!=', '')
            ->select('kelurahan')
            ->distinct()
            ->pluck('kelurahan')
            ->toArray();

        return view('tenant.kost.index', compact(
            'boardingHouses', 
            'favoriteIds', 
            'allFacilities',
            'locations'
        ));
    }

    /**
     * Display the specified boarding house
     */
    public function show($id)
    {
        $boardingHouse = BoardingHouse::with([
            'photos',
            'primaryPhoto',
            'reviews',
            'reviews.user',
            'owner.user',
            'rentals' => function($query) {
                $query->where('status', 'active');
            }
        ])->findOrFail($id);

        // Check if favorited
        $isFavorited = false;
        if (Auth::check() && Auth::user()->isTenant()) {
            $tenant = Tenant::where('user_id', Auth::id())->first();
            if ($tenant) {
                $isFavorited = Favorite::where('tenant_id', $tenant->id)
                    ->where('boarding_house_id', $id)
                    ->exists();
            }
        }

        // Get average rating
        $averageRating = $boardingHouse->reviews->avg('rating') ?? 0;
        $totalReviews = $boardingHouse->reviews->count();

        // Get facilities as array
        $facilities = $boardingHouse->facilities ?? [];

        // Get rules as array
        $rules = $boardingHouse->rules ? explode("\n", $boardingHouse->rules) : [];

        return view('tenant.kost.show', compact(
            'boardingHouse',
            'isFavorited',
            'averageRating',
            'totalReviews',
            'facilities',
            'rules'
        ));
    }

    /**
     * Get suggestions for location autocomplete
     */
    public function suggestLocations(Request $request)
    {
        $search = $request->q ?? '';
        
        if (strlen($search) < 1) {
            return response()->json([]);
        }

        $locations = BoardingHouse::where('status', 'active')
            ->whereNotNull('kelurahan')
            ->where('kelurahan', '!=', '')
            ->where(DB::raw('LOWER(kelurahan)'), 'LIKE', '%' . strtolower($search) . '%')
            ->select('kelurahan as name')
            ->distinct()
            ->limit(10)
            ->get();

        return response()->json($locations);
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite(Request $request)
    {
        $boardingHouseId = $request->boarding_house_id;
        $userId = Auth::id();

        // Get tenant
        $tenant = Tenant::where('user_id', $userId)->first();
        
        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tenant tidak ditemukan'
            ], 404);
        }

        $favorite = Favorite::where('tenant_id', $tenant->id)
            ->where('boarding_house_id', $boardingHouseId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'success',
                'action' => 'removed',
                'message' => 'Dihapus dari favorit'
            ]);
        } else {
            Favorite::create([
                'tenant_id' => $tenant->id,
                'boarding_house_id' => $boardingHouseId
            ]);
            return response()->json([
                'status' => 'success',
                'action' => 'added',
                'message' => 'Ditambahkan ke favorit'
            ]);
        }
    }

    /**
     * Get all unique facilities from boarding houses - PostgreSQL version
     */
    private function getAllFacilities()
    {
        $allFacilities = [];
        
        // PostgreSQL: Get all facilities from JSON array
        try {
            $results = BoardingHouse::where('status', 'active')
                ->whereNotNull('facilities')
                ->where('facilities', '!=', '')
                ->get(['facilities']);
            
            foreach ($results as $bh) {
                if ($bh->facilities) {
                    // Jika facilities adalah string JSON, decode dulu
                    if (is_string($bh->facilities)) {
                        $facilities = json_decode($bh->facilities, true);
                    } else {
                        $facilities = $bh->facilities;
                    }
                    
                    if (is_array($facilities)) {
                        foreach ($facilities as $facility) {
                            $facility = trim($facility);
                            if (!empty($facility) && !in_array($facility, $allFacilities)) {
                                $allFacilities[] = $facility;
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Fallback jika ada error
            $allFacilities = ['AC', 'WiFi', 'TV', 'Kulkas', 'Parkir', 'Laundry'];
        }
        
        sort($allFacilities);
        return $allFacilities;
    }
}