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
    <title>Daftar - KostMudah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFB] min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">
    <!-- Background Decorations -->
    <div class="absolute w-96 h-96 bg-[#06283D]/5 rounded-full blur-3xl -top-24 -right-24"></div>
    <div class="absolute w-96 h-96 bg-[#0194DC]/5 rounded-full blur-3xl -bottom-24 -left-24"></div>

    <div
        class="w-full max-w-7xl bg-white rounded-xl shadow-xl overflow-hidden relative z-10 flex flex-col lg:flex-row min-h-[700px]">
        <!-- Left Side - Branding -->
        <div
            class="w-full lg:w-1/2 bg-[#06283D] relative overflow-hidden flex flex-col justify-end p-8 lg:p-16 min-h-[300px] lg:min-h-[700px]">
            <!-- Background Image -->
            <div class="absolute inset-0 opacity-60">
                <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=600&h=900&fit=crop" alt="Property"
                    class="w-full h-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#06283D] via-[#06283D]/60 to-transparent"></div>

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
                        Start your journey with<br />KostMudah
                    </h2>
                    <p class="text-[#ADCAE5] text-sm lg:text-base mt-3">
                        Join thousands of tenants and property owners<br class="hidden lg:block">
                        managing their spaces with efficiency and trust.
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="w-full lg:w-1/2 p-6 md:p-8 lg:p-16 flex flex-col justify-center">
            <div class="mb-6">
                <h1 class="text-[#191C1D] text-3xl font-bold">Create Account</h1>
                <p class="text-[#42474C] text-base mt-1">Fill in the details to set up your profile.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Registering As (Role Selection) -->
                <div>
                    <label class="block text-[#73777D] text-xs font-semibold tracking-wider uppercase mb-2">REGISTERING
                        AS</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="tenant"
                                {{ old('role', 'tenant') == 'tenant' ? 'checked' : '' }} class="hidden peer">
                            <div
                                class="flex flex-col items-center justify-center p-3 rounded-lg border border-[#C3C7CD] bg-white peer-checked:bg-[#CFE6EF] peer-checked:border-[#06283D] transition-all hover:border-[#06283D]">
                                <svg class="w-5 h-5 text-[#06283D] mb-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="text-[#191C1D] text-xs font-semibold tracking-wide">Tenant</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="owner"
                                {{ old('role') == 'owner' ? 'checked' : '' }} class="hidden peer">
                            <div
                                class="flex flex-col items-center justify-center p-3 rounded-lg border border-[#C3C7CD] bg-white peer-checked:bg-[#CFE6EF] peer-checked:border-[#06283D] transition-all hover:border-[#06283D]">
                                <svg class="w-5 h-5 text-[#42474C] mb-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-[#191C1D] text-xs font-semibold tracking-wide">Owner</span>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Occupation (hanya untuk tenant) -->
                <div id="occupationField" class="{{ old('role', 'tenant') == 'owner' ? 'hidden' : '' }}">
                    <label
                        class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Occupation</label>
                    <input type="text" name="occupation" value="{{ old('occupation') }}"
                        class="w-full px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow text-sm"
                        placeholder="e.g., Student, Employee, Entrepreneur">
                    @error('occupation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender (hanya untuk tenant) -->
                <div id="genderField" class="{{ old('role', 'tenant') == 'owner' ? 'hidden' : '' }}">
                    <label
                        class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Gender</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="L"
                                {{ old('gender') == 'L' ? 'checked' : '' }} class="hidden peer">
                            <div
                                class="flex items-center justify-center p-3 rounded-lg border border-[#C3C7CD] bg-white peer-checked:bg-[#CFE6EF] peer-checked:border-[#06283D] transition-all hover:border-[#06283D]">
                                <svg class="w-5 h-5 text-[#06283D] mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 3a1 1 0 011 1v4a1 1 0 01-1 1m0 0a1 1 0 01-1-1V4a1 1 0 011-1zm0 0h2a3 3 0 013 3v1a3 3 0 01-3 3h-2m-6 0V7a3 3 0 013-3h3m-6 0a3 3 0 00-3 3v3m0 0v9m0-9h6m-6 0h6" />
                                </svg>
                                <span class="text-[#191C1D] text-sm font-semibold">Laki-laki</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="gender" value="P"
                                {{ old('gender') == 'P' ? 'checked' : '' }} class="hidden peer">
                            <div
                                class="flex items-center justify-center p-3 rounded-lg border border-[#C3C7CD] bg-white peer-checked:bg-[#CFE6EF] peer-checked:border-[#06283D] transition-all hover:border-[#06283D]">
                                <svg class="w-5 h-5 text-[#06283D] mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 3a1 1 0 011 1v4a1 1 0 01-1 1m0 0a1 1 0 01-1-1V4a1 1 0 011-1zm0 0h2a3 3 0 013 3v1a3 3 0 01-3 3h-2m-6 0V7a3 3 0 013-3h3m-6 0a3 3 0 00-3 3v3m0 0v9m0-9h6m-6 0h6" />
                                </svg>
                                <span class="text-[#191C1D] text-sm font-semibold">Perempuan</span>
                            </div>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Full
                            Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow text-sm"
                            placeholder="Enter your full name">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Email
                            Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow text-sm"
                            placeholder="example@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Phone
                        Number
                        (WhatsApp)</label>
                    <div class="flex">
                        <div
                            class="flex items-center px-3 py-2.5 bg-[#F2F4F5] border border-r-0 border-[#C3C7CD] rounded-l-lg">
                            <span class="text-[#42474C] text-sm font-medium">+62</span>
                        </div>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="flex-1 px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-r-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow text-sm"
                            placeholder="812 3456 7890">
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label
                            class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" required
                                class="w-full px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow pr-10 text-sm"
                                placeholder="Min. 8 characters">
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#42474C] hover:text-[#191C1D] transition-colors">
                                <svg id="eyeIcon" class="w-4 h-3.5" fill="none" stroke="currentColor"
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

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-[#42474C] text-xs font-semibold tracking-wider uppercase mb-1">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 bg-[#F8FAFB] border border-[#C3C7CD] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#06283D] text-[#191C1D] placeholder:text-[#6B7280] transition-shadow text-sm"
                            placeholder="Confirm your password">
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-3 pt-1">
                    <input type="checkbox" name="terms" id="terms" required
                        class="w-4 h-4 mt-0.5 rounded border-[#C3C7CD] text-[#06283D] focus:ring-[#06283D] focus:ring-offset-0">
                    <label for="terms" class="text-[#42474C] text-sm">
                        I agree to the <a href="#" class="text-[#06283D] hover:underline">Terms of Service</a>
                        and <a href="#" class="text-[#06283D] hover:underline">Privacy Policy</a>.
                    </label>
                </div>
                @error('terms')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 bg-[#06283D] text-white text-base font-semibold rounded-lg hover:bg-[#001220] transition-colors shadow-lg shadow-[#06283D]/20 flex items-center justify-center gap-2">
                    Create Account
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>

                <!-- Login Link -->
                <div class="text-center pt-1">
                    <span class="text-[#42474C] text-sm">Already have an account? </span>
                    <a href="{{ route('login') }}" class="text-[#06283D] text-sm font-semibold hover:underline">
                        Sign In
                    </a>
                </div>
            </form>
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

        // Toggle tenant-specific fields based on role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const occupationField = document.getElementById('occupationField');
            const genderField = document.getElementById('genderField');

            function toggleTenantFields() {
                const selectedRole = document.querySelector('input[name="role"]:checked');
                if (selectedRole && selectedRole.value === 'tenant') {
                    occupationField.classList.remove('hidden');
                    genderField.classList.remove('hidden');
                } else {
                    occupationField.classList.add('hidden');
                    genderField.classList.add('hidden');
                    // Clear values when hidden
                    document.querySelector('input[name="occupation"]').value = '';
                    document.querySelectorAll('input[name="gender"]').forEach(radio => {
                        radio.checked = false;
                    });
                }
            }

            // Initial toggle
            toggleTenantFields();

            // Add event listeners
            roleRadios.forEach(radio => {
                radio.addEventListener('change', toggleTenantFields);
            });
        });
    </script>
</body>

</html>
