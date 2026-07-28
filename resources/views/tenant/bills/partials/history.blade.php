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

            @forelse($rentals as $rental)

                <tr class="border-t">

                    <td class="px-6 py-4">
                        {{ $rental->start_date->format('F Y') }}
                    </td>

                    <td class="px-6 py-4">
                        Rp{{ number_format($rental->total_price, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4">

                        @if($rental->status == 'paid')

                            <span class="rounded-full bg-green-100 px-3 py-1 text-green-700 text-sm font-semibold">
                                Lunas
                            </span>

                        @elseif($rental->status == 'pending')

                            <span class="rounded-full bg-red-100 px-3 py-1 text-red-700 text-sm font-semibold">
                                Pending
                            </span>

                        @else

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-gray-700 text-sm font-semibold">
                                {{ ucfirst($rental->status) }}
                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-4 text-right">

                        @if($rental->status == 'paid')

                            <a href="{{ route('tenant.invoice.index', $rental) }}"
                                class="text-cyan-700 font-semibold hover:underline">

                                Detail

                            </a>

                        @else

                            <a href="{{ route('tenant.payment.index', $rental) }}"
                                class="text-cyan-700 font-semibold hover:underline">

                                Bayar

                            </a>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-500">
                        Belum ada riwayat tagihan.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>