<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        
        // Debug logging
        Log::info('User logged in:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'has_role_owner' => $user->hasRole('owner'),
            'has_role_admin' => $user->hasRole('admin'),
            'has_role_tenant' => $user->hasRole('tenant'),
        ]);

        // Redirect berdasarkan role
        if ($user->hasRole('owner')) {
            Log::info('Redirecting to owner dashboard');
            return redirect()->route('owner.dashboard');
        } elseif ($user->hasRole('admin')) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('tenant')) {
            Log::info('Redirecting to tenant dashboard');
            return redirect()->route('tenant.dashboard');
        }

        // Jika tidak ada role
        Log::warning('User has no role:', ['user_id' => $user->id]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('error', 'Akun Anda tidak memiliki role.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}