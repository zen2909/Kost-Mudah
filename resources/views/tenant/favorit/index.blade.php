@extends('layouts.tenant')

@section('search-placeholder','Favorit Saya')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-slate-900">
        Kost Favorit Saya
    </h1>

    <p class="text-gray-600 mt-2">
        Daftar kost yang telah Anda simpan.
    </p>

</div>

@if($favorites->isEmpty())

<div class="bg-white rounded-xl shadow-sm border p-10 text-center">

    <div class="text-6xl mb-4">
        🤍
    </div>

    <h2 class="text-2xl font-bold text-slate-800">
        Belum Ada Favorit
    </h2>

    <p class="text-gray-500 mt-2">
        Tambahkan kost favorit agar lebih mudah ditemukan kembali.
    </p>

    <a href="{{ route('tenant.kost.index') }}"
       class="inline-block mt-6 bg-cyan-900 text-white px-6 py-3 rounded-lg">
        Cari Kost
    </a>

</div>

@else

<div class="grid lg:grid-cols-3 md:grid-cols-2 gap-6">

    @foreach($favorites as $favorite)

        <div class="favorite-card">

            @include('tenant.kost.card',[
                'kost' => $favorite->boardingHouse
            ])

        </div>

    @endforeach

</div>

@endif

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.favorite-btn').forEach(button => {

        button.addEventListener('click', function () {

            const id = this.dataset.id;
            const card = this.closest('.favorite-card');

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

                if (data.success) {

                    if (card) {
                        card.remove();
                    }

                    if (document.querySelectorAll('.favorite-card').length === 0) {
                        location.reload();
                    }

                }

            })
            .catch(error => {
                console.error(error);
            });

        });

    });

});
</script>
@endpush