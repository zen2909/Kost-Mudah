<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TenantController extends Controller
{
    public function dashboard()
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'Data penyewa tidak ditemukan.');
        }

        $activeRental = Rental::with([
            'boardingHouse.primaryPhoto',
            'boardingHouse.reviews'
        ])
            ->where('tenant_id', $tenant->id)
            ->where('status', 'paid')
            ->latest()
            ->first();

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

        return view('tenant.index', compact('activeRental', 'recommendations'));
    }

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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                    ->orWhere('address', 'ILIKE', "%{$search}%")
                    ->orWhere('kelurahan', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan', $request->kelurahan);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('price')) {
            switch ($request->price) {
                case '1':
                    $query->where('price_per_month', '<=', 1000000);
                    break;
                case '2':
                    $query->whereBetween('price_per_month', [1000000, 2000000]);
                    break;
                case '3':
                    $query->whereBetween('price_per_month', [2000000, 3000000]);
                    break;
                case '4':
                    $query->where('price_per_month', '>', 3000000);
                    break;
            }
        }

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

        $kosts = $query->paginate(9)->withQueryString();
        $kelurahans = BoardingHouse::select('kelurahan')->distinct()->orderBy('kelurahan')->pluck('kelurahan');

        return view('tenant.kost.index', compact('kosts', 'kelurahans'));
    }

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
        'reviews',
        'user.owner'  // Pastikan ini ada
    ])
        ->where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();

    $owner = $kost->user->owner;

    // Debug: cek data owner
    \Log::info('Owner data:', [
        'owner_exists' => $owner ? true : false,
        'ewallet_ovo' => $owner->ewallet_ovo ?? null,
        'ewallet_dana' => $owner->ewallet_dana ?? null,
        'ewallet_shopeepay' => $owner->ewallet_shopeepay ?? null,
        'qris_ewallet' => $owner->qris_ewallet ?? null,
        'qris_image' => $owner->qris_image ?? null,
    ]);

    return view('tenant.booking.index', compact('kost', 'owner'));
}

        public function storeBooking(Request $request)
    {
        try {
            Log::info('Store booking started', $request->except('modal_proof'));

            $validated = $request->validate([
                'boarding_house_id' => 'required|exists:boarding_houses,id',
                'start_date' => 'required|date|after_or_equal:today',
                'duration_months' => 'required|integer|min:1|max:12',
                'total_price' => 'required|numeric|min:1',
                'method' => 'required|in:bank_transfer,qris,ewallet',
                'ewallet_provider' => 'required_if:method,ewallet|nullable|in:ovo,dana,shopeepay',
                'modal_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'modal_notes' => 'nullable|string|max:1000',
            ]);

            Log::info('Validation passed');

            $tenant = Auth::user()->tenant;

            if (!$tenant) {
                Log::error('Tenant not found for user: ' . Auth::id());
                return response()->json([
                    'success' => false,
                    'message' => 'Data penyewa tidak ditemukan.'
                ], 400);
            }

            $kost = BoardingHouse::findOrFail($request->boarding_house_id);
            if ($kost->available_rooms < 1) {
                Log::warning('Kost penuh: ' . $kost->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Maaf, kamar kost sudah penuh.'
                ], 400);
            }

            Log::info('Creating rental...');

            $rental = Rental::create([
                'tenant_id' => $tenant->id,
                'boarding_house_id' => $request->boarding_house_id,
                'start_date' => $request->start_date,
                'end_date' => Carbon::parse($request->start_date)->addMonths((int) $request->duration_months),
                'duration_months' => (int) $request->duration_months,
                'total_price' => $request->total_price,
                'unique_code' => Rental::generateUniqueCode(),
                'status' => 'pending'
            ]);

            Log::info('Rental created: ' . $rental->id);

            $proofPath = $request->file('modal_proof')->store('payments', 'public');
            Log::info('Proof uploaded: ' . $proofPath);

            $paymentData = [
                'rental_id' => $rental->id,
                'method' => $request->method,
                'amount' => $rental->total_price,
                'proof_path' => $proofPath,
                'notes' => $request->modal_notes,
                'status' => 'pending',
            ];

            if ($request->method === 'ewallet') {
                $paymentData['ewallet_provider'] = $request->ewallet_provider;
            }

            Payment::create($paymentData);
            Log::info('Payment created');

            $kost->decrement('available_rooms');

            Log::info('Booking completed successfully');

            // Load data untuk invoice
            $rental->load([
                'tenant.user',
                'boardingHouse.primaryPhoto',
                'payment'
            ]);

            // Render view invoice sebagai string
            $invoiceHtml = view('tenant.booking.partials.invoice-modal', compact('rental'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dikirim, menunggu verifikasi admin.',
                'invoice_html' => $invoiceHtml,
                'rental_id' => $rental->id
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Store booking error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function payment(Rental $rental)
    {
        $rental->load([
            'boardingHouse.primaryPhoto',
            'boardingHouse.user',
            'tenant'
        ]);

        return view('tenant.payment.index', compact('rental'));
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
     * Invoice JSON - Untuk modal
     */
    public function invoiceJson(Rental $rental)
    {
        try {
            $rental->load([
                'tenant.user',
                'boardingHouse.primaryPhoto',
                'payment'
            ]);

            // Render view invoice modal sebagai string
            $invoiceHtml = view('tenant.booking.partials.invoice-modal', compact('rental'))->render();

            return response()->json([
                'success' => true,
                'invoice_html' => $invoiceHtml,
                'rental_id' => $rental->id
            ]);

        } catch (\Exception $e) {
            Log::error('Invoice JSON error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat invoice: ' . $e->getMessage()
            ], 500);
        }
    }

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

        return view('tenant.bills.index', compact('rentals', 'currentBill'));
    }

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

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $photo = $request->file('photo')->store('profile', 'public');
            $user->photo = $photo;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Kata sandi saat ini salah.'])
                    ->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if ($user->tenant) {
            $user->tenant->update([
                'occupation' => $request->occupation,
                'gender' => $request->gender,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}