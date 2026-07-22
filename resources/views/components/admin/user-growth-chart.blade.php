@props([
    'quarters' => ['Q1', 'Q2', 'Q3', 'Q4'],
    'ownerGrowth' => [],
    'tenantGrowth' => [],
])

<div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-[#191C1D] text-xl font-semibold">Pertumbuhan Pengguna</h3>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 bg-[#004B72] rounded-full"></div>
                <span class="text-[#42474C] text-xs font-bold tracking-wide">Owner</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 bg-[#94A3B8] rounded-full"></div>
                <span class="text-[#42474C] text-xs font-bold tracking-wide">Tenant</span>
            </div>
        </div>
    </div>
    <div class="h-72 relative">
        <div class="w-full h-full flex items-end justify-between px-4">
            <div class="w-full">
                <div class="flex items-end justify-between h-64 relative">
                    @php
                        $maxVal = max(array_merge($ownerGrowth, $tenantGrowth, [1]));
                    @endphp
                    @foreach (range(0, 3) as $i)
                        @php
                            $ownerH =
                                isset($ownerGrowth[$i]) && $ownerGrowth[$i] > 0
                                    ? round(($ownerGrowth[$i] / $maxVal) * 180)
                                    : 4;
                            $tenantH =
                                isset($tenantGrowth[$i]) && $tenantGrowth[$i] > 0
                                    ? round(($tenantGrowth[$i] / $maxVal) * 180)
                                    : 4;
                            $ownerVal = isset($ownerGrowth[$i]) ? round($ownerGrowth[$i] / 5) : 0;
                            $tenantVal = isset($tenantGrowth[$i]) ? round($tenantGrowth[$i] / 5) : 0;
                            $quarterLabel = isset($quarters[$i]) ? $quarters[$i] : 'Q' . ($i + 1);
                        @endphp
                        <div class="flex flex-col items-center w-full relative group">
                            <!-- Tooltip -->
                            <div
                                class="absolute bottom-full mb-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-[#001220] text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap pointer-events-none">
                                <div class="font-semibold">{{ $quarterLabel }}</div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="w-2 h-2 bg-[#004B72] rounded-full inline-block"></span>
                                    <span>Owner: {{ $ownerVal }} pengguna</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-[#94A3B8] rounded-full inline-block"></span>
                                    <span>Tenant: {{ $tenantVal }} pengguna</span>
                                </div>
                                <div
                                    class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-full border-4 border-transparent border-t-[#001220]">
                                </div>
                            </div>
                            <!-- Bars -->
                            <div class="w-full flex flex-col items-center gap-1">
                                <div class="w-12 bg-[#004B72] rounded-t-sm transition-all duration-300 hover:opacity-80"
                                    style="height: {{ $ownerH }}px; min-height: 4px;"></div>
                                <div class="w-12 bg-[#94A3B8] rounded-t-sm transition-all duration-300 hover:opacity-80"
                                    style="height: {{ $tenantH }}px; min-height: 4px;"></div>
                            </div>
                            <span class="text-[#42474C] text-xs font-semibold uppercase mt-2">{{ $quarterLabel }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Y-Axis Label -->
        <div
            class="absolute -left-8 top-1/2 -translate-y-1/2 -rotate-90 text-[#42474C] text-xs font-medium tracking-wide">
            Jumlah Pengguna
        </div>
        <!-- X-Axis Label -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-[#42474C] text-xs font-medium tracking-wide mt-8">
            Kuartal
        </div>
    </div>
</div>
