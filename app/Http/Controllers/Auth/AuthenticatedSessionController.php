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
        
        return redirect()->route('guest.home')->with('error', 'Akun Anda tidak memiliki role.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}