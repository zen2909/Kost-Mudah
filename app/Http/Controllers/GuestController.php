<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function home()
    {
        // Ambil kost populer
        $popularKosts = BoardingHouse::with(['primaryPhoto', 'user'])
            ->where('status', 'active')
            ->where('available_rooms', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Ambil testimoni (review terbaru)
        $testimonials = Review::with(['tenant.user'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Jika tidak ada testimoni, gunakan data dummy
        if ($testimonials->isEmpty()) {
            $testimonials = collect([
                (object) [
                    'tenant' => (object) ['user' => (object) ['name' => 'Budi Santoso', 'photo' => null]],
                    'rating' => 5,
                    'review' => 'Proses pencarian kost jadi jauh lebih cepat. Filter lokasinya sangat membantu karena saya butuh kost yang dekat dengan kampus ITS.',
                    'occupation' => 'Mahasiswa ITS'
                ],
                (object) [
                    'tenant' => (object) ['user' => (object) ['name' => 'Siti Aminah', 'photo' => null]],
                    'rating' => 5,
                    'review' => 'Sangat terbantu dengan fitur Verified Owner. Saya tidak perlu khawatir tertipu karena semua datanya sudah divalidasi oleh KostMudah.',
                    'occupation' => 'Karyawan Swasta'
                ],
                (object) [
                    'tenant' => (object) ['user' => (object) ['name' => 'Rizky Pratama', 'photo' => null]],
                    'rating' => 5,
                    'review' => 'Tampilan aplikasinya sangat bersih dan modern. Mencari kost di sekitar Mulyorejo jadi pengalaman yang menyenangkan.',
                    'occupation' => 'Mahasiswa UNAIR'
                ]
            ]);
        }

        $appName = Setting::get('app_name', 'KostMudah');

        return view('guest.index', compact('popularKosts', 'testimonials', 'appName'));
    }

    public function search(Request $request)
    {
        $query = BoardingHouse::with(['primaryPhoto', 'user'])
            ->where('status', 'active');

        // Search by location (case-insensitive - tidak peduli huruf besar/kecil)
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->whereRaw('LOWER(address) LIKE LOWER(?)', ["%{$location}%"])
                    ->orWhereRaw('LOWER(kelurahan) LIKE LOWER(?)', ["%{$location}%"]);
            });
        }

        // Search by keyword (case-insensitive - tidak peduli huruf besar/kecil)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(name) LIKE LOWER(?)', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(description) LIKE LOWER(?)', ["%{$keyword}%"]);
            });
        }

        // Jika tidak ada filter, tetap tampilkan semua kost aktif
        $kosts = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('guest.search', compact('kosts'));
    }

    public function show($slug)
    {
        $kost = BoardingHouse::with(['user', 'photos', 'primaryPhoto', 'reviews.tenant.user'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Kost terkait
        $relatedKosts = BoardingHouse::with(['primaryPhoto'])
            ->where('status', 'active')
            ->where('id', '!=', $kost->id)
            ->where('kelurahan', $kost->kelurahan)
            ->limit(4)
            ->get();

        if ($relatedKosts->isEmpty()) {
            $relatedKosts = BoardingHouse::with(['primaryPhoto'])
                ->where('status', 'active')
                ->where('id', '!=', $kost->id)
                ->limit(4)
                ->get();
        }

        return view('guest.detail', compact('kost', 'relatedKosts'));
    }
}