{{-- Notifikasi --}}
@if(session('success'))

<div
    class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">

    {{ session('success') }}

</div>

@endif

@if ($errors->any())

<div
    class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">

    <p class="font-semibold text-red-700 mb-2">
        Terjadi kesalahan:
    </p>

    <ul class="list-disc list-inside text-red-600">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<div class="flex justify-end mt-8">

    <button
        type="submit"
        class="bg-slate-950 hover:bg-slate-800 transition text-white px-8 py-3 rounded-lg flex items-center gap-2">

        <i data-lucide="save" class="w-5 h-5"></i>

        Simpan Perubahan

    </button>

</div>