@php
    $photos = $kost->photos;
    $primary = $kost->primaryPhoto ?? $photos->first();
@endphp

<div class="grid lg:grid-cols-3 gap-4">

    {{-- Foto Utama --}}
    <div class="lg:col-span-2 relative">

        <img
            id="main-photo"
            src="{{ $primary ? Storage::url($primary->path) : asset('images/no-image.jpg') }}"
            class="w-full h-[500px] object-cover rounded-xl">

        <span
            class="absolute bottom-5 left-5 bg-cyan-950/80 backdrop-blur text-white text-xs px-4 py-2 rounded-full tracking-wider">

            FOTO UTAMA

        </span>

    </div>

    {{-- Thumbnail --}}
    <div class="grid grid-cols-2 gap-4">

        @forelse($photos->take(4) as $photo)

            <img
                src="{{ Storage::url($photo->path) }}"
                class="thumbnail rounded-xl h-60 w-full object-cover cursor-pointer hover:opacity-80 transition">

        @empty

            @for($i = 0; $i < 4; $i++)

                <img
                    src="{{ asset('images/no-image.jpg') }}"
                    class="rounded-xl h-60 w-full object-cover">

            @endfor

        @endforelse

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const mainPhoto = document.getElementById('main-photo');

    document.querySelectorAll('.thumbnail').forEach(function (thumbnail) {

        thumbnail.addEventListener('click', function () {

            mainPhoto.src = this.src;

        });

    });

});
</script>
@endpush