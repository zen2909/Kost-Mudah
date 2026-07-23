<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-semibold">

            Riwayat Tagihan

        </h2>

    </div>

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="text-left px-6 py-3">Periode</th>

                <th class="text-left px-6 py-3">Total</th>

                <th class="text-left px-6 py-3">Status</th>

                <th class="text-right px-6 py-3">Aksi</th>

            </tr>

        </thead>

        <tbody>

            <tr class="border-t">

                <td class="px-6 py-4">Juni 2026</td>

                <td class="px-6 py-4">Rp2.500.000</td>

                <td class="px-6 py-4">

                    <span class="rounded-full bg-green-100 px-3 py-1 text-green-700 text-sm font-semibold">

                        Lunas

                    </span>

                </td>

                <td class="px-6 py-4 text-right">

                    <a href="{{ route('tenant.invoice.index') }}"
                        class="text-cyan-700 font-semibold">

                        Detail

                    </a>

                </td>

            </tr>

            <tr class="border-t">

                <td class="px-6 py-4">Mei 2026</td>

                <td class="px-6 py-4">Rp2.500.000</td>

                <td class="px-6 py-4">

                    <span class="rounded-full bg-green-100 px-3 py-1 text-green-700 text-sm font-semibold">

                        Lunas

                    </span>

                </td>

                <td class="px-6 py-4 text-right">

                    <a href="{{ route('tenant.invoice.index') }}"
                        class="text-cyan-700 font-semibold">

                        Detail

                    </a>

                </td>

            </tr>

        </tbody>

    </table>

</div>