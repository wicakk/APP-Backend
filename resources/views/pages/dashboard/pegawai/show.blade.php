@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        {{-- TOP SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- PROFILE CARD --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-xl bg-blue-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($pegawai->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                            {{ $pegawai->name }}
                        </h2>
                        <p class="text-gray-500 text-sm">{{ $pegawai->email }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded">
                                NIP: {{ $pegawai->nip }}
                            </span>
                            <span class="text-xs text-blue-600">
                                Bergabung {{ $pegawai->tanggal_masuk ? \Carbon\Carbon::parse($pegawai->tanggal_masuk)->translatedFormat('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- INFO TAMBAHAN --}}
                <div class="mt-4 space-y-1 text-sm text-gray-600 dark:text-gray-300">
                    <p><span class="font-medium">No HP:</span> {{ $pegawai->no_hp ?? '-' }}</p>
                    <p><span class="font-medium">Jabatan:</span> {{ $pegawai->jabatan->nama_jabatan ?? '-' }}</p>
                    <p><span class="font-medium">Departemen:</span> {{ $pegawai->departemen->nama_departemen ?? '-' }}</p>
                    <p><span class="font-medium">Status:</span>
                        <span class="px-2 py-0.5 rounded text-xs font-semibold
                            {{ $pegawai->status_pegawai === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($pegawai->status_pegawai) }}
                        </span>
                    </p>
                </div>

                <div class="flex gap-3 mt-6">
                    <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                       class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-lg text-sm">
                        Edit
                    </a>
                    <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>

            {{-- FILTER CARD --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Filter Tanggal
                </h3>

                <form method="GET" action="{{ route('pegawai.show', $pegawai->id) }}">
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Dari</label>
                            <input type="date" name="from" value="{{ request('from') }}"
                                   class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">Sampai</label>
                            <input type="date" name="to" value="{{ request('to') }}"
                                   class="w-full mt-1 px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-sm">
                            Terapkan Filter
                        </button>

                        @if(request('from') || request('to'))
                        <a href="{{ route('pegawai.show', $pegawai->id) }}"
                           class="block text-center text-sm text-gray-500 hover:text-red-500 mt-1">
                            Reset Filter
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Total Presensi</p>
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Hadir</p>
                    <h2 class="text-3xl font-bold text-green-600">{{ $hadir }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Tidak Hadir</p>
                    <h2 class="text-3xl font-bold text-red-600">{{ $tidak_hadir }}</h2>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                    <p class="text-sm text-gray-500">Persentase Hadir</p>
                    <h2 class="text-3xl font-bold text-blue-600">{{ $persentase }}%</h2>
                </div>

            </div>
        </div>

        {{-- BOTTOM SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- GRAFIK HARIAN --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Grafik Kehadiran Harian
                </h3>
                <canvas id="attendanceChart" height="120"></canvas>
            </div>

            {{-- RINGKASAN --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 dark:text-white mb-4">
                    Ringkasan Kehadiran
                </h3>
                <canvas id="summaryChart" height="120"></canvas>
            </div>

        </div>
    </div>
</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#d1d5db' : '#374151';

    // Grafik Kehadiran Harian
    const ctx = document.getElementById('attendanceChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Jumlah Hadir',
                data: {!! json_encode($chartData) !!},
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#3b82f6',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: textColor } }
            },
            scales: {
                x: { ticks: { color: textColor } },
                y: {
                    ticks: { color: textColor, stepSize: 1 },
                    beginAtZero: true
                }
            }
        }
    });

    // Grafik Ringkasan
    const summary = document.getElementById('summaryChart');
    new Chart(summary, {
        type: 'bar',
        data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $hadir }}, {{ $tidak_hadir }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { color: textColor } },
                y: {
                    ticks: { color: textColor, stepSize: 1 },
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection