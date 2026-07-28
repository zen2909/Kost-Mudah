<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Owner;
use App\Models\BoardingHouse;

class ProfileController extends Controller
{
    /**
     * Display the owner profile.
     */
    public function index()
    {
        $user = Auth::user();
        $owner = Owner::where('user_id', $user->id)->first();
        
        // Statistik
        $totalProperties = BoardingHouse::where('user_id', $user->id)->count();
        $totalTenants = \App\Models\Rental::whereHas('boardingHouse', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'paid')->count();
        
        return view('owner.profile', compact('user', 'owner', 'totalProperties', 'totalTenants'));
    }

    /**
     * Update the owner profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('owner.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $file = $request->file('photo');
        $fileName = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('profiles', $fileName, 'public');

        $user->update([
            'photo' => $filePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui!',
            'photo_url' => Storage::url($filePath),
        ]);
    }

    /**
     * Remove profile photo.
     */
    public function removePhoto(Request $request)
    {
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update([
            'photo' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil dihapus!',
        ]);
    }

    /**
     * Update the bank account.
     */
    public function updateBank(Request $request)
    {
        $user = Auth::user();
        $owner = Owner::where('user_id', $user->id)->first();
        
        if (!$owner) {
            $owner = Owner::create([
                'user_id' => $user->id,
                'verification_status' => 'pending',
            ]);
        }

        $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:20',
            'bank_account_holder' => 'required|string|max:100',
        ]);

        $owner->update([
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_holder' => $request->bank_account_holder,
        ]);

        return redirect()->route('owner.profile.index')->with('success', 'Rekening bank berhasil diperbarui!');
    }

    /**
     * Update E-Wallet (OVO, DANA, ShopeePay)
     */
   public function updateEwallet(Request $request)
{
    $user = Auth::user();
    $owner = Owner::where('user_id', $user->id)->first();
    
    if (!$owner) {
        $owner = Owner::create([
            'user_id' => $user->id,
            'verification_status' => 'pending',
        ]);
    }

    $request->validate([
        'ewallet_ovo' => 'nullable|string|max:20',
        'ewallet_dana' => 'nullable|string|max:20',
        'ewallet_shopeepay' => 'nullable|string|max:20',
        'qris_ewallet' => 'nullable|string|in:ovo,dana,shopeepay',
        'qris_image' => 'nullable|image|mimes:png,jpeg,jpg|max:2048',
    ]);

    $data = [
        'ewallet_ovo' => $request->ewallet_ovo,
        'ewallet_dana' => $request->ewallet_dana,
        'ewallet_shopeepay' => $request->ewallet_shopeepay,
    ];

    // Update QRIS e-wallet jika ada
    if ($request->has('qris_ewallet')) {
        $data['qris_ewallet'] = $request->qris_ewallet;
    }

    // Upload QRIS Image
    if ($request->hasFile('qris_image')) {
        // Hapus QRIS lama jika ada
        if ($owner->qris_image && Storage::disk('public')->exists($owner->qris_image)) {
            Storage::disk('public')->delete($owner->qris_image);
        }

        $file = $request->file('qris_image');
        $fileName = 'qris_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('qris', $fileName, 'public');
        $data['qris_image'] = $filePath;
    }

    $owner->update($data);

    return redirect()->route('owner.profile.index')->with('success', 'E-Wallet dan QRIS berhasil diperbarui!');
}

    /**
     * Update the password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('owner.profile.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Delete the account.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password tidak sesuai']);
        }

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $owner = Owner::where('user_id', $user->id)->first();
        if ($owner) {
            $owner->delete();
        }
        
        $user->delete();
        
        Auth::logout();
        
        return redirect('/')->with('success', 'Akun berhasil dihapus');
    }
}