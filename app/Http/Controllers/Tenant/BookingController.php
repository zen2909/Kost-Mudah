<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BoardingHouse;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show booking form modal data
     */
    public function showBookingForm(Request $request)
    {
        $boardingHouseId = $request->kost_id;
        $boardingHouse = BoardingHouse::with(['primaryPhoto'])->findOrFail($boardingHouseId);

        // Hitung harga per durasi dengan diskon
        $pricePerMonth = $boardingHouse->price_per_month;
        $durations = [
            ['months' => 1, 'label' => '1 Bulan', 'discount' => 0, 'class' => ''],
            ['months' => 3, 'label' => '3 Bulan', 'discount' => 2, 'class' => ''],
            ['months' => 6, 'label' => '6 Bulan', 'discount' => 5, 'class' => ''],
            ['months' => 12, 'label' => '12 Bulan', 'discount' => 10, 'class' => ''],
        ];

        foreach ($durations as &$duration) {
            $discountAmount = ($pricePerMonth * $duration['months'] * $duration['discount']) / 100;
            $duration['total'] = ($pricePerMonth * $duration['months']) - $discountAmount;
            $duration['price_per_month'] = $pricePerMonth;
            $duration['discount_amount'] = $discountAmount;
            $duration['discount_label'] = $duration['discount'] > 0 ? 'Hemat ' . $duration['discount'] . '%' : 'Reguler';
            $duration['is_selected'] = $duration['months'] == 1;
        }

        // Default selected
        $selectedDuration = $durations[0];

        return response()->json([
            'boarding_house' => $boardingHouse,
            'durations' => $durations,
            'selected_duration' => $selectedDuration,
            'start_date' => Carbon::now()->addDays(3)->format('d/m/Y'),
        ]);
    }

    /**
     * Process booking and create rental
     */
    public function processBooking(Request $request)
    {
        $request->validate([
            'boarding_house_id' => 'required|exists:boarding_houses,id',
            'duration_months' => 'required|in:1,3,6,12',
            'start_date' => 'required|date|after:today',
            'total_price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $tenant = Tenant::where('user_id', Auth::id())->first();
            if (!$tenant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tenant tidak ditemukan'
                ], 404);
            }

            $boardingHouse = BoardingHouse::findOrFail($request->boarding_house_id);
            
            // Cek ketersediaan kamar
            if ($boardingHouse->available_rooms <= 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Maaf, kamar sudah penuh'
                ], 400);
            }

            // Hitung end date
            $startDate = Carbon::parse($request->start_date);
            $endDate = $startDate->copy()->addMonths($request->duration_months);

            // Generate unique code
            $uniqueCode = Rental::generateUniqueCode();

            // Create rental
            $rental = Rental::create([
                'tenant_id' => $tenant->id,
                'boarding_house_id' => $request->boarding_house_id,
                'room_number' => 'RM-' . strtoupper(substr($uniqueCode, 0, 4)),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'duration_months' => $request->duration_months,
                'total_price' => $request->total_price,
                'unique_code' => $uniqueCode,
                'status' => 'pending',
            ]);

            // Kurangi available rooms
            $boardingHouse->decrement('available_rooms');

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking berhasil dibuat',
                'data' => [
                    'rental_id' => $rental->id,
                    'unique_code' => $uniqueCode,
                    'total_price' => $request->total_price,
                    'redirect_url' => route('tenant.payment.show', $rental->id),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}