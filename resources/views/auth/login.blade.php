<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/android-chrome-512x512.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <title>Login - KostMudah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFB] min-h-screen flex items-center justify-center p-4">
    <div
        class="w-full max-w-7xl bg-white rounded-xl shadow-2xl overflow-hidden border border-[#C3C7CD] flex flex-col lg:flex-row">
        <!-- Left Side - Branding -->
        <div
            class="w-full lg:w-1/2 bg-[#06283D] relative overflow-hidden p-8 lg:p-16 flex flex-col justify-between min-h-[400px] lg:min-h-[700px]">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 opacity-60">
                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&h=800&fit=crop" alt="Property"
                    class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-b from-[#06283D]/40 via-[#06283D]/60 to-[#06283D]"></div>

            <!-- Content -->
            <div class="relative z-10 flex-1 flex flex-col justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 p-1.5 bg-white rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo-nobg.png') }}" alt="logo aplikasi">
                    </div>
                    <span class="text-white text-2xl font-bold">KostMudah</span>
                </div>

                <div>
                    <h2 class="text-white text-2xl lg:text-3xl font-bold leading-snug">
                        The most trusted platform<br />for property management
                    </h2>
                    <p class="text-[#ADCAE5] text-sm lg:text-base mt-3">
                        Manage your properties, track payments,<br class="hidden lg:block">
                        and connect with tenants seamlessly.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 p-8 lg:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <h2 class="text-[#191C1D] text-3xl font-bold">Welcome Back</h2>
                <p class="text-[#42474C] text-base mt-1">Please enter your details to sign in.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1.5">EMAIL
                        ADDRESS</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-4 text-[#73777D]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-12 pr-4 py-4 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#73777D]/50 transition-shadow"
                            placeholder="m.ghifari@example.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label
                            class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase">PASSWORD</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[#06283D] text-sm font-semibold hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2">
                            <svg class="w-4 h-5 text-[#73777D]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required
                            class="w-full pl-12 pr-12 py-4 bg-white border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#73777D]/50 transition-shadow"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-[#73777D] hover:text-[#191C1D] transition-colors">
                            <svg id="eyeIcon" class="w-5 h-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-[#C3C7CD] text-[#06283D] focus:ring-[#06283D] focus:ring-offset-0">
                    <label for="remember" class="text-[#42474C] text-sm font-medium cursor-pointer">
                        Remember me for 30 days
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-4 bg-[#06283D] text-white text-lg font-bold rounded-lg hover:bg-[#001220] transition-colors shadow-md flex items-center justify-center gap-3">
                    Sign In
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <span class="text-[#42474C] text-base">Don't have an account? </span>
                <a href="{{ route('register') }}" class="text-[#06283D] text-base font-semibold hover:underline">
                    Sign up for free
                </a>
            </div>

            <!-- Footer Badges -->
            <div class="mt-8 flex justify-center items-center gap-8 opacity-50">
                <div class="flex items-center gap-1.5">
                    <svg class="w-3 h-3.5 text-[#191C1D]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    <span class="text-[#191C1D] text-xs font-semibold tracking-wider uppercase">SECURE</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-3 text-[#191C1D]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                    </svg>
                    <span class="text-[#191C1D] text-xs font-semibold tracking-wider uppercase">CLOUD SYNC</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-3.5 h-3 text-[#191C1D]" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                    </svg>
                    <span class="text-[#191C1D] text-xs font-semibold tracking-wider uppercase">24/7 SUPPORT</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }
    </script>
</body>

</html>
