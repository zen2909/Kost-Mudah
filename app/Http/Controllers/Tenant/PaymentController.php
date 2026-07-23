<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Show payment page
     */
    public function showPayment($rentalId)
    {
        try {
            $rental = Rental::with(['boardingHouse', 'tenant.user'])
                ->where('id', $rentalId)
                ->first();

            if (!$rental) {
                return redirect()->route('tenant.kost.index')
                    ->with('error', 'Data pemesanan tidak ditemukan');
            }

            // Cek apakah rental milik tenant yang login
            $tenant = Tenant::where('user_id', Auth::id())->first();
            if (!$tenant || $rental->tenant_id != $tenant->id) {
                abort(403, 'Unauthorized');
            }

            // Cek apakah sudah ada payment yang terverifikasi
            $existingPayment = Payment::where('rental_id', $rental->id)
                ->where('status', 'verified')
                ->first();

            if ($existingPayment) {
                return redirect()->route('tenant.riwayat.index')
                    ->with('info', 'Pembayaran sudah terverifikasi');
            }

            // Cek payment pending
            $pendingPayment = Payment::where('rental_id', $rental->id)
                ->where('status', 'pending')
                ->first();

            $methods = [
                ['value' => 'bank_transfer', 'label' => 'Transfer Bank', 'icon' => 'bank'],
                ['value' => 'qris', 'label' => 'QRIS', 'icon' => 'qris'],
                ['value' => 'ewallet', 'label' => 'E-Wallet', 'icon' => 'wallet'],
            ];

            // Bank account info
            $bankAccounts = [
                [
                    'name' => 'Bank Central Asia (BCA)',
                    'account_number' => '8830 1234 5678',
                    'holder' => 'PT KostMudah Properti Indonesia',
                    'logo' => 'bca.png',
                ],
                [
                    'name' => 'Bank Mandiri',
                    'account_number' => '123 4567 8901',
                    'holder' => 'PT KostMudah Properti Indonesia',
                    'logo' => 'mandiri.png',
                ],
            ];

            // QRIS image
            $qrisImage = asset('images/qris-sample.png');

            // E-Wallet options
            $ewalletOptions = [
                ['value' => 'ovo', 'label' => 'OVO', 'logo' => 'ovo.png'],
                ['value' => 'dana', 'label' => 'DANA', 'logo' => 'dana.png'],
                ['value' => 'shopeepay', 'label' => 'ShopeePay', 'logo' => 'shopeepay.png'],
            ];

            return view('tenant.payment.index', compact(
                'rental',
                'methods',
                'bankAccounts',
                'qrisImage',
                'ewalletOptions',
                'pendingPayment'
            ));

        } catch (\Exception $e) {
            Log::error('Payment show error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('tenant.kost.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Upload payment proof
     */
    public function uploadProof(Request $request)
    {
        try {
            $request->validate([
                'rental_id' => 'required|exists:rentals,id',
                'method' => 'required|in:bank_transfer,qris,ewallet',
                'proof' => 'required|file|mimes:png,jpg,jpeg,pdf|max:5120',
                'notes' => 'nullable|string|max:500',
                'ewallet_type' => 'required_if:method,ewallet|nullable|in:ovo,dana,shopeepay',
                'account_number' => 'required_if:method,ewallet|nullable|string|max:20',
            ]);

            DB::beginTransaction();

            $rental = Rental::find($request->rental_id);
            if (!$rental) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data pemesanan tidak ditemukan'
                ], 404);
            }
            
            // Cek kepemilikan
            $tenant = Tenant::where('user_id', Auth::id())->first();
            if (!$tenant || $rental->tenant_id != $tenant->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            // Cek apakah sudah ada payment yang verified
            $verifiedPayment = Payment::where('rental_id', $rental->id)
                ->where('status', 'verified')
                ->first();

            if ($verifiedPayment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Pembayaran sudah terverifikasi'
                ], 400);
            }

            // Cek payment pending
            $existingPayment = Payment::where('rental_id', $rental->id)
                ->where('status', 'pending')
                ->first();

            if ($existingPayment) {
                // Hapus file lama jika ada
                if ($existingPayment->proof_path && Storage::disk('public')->exists($existingPayment->proof_path)) {
                    Storage::disk('public')->delete($existingPayment->proof_path);
                }
                $payment = $existingPayment;
            } else {
                $payment = new Payment();
                $payment->rental_id = $rental->id;
            }

            // Upload file
            if ($request->hasFile('proof')) {
                $file = $request->file('proof');
                $filename = time() . '_' . ($rental->unique_code ?? 'rental') . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payments/proofs', $filename, 'public');
                
                $payment->proof_path = $path;
            }

            // Simpan data payment
            $payment->method = $request->method;
            $payment->amount = $rental->total_price;
            $payment->status = 'pending';

            // Notes
            $notes = $request->notes ?? '';
            if ($request->method === 'ewallet') {
                $notes = ($notes ? $notes . ' | ' : '') 
                    . 'E-Wallet: ' . $request->ewallet_type 
                    . ' | No: ' . $request->account_number;
            }
            $payment->notes = $notes;

            $payment->save();

            // Update rental status
            $rental->status = 'pending';
            $rental->save();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Bukti pembayaran berhasil diupload',
                'redirect_url' => route('tenant.riwayat.index'),
                'payment_id' => $payment->id,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment upload error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel payment
     */
    public function cancelPayment($rentalId)
{
    try {
        DB::beginTransaction();

        $rental = Rental::with(['boardingHouse'])->find($rentalId);
        
        if (!$rental) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pemesanan tidak ditemukan'
            ], 404);
        }

        // Cek kepemilikan
        $tenant = Tenant::where('user_id', Auth::id())->first();
        if (!$tenant || $rental->tenant_id != $tenant->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 403);
        }

        // Cek apakah rental sudah dibayar
        if ($rental->status === 'paid' || $rental->status === 'completed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Pemesanan sudah dibayar dan tidak dapat dibatalkan'
            ], 400);
        }

        // Hapus payment yang pending jika ada
        $payment = Payment::where('rental_id', $rental->id)
            ->where('status', 'pending')
            ->first();

        if ($payment) {
            if ($payment->proof_path && Storage::disk('public')->exists($payment->proof_path)) {
                Storage::disk('public')->delete($payment->proof_path);
            }
            $payment->delete();
        }

        // Kembalikan available rooms
        if ($rental->boardingHouse) {
            $rental->boardingHouse->increment('available_rooms');
        }

        // Hapus rental
        $rental->delete();

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Pemesanan berhasil dibatalkan',
            'redirect_url' => route('tenant.kost.index'),
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment cancel error: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}

}