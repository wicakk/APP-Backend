@props(['visitorStats' => collect(), 'recentVisitors' => collect()])

<div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] sm:p-6">
    <div class="flex justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Visitor Demographic
            </h3>
            <p class="mt-1 text-theme-sm text-gray-500 dark:text-gray-400">
                Pengunjung berdasarkan negara
            </p>
        </div>
    </div>

    <div class="border-gray-200 my-6 overflow-hidden rounded-2xl border bg-gray-50 px-4 py-6 dark:border-gray-800 dark:bg-gray-900 sm:px-6">
        <div id="mapOne" class="mapOne map-btn -mx-4 -my-6 h-[212px] w-[252px] 2xsm:w-[307px] xsm:w-[358px] sm:-mx-6 md:w-[668px] lg:w-[634px] xl:w-[393px] 2xl:w-[554px]"></div>
    </div>

    <!-- Statistik per negara -->
    <div class="space-y-5">
        @php
            $totalVisitors = $visitorStats->sum('total');
        @endphp
        @forelse($visitorStats as $stat)
            @php
                $percentage = $totalVisitors > 0 ? round(($stat->total / $totalVisitors) * 100) : 0;
            @endphp
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-xs font-bold text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ $stat->country_code ?? '?' }}
                    </div>
                    <div>
                        <p class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                            {{ $stat->country }}
                        </p>
                        <span class="block text-theme-xs text-gray-500 dark:text-gray-400">
                            {{ $stat->total }} Pengunjung
                        </span>
                    </div>
                </div>

                <div class="flex w-full max-w-[140px] items-center gap-3">
                    <div class="relative block h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-800">
                        <div
                            class="absolute left-0 top-0 flex h-full items-center justify-center rounded-sm bg-brand-500 text-xs font-medium text-white"
                            style="width: {{ $percentage }}%"
                        ></div>
                    </div>
                    <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                        {{ $percentage }}%
                    </p>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400">Belum ada data pengunjung.</p>
        @endforelse
    </div>

    <!-- IP List -->
    <div class="mt-6 border-t border-gray-200 pt-4 dark:border-gray-700">
        <h4 class="mb-3 text-sm font-semibold text-gray-800 dark:text-white/90">IP Pengunjung Terbaru</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-500 dark:text-gray-400">
                        <th class="pb-2 font-medium">IP Address</th>
                        <th class="pb-2 font-medium">Lokasi</th>
                        <th class="pb-2 font-medium">Waktu</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @forelse($recentVisitors as $visitor)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="py-2 font-mono text-xs">{{ $visitor->ip_address }}</td>
                        <td class="py-2 text-xs">{{ $visitor->city ? $visitor->city . ', ' : '' }}{{ $visitor->country }}</td>
                        <td class="py-2 text-xs">{{ $visitor->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-2 text-gray-400">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recentVisitors instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentVisitors->hasPages())
        <div class="mt-4">
            {{ $recentVisitors->links() }}
        </div>
        @endif
    </div>
</div>
