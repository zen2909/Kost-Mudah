<!DOCTYPE html>
<html lang="en">

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
    <title>@yield('title', 'Dashboard Admin - KostMudah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <div class="flex min-h-screen bg-gray-50">
        <!-- Sidebar - Fixed -->
        @include('components.admin.sidebar')

        <!-- Main Content -->
        <div id="mainContent" class="flex-1 transition-all duration-300 ease-in-out ml-[263px]">
            @include('components.admin.header')

            <main class="p-6">
                @yield('content')
            </main>

        </div>
    </div>

    <script>
        let isSidebarOpen = true;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleIcon = document.getElementById('toggleIcon');
            const logoContainer = document.getElementById('logoContainer');

            if (!sidebar || !mainContent) return;

            if (isSidebarOpen) {
                // Collapse sidebar
                sidebar.style.width = '72px';
                mainContent.style.marginLeft = '72px';

                if (logoContainer) {
                    logoContainer.style.marginLeft = '0px';
                    logoContainer.style.width = '40px';
                    logoContainer.style.height = '40px';
                    logoContainer.style.padding = '6px';
                    logoContainer.style.borderRadius = '10px';
                }

                document.querySelectorAll('#sidebar .menu-text, #sidebar .logo-text').forEach(el => {
                    if (el) {
                        el.style.width = '0';
                        el.style.margin = '0';
                        el.style.padding = '0';
                        el.style.opacity = '0';
                        el.style.overflow = 'hidden';
                        el.style.minWidth = '0';
                    }
                });

                document.querySelectorAll('#sidebar .group-item > span:last-child').forEach(el => {
                    if (el && !el.classList.contains('hidden')) {
                        el.classList.add('hidden');
                    }
                });

                if (toggleIcon) {
                    toggleIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    `;
                }

                isSidebarOpen = false;
            } else {
                // Expand sidebar
                sidebar.style.width = '263px';
                mainContent.style.marginLeft = '263px';

                if (logoContainer) {
                    logoContainer.style.marginLeft = '0';
                    logoContainer.style.width = '56px';
                    logoContainer.style.height = '56px';
                    logoContainer.style.padding = '8px';
                    logoContainer.style.borderRadius = '12px';
                }

                document.querySelectorAll('#sidebar .menu-text, #sidebar .logo-text').forEach(el => {
                    if (el) {
                        el.style.width = '';
                        el.style.margin = '';
                        el.style.padding = '';
                        el.style.opacity = '1';
                        el.style.overflow = '';
                        el.style.minWidth = '';
                    }
                });

                if (toggleIcon) {
                    toggleIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    `;
                }

                isSidebarOpen = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#sidebar .group-item').forEach(item => {
                if (!item) return;

                item.addEventListener('mouseenter', function(e) {
                    if (!isSidebarOpen) {
                        const tooltip = this.querySelector('span:last-child');
                        if (tooltip && tooltip.classList.contains('hidden')) {
                            tooltip.classList.remove('hidden');
                        }
                    }
                });

                item.addEventListener('mouseleave', function(e) {
                    const tooltip = this.querySelector('span:last-child');
                    if (tooltip) {
                        tooltip.classList.add('hidden');
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
