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
            <option>Menunggu Pembayaran</option>

        </select>

    </div>

    @php

        $riwayat = [

            [
                'nama'=>'Kost Mentari Pagi',
                'kamar'=>'Kamar 204 • Lantai 2',
                'periode'=>'Jan 2024 - Present',
                'harga'=>'Rp 2.100.000',
                'status'=>'Active'
            ],

            [
                'nama'=>'Kost Abadi Jaya',
                'kamar'=>'Kamar 101 • Lantai 1',
                'periode'=>'Jun 2023 - Des 2023',
                'harga'=>'Rp 1.850.000',
                'status'=>'Completed'
            ],

            [
                'nama'=>'Kost Hijau Asri',
                'kamar'=>'Kamar 05 • Paviliun',
                'periode'=>'Jan 2023 - Mei 2023',
                'harga'=>'Rp 2.500.000',
                'status'=>'Completed'
            ],

        ];

    @endphp

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

            @foreach($riwayat as $item)

                <tr class="border-t hover:bg-slate-50 hover:shadow-sm transition-all duration-200">

                    <td class="p-5">

                        <div class="flex items-center gap-3">

                            <div
                                class="w-10 h-10 rounded bg-slate-100 flex items-center justify-center">

                                <i data-lucide="building-2"
                                    class="w-5 h-5 text-slate-700"></i>

                            </div>

                            <div>

                                <h4 class="font-semibold">

                                    {{ $item['nama'] }}

                                </h4>

                                <p class="text-sm text-gray-500">

                                    {{ $item['kamar'] }}

                                </p>

                            </div>

                        </div>

                    </td>

                    <td class="p-5">

                        {{ $item['periode'] }}

                    </td>

                    <td class="p-5 font-semibold">

                        {{ $item['harga'] }}

                    </td>

                    <td class="p-5">

                        @switch($item['status'])

                        @case('Active')

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                        Active
                        </span>

                        @break

                        @case('Pending')

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                        Pending
                        </span>

                        @break

                        @case('Cancelled')

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                        Cancelled
                        </span>

                        @break

                        @default

                        <span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-bold">
                        Completed
                        </span>

                        @endswitch

                    </td>

                    <td class="p-5 text-right">

                        <a
                            href="#"
                            class="inline-flex items-center gap-2 text-cyan-900 font-semibold hover:text-cyan-700 transition">

                            <i data-lucide="receipt-text"
                            class="w-4 h-4"></i>

                            View Invoice

                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

    {{-- Footer --}}

    <div
        class="flex justify-between items-center p-5 bg-gray-50 border-t">

        <span class="text-gray-500">

            Showing 3 of 3 rentals

        </span>

        <div class="flex items-center gap-4">

            <button
                class="text-gray-400">

                Previous

            </button>

            <span class="font-bold">

                1

            </span>

            <button
                class="text-gray-400">

                Next

            </button>

        </div>

    </div>

</div>