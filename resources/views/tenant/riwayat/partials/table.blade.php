<div class="bg-white rounded-xl border overflow-hidden">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between p-6 border-b bg-gray-50">

        <h2 class="text-2xl font-semibold text-slate-900">
            Daftar Penyewaan
        </h2>

        <select
            class="mt-4 md:mt-0 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-cyan-900">

            <option>Semua Status</option>
            <option>Active</option>
            <option>Completed</option>
            <option>Pending</option>

        </select>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50">

                <tr class="text-left text-xs uppercase text-gray-500">

                    <th class="p-5">Kost</th>
                    <th class="p-5">Periode</th>
                    <th class="p-5">Biaya/Bulan</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-right">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($rentals as $rental)

                <tr class="border-t hover:bg-slate-50 transition">

                    {{-- Kost --}}
                    <td class="p-5">

                        <div class="flex items-center gap-3">

                            @if($rental->boardingHouse->primaryPhoto)

                                <img
                                    src="{{ asset('storage/'.$rental->boardingHouse->primaryPhoto->photo_path) }}"
                                    class="w-12 h-12 rounded-lg object-cover">

                            @else

                                <div
                                    class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">

                                    <i data-lucide="building-2"
                                       class="w-5 h-5 text-slate-700"></i>

                                </div>

                            @endif

                            <div>

                                <h4 class="font-semibold">

                                    {{ $rental->boardingHouse->name }}

                                </h4>

                                <p class="text-sm text-gray-500">

                                    {{ $rental->boardingHouse->type }}

                                </p>

                            </div>

                        </div>

                    </td>

                    {{-- Periode --}}
                    <td class="p-5">

                        {{ \Carbon\Carbon::parse($rental->start_date)->translatedFormat('d M Y') }}
                        <br>
                        <span class="text-gray-500">

                            s/d

                        </span>
                        <br>

                        {{ \Carbon\Carbon::parse($rental->end_date)->translatedFormat('d M Y') }}

                    </td>

                    {{-- Harga --}}
                    <td class="p-5 font-semibold">

                        Rp {{ number_format($rental->boardingHouse->price,0,',','.') }}

                    </td>

                    {{-- Status --}}
                    <td class="p-5">

                        @php
                            $status = strtolower($rental->status);
                        @endphp

                        @if($status=='active')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                Active
                            </span>

                        @elseif($status=='pending')

                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                Pending
                            </span>

                        @elseif($status=='cancelled')

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                Cancelled
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-bold">
                                Completed
                            </span>

                        @endif

                    </td>

                    {{-- Aksi --}}
                    <td class="p-5 text-right">

                        <a
                            href="{{ route('tenant.invoice.index',$rental) }}"
                            class="inline-flex items-center gap-2 text-cyan-900 font-semibold hover:text-cyan-700">

                            <i data-lucide="receipt-text"
                               class="w-4 h-4"></i>

                            View Invoice

                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-12 text-gray-500">

                        Belum ada riwayat penyewaan.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- Footer --}}
    <div class="flex justify-between items-center p-5 bg-gray-50 border-t">

        <span class="text-gray-500">

            Showing {{ $rentals->count() }} rentals

        </span>

        <div class="flex items-center gap-4">

            <button class="text-gray-400">
                Previous
            </button>

            <span class="font-bold">
                1
            </span>

            <button class="text-gray-400">
                Next
            </button>

        </div>

    </div>

</div>