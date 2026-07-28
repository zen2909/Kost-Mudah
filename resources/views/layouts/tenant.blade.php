<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Dashboard Tenant - KostMudah')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('components.tenant.sidebar')

    {{-- Main --}}
    <div id="mainContent"
         class="flex-1 ml-[263px] transition-all duration-300 ease-in-out">

        {{-- Header --}}
        @include('components.tenant.header')

        {{-- Content --}}
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function initFavoriteButtons() {

        document.querySelectorAll('.favorite-btn').forEach(button => {

            if (button.dataset.initialized) return;
            button.dataset.initialized = "true";

            button.addEventListener('click', function (e) {

                e.preventDefault();

                const id = this.dataset.id;
                const icon = this.querySelector('.favorite-icon');

                fetch(`/tenant/favorite/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    if (!data.success) return;

                    if (data.favorited) {

                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-red-600', 'fill-red-600');
                        icon.setAttribute('fill', 'currentColor');

                    } else {

                        icon.classList.remove('text-red-600', 'fill-red-600');
                        icon.classList.add('text-gray-400');
                        icon.setAttribute('fill', 'none');

                    }

                    // Jika sedang di halaman Favorit dan kost dihapus,
                    // hilangkan card tanpa reload.
                    if (!data.favorited) {

                        const favoriteCard = button.closest('.favorite-card');

                        if (favoriteCard) {
                            favoriteCard.remove();

                            if (document.querySelectorAll('.favorite-card').length === 0) {
                                location.reload();
                            }
                        }
                    }

                })
                .catch(error => console.error(error));

            });

        });

    }

    initFavoriteButtons();

});
</script>
@stack('scripts')

</body>
</html>