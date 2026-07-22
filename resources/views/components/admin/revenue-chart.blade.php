@props(['year', 'previousYear', 'monthlyRevenue', 'monthlyRevenuePrev', 'maxRevenue', 'chartMaxHeight' => 180])

<div class="bg-white p-6 rounded-xl border border-[#C3C7CD] shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-[#191C1D] text-xl font-semibold">Pertumbuhan Pendapatan</h3>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 bg-[#06283D] rounded-full"></div>
                <span class="text-[#42474C] text-xs font-bold tracking-wide">{{ $year }}</span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-3 h-3 bg-[#94A3B8] rounded-full"></div>
                <span class="text-[#42474C] text-xs font-bold tracking-wide">{{ $previousYear }}</span>
            </div>
        </div>
    </div>
    <div class="h-72 relative">
        <div class="flex items-end justify-between h-64 px-2">
            <div class="w-full flex items-end justify-between relative">
                @php
                    $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
                    $maxVal = $maxRevenue > 0 ? $maxRevenue : 1;
                @endphp
                @foreach (range(0, 11) as $i)
                    @php
                        $heightCurrent =
                            isset($monthlyRevenue[$i]) && $monthlyRevenue[$i] > 0
                                ? round(($monthlyRevenue[$i] / $maxVal) * $chartMaxHeight)
                                : 4;
                        $heightPrev =
                            isset($monthlyRevenuePrev[$i]) && $monthlyRevenuePrev[$i] > 0
                                ? round(($monthlyRevenuePrev[$i] / $maxVal) * $chartMaxHeight)
                                : 4;
                        $currentVal = isset($monthlyRevenue[$i]) ? $monthlyRevenue[$i] : 0;
                        $prevVal = isset($monthlyRevenuePrev[$i]) ? $monthlyRevenuePrev[$i] : 0;
                    @endphp
                    <div class="flex flex-col items-center w-full relative group">
                        <!-- Tooltip -->
                        <div
                            class="absolute bottom-full mb-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-[#001220] text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap pointer-events-none">
                            <div class="font-semibold">{{ $months[$i] }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-2 h-2 bg-[#06283D] rounded-full inline-block"></span>
                                <span>{{ $year }}: Rp {{ number_format($currentVal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-[#94A3B8] rounded-full inline-block"></span>
                                <span>{{ $previousYear }}: Rp {{ number_format($prevVal, 0, ',', '.') }}</span>
                            </div>
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-full border-4 border-transparent border-t-[#001220]">
                            </div>
                        </div>
                        <!-- Bars -->
                        <div class="flex flex-col items-center gap-1 w-full">
                            <div class="w-6 bg-[#94A3B8] rounded-t-sm transition-all duration-300 hover:opacity-80"
                                style="height: {{ $heightPrev }}px; min-height: 4px;"></div>
                            <div class="w-6 bg-[#06283D] rounded-t-sm transition-all duration-300 hover:opacity-80"
                                style="height: {{ $heightCurrent }}px; min-height: 4px;"></div>
                        </div>
                        <span class="text-[#42474C] text-xs font-semibold uppercase mt-2">{{ $months[$i] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Y-Axis Label -->
        <div
            class="absolute -left-6 top-1/2 -translate-y-1/2 -rotate-90 text-[#42474C] text-xs font-medium tracking-wide">
            Pendapatan (Rp)
        </div>
        <!-- X-Axis Label -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 text-[#42474C] text-xs font-medium tracking-wide mt-8">
            Bulan
        </div>
    </div>
</div>
