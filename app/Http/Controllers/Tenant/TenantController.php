<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'Data penyewa tidak ditemukan.');
        }

        // Sewa aktif
        $activeRental = Rental::with([
            'boardingHouse.primaryPhoto',
            'boardingHouse.reviews'
        ])
            ->where('tenant_id', $tenant->id)
            ->where('status', 'paid')
            ->latest()
            ->first();

        // Rekomendasi kost
        $recommendations = BoardingHouse::with([
            'primaryPhoto',
            'reviews',
            'favorites' => function ($q) use ($tenant) {
                $q->where('tenant_id', $tenant->id);
            }
        ])
            ->where('status', 'active')
            ->latest()
            ->take(2)
            ->get();

        return view('tenant.index', compact(
            'activeRental',
            'recommendations'
        ));
    }

    /**
     * Halaman Cari Kost
     */
    public function kost(Request $request)
    {
        $query = BoardingHouse::with([
            'primaryPhoto',
            'reviews',
            'favorites' => function ($q) {
                if (Auth::check() && Auth::user()->tenant) {
                    $q->where('tenant_id', Auth::user()->tenant->id);
                }
            }
        ])->where('status', 'active');

        // SEARCH
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'ILIKE', "%{$search}%")
                    ->orWhere('address', 'ILIKE', "%{$search}%")
                    ->orWhere('kelurahan', 'ILIKE', "%{$search}%");
            });
        }

        // FILTER KELURAHAN
        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        // FILTER TIPE
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // FILTER HARGA
        if ($request->filled('price')) {

            switch ($request->price) {

                case '1':
                    $query->where('price_per_month', '<=', 1000000);
                    break;

                case '2':
                    $query->whereBetween('price_per_month', [
                        1000000,
                        2000000
                    ]);
                    break;

                case '3':
                    $query->whereBetween('price_per_month', [
                        2000000,
                        3000000
                    ]);
                    break;

                case '4':
                    $query->where('price_per_month', '>', 3000000);
                    break;
            }
        }

        // SORTING
        switch ($request->sort) {

            case 'price_low':
                $query->orderBy('price_per_month', 'asc');
                break;

            case 'price_high':
                $query->orderBy('price_per_month', 'desc');
                break;

            case 'name':
                $query->orderBy('name', 'asc');
                break;

            default:
                $query->latest();
                break;
        }

        // PAGINATION
        $kosts = $query
            ->paginate(9)
            ->withQueryString();

        // DATA FILTER
        $kelurahans = BoardingHouse::select('kelurahan')
            ->distinct()
            ->orderBy('kelurahan')
            ->pluck('kelurahan');

        return view('tenant.kost.index', compact(
            'kosts',
            'kelurahans'
        ));
    }

    /**
     * Detail Kost
     */
    public function detailKost($slug)
    {
        $kost = BoardingHouse::with([
            'photos',
            'primaryPhoto',
            'reviews',
            'user',
            'favorites' => function ($q) {
                if (Auth::check() && Auth::user()->tenant) {
                    $q->where('tenant_id', Auth::user()->tenant->id);
                }
            }
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('tenant.kost.show', compact('kost'));
    }

    /**
     * Riwayat
     */
    public function riwayat()
{
    $tenant = auth()->user()->tenant;

    $rentals = Rental::with([
        'boardingHouse.primaryPhoto',
        'payment'
    ])
    ->where('tenant_id', $tenant->id)
    ->latest()
    ->get();

    return view('tenant.riwayat.index', compact('rentals'));
}

    /**
     * Booking
     */
public function booking($slug)
{
    $tenant = Auth::user()->tenant;

    if (!$tenant) {
        return redirect()->back()->with('error', 'Data penyewa tidak ditemukan.');
    }

    $kost = BoardingHouse::with([
        'primaryPhoto',
        'photos',
        'user',
        'reviews'
    ])
    ->where('slug', $slug)
    ->where('status', 'active')
    ->firstOrFail();

    return view('tenant.booking.index', compact('kost'));
}

    /**
     * Pembayaran
     */
    public function payment(Rental $rental)
{
    $rental->load([
        'boardingHouse.primaryPhoto',
        'boardingHouse.user',
        'tenant'
    ]);

    return view('tenant.payment.index', compact('rental'));
}

    /**
     * Tagihan
     */
public function bills()
{
    $tenant = auth()->user()->tenant;

    $rentals = Rental::with([
        'boardingHouse.primaryPhoto',
        'payment'
    ])
    ->where('tenant_id', $tenant->id)
    ->latest()
    ->get();

    $currentBill = $rentals->firstWhere('status', 'pending');

    return view('tenant.bills.index', compact(
        'rentals',
        'currentBill'
    ));
}

    /**
     * Invoice
     */
        public function invoice(Rental $rental)
    {
        $rental->load([
            'tenant',
            'boardingHouse.primaryPhoto',
            'boardingHouse.user',
            'payment',
        ]);

        return view('tenant.invoice.index', compact('rental'));
    }

    /**
     * Profile
     */
    public function profile()
{
    $user = auth()->user()->load('tenant');

    return view('tenant.profile.index', compact('user'));
}
   public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'occupation' => 'nullable|string|max:255',
        'gender' => 'nullable|in:L,P',

        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        'current_password' => 'nullable|required_with:password',
        'password' => 'nullable|confirmed|min:8',
    ]);

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Upload Foto
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('photo')) {

        // hapus foto lama
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $photo = $request->file('photo')->store('profile', 'public');

        $user->photo = $photo;
    }

    /*
    |--------------------------------------------------------------------------
    | Update User
    |--------------------------------------------------------------------------
    */

    $user->name = $request->name;
    $user->phone = $request->phone;

    /*
    |--------------------------------------------------------------------------
    | Ganti Password
    |--------------------------------------------------------------------------
    */

    if ($request->filled('password')) {

        if (!Hash::check($request->current_password, $user->password)) {

            return back()
                ->withErrors([
                    'current_password' => 'Kata sandi saat ini salah.'
                ])
                ->withInput();

        }

        $user->password = Hash::make($request->password);
    }

    $user->save();

    /*
    |--------------------------------------------------------------------------
    | Update Tenant
    |--------------------------------------------------------------------------
    */

    if ($user->tenant) {

        $user->tenant->update([
            'occupation' => $request->occupation,
            'gender' => $request->gender,
        ]);

    }

    return back()->with(
        'success',
        'Profil berhasil diperbarui.'
    );
}

    public function storeBooking(Request $request)
{
    $request->validate([
        'boarding_house_id' => 'required|exists:boarding_houses,id',
        'start_date' => 'required|date',
        'duration_months' => 'required|integer|min:1',
        'total_price' => 'required|numeric'
    ]);

    $tenant = Auth::user()->tenant;

    $rental = Rental::create([
        'tenant_id' => $tenant->id,
        'boarding_house_id' => $request->boarding_house_id,
        'start_date' => $request->start_date,
        'end_date' => Carbon::parse($request->start_date)
            ->addMonths((int) $request->duration_months),
        'duration_months' => (int) $request->duration_months,
        'total_price' => $request->total_price,
        'unique_code' => Rental::generateUniqueCode(),
        'status' => 'pending'
    ]);

    return redirect()->route('tenant.payment.index', $rental->id);
}
public function storePayment(Request $request, Rental $rental)
{
    $request->validate([
        'method' => 'required|in:bank_transfer,qris,ewallet',
        'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'notes' => 'nullable|string|max:1000',
    ]);

    $path = $request->file('proof')->store('payments', 'public');

    Payment::create([
        'rental_id' => $rental->id,
        'method' => $request->input('method'),
        'amount' => $rental->total_price,
        'proof_path' => $path,
        'notes' => $request->input('notes'),
        'status' => 'pending',
    ]);

    return redirect()
        ->route('tenant.invoice.index', $rental)
        ->with('success', 'Bukti pembayaran berhasil dikirim.');
}
}