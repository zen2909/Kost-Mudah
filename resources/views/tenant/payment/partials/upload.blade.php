<div class="px-6 pb-6">

    <h3 class="text-2xl font-bold text-cyan-950 mb-4">
        Bukti Transfer
    </h3>

    <label
        for="proof"
        class="border-2 border-dashed border-gray-300 rounded-xl p-10 flex flex-col items-center cursor-pointer hover:border-cyan-900 transition">

        <i data-lucide="upload-cloud"
           class="w-16 h-16 text-gray-400 mb-4"></i>

        <h4 class="text-2xl font-semibold text-slate-900">
            Klik atau Seret File ke Sini
        </h4>

        <p class="text-gray-500 mt-2">
            PNG, JPG, JPEG atau PDF (Maks. 5 MB)
        </p>

        <span
            class="mt-6 bg-cyan-950 text-white px-8 py-3 rounded-lg font-semibold">
            Pilih File
        </span>

        <input
            id="proof"
            name="proof"
            type="file"
            class="hidden"
            accept=".png,.jpg,.jpeg,.pdf"
            onchange="previewFile(event)">
    </label>

    <div class="mt-6 flex justify-center">

        <img
            id="previewImage"
            class="hidden rounded-xl border max-h-80">

        <embed
            id="previewPdf"
            type="application/pdf"
            class="hidden w-full h-96 rounded-xl border">

    </div>

    <p
        id="fileName"
        class="hidden mt-4 text-center text-gray-600 font-medium">
    </p>

</div>