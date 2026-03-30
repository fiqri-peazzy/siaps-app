<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-y-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard Panel Admin') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Selamat datang kembali, <span
                    class="font-bold text-blue-600 dark:text-blue-400">{{ Auth::user()->name }}</span>. Berikut adalah
                ringkasan aktivitas hari ini.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Penduduk -->
            <div
                class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-xl group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-2xl text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total
                            Penduduk</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white">
                            {{ number_format($stats['total_penduduk']) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-tighter cursor-pointer hover:underline"
                    onclick="window.location='{{ route('admin.master.penduduk.index') }}'">
                    Lihat Selengkapnya &rarr;
                </div>
            </div>

            <!-- Pending Validasi Biodata -->
            <div
                class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-xl group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-amber-500/5 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-2xl text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending
                            Validasi</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white">
                            {{ number_format($stats['pending_validasi']) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-tighter cursor-pointer hover:underline"
                    onclick="window.location='{{ route('admin.biodata-validation.index') }}'">
                    Mulai Verifikasi &rarr;
                </div>
            </div>

            <!-- Pengajuan Masuk -->
            <div
                class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-xl group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-red-500/5 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-2xl text-red-600 dark:text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Antrian
                            Surat</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white">
                            {{ number_format($stats['pending_pengajuan']) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-tighter cursor-pointer hover:underline"
                    onclick="window.location='{{ route('admin.pengajuan.index') }}'">
                    Proses Sekarang &rarr;
                </div>
            </div>

            <!-- Menunggu TTD Kades -->
            <div
                class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-all hover:shadow-xl group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="flex items-center gap-4">
                    <div
                        class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Menunggu TTD</p>
                        <h3 class="text-3xl font-black text-gray-900 dark:text-white">
                            {{ number_format($stats['kades_approval']) }}</h3>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter cursor-pointer hover:underline"
                    onclick="window.location='{{ route('admin.kades.index') }}'">
                    Approval Kades &rarr;
                </div>
            </div>
        </div>

        <!-- Charts & Activity Split -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Submission Trend Chart -->
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Tren
                            Pengajuan Selesai</h3>
                        <p class="text-sm text-gray-500">Aktivitas approval surat 7 hari terakhir.</p>
                    </div>
                    <div
                        class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900 px-4 py-2 rounded-xl border border-gray-100 dark:border-gray-700">
                        <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                        <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Surat Terbit</span>
                    </div>
                </div>
                <div class="h-[300px]">
                    <canvas id="submissionTrendChart"></canvas>
                </div>
            </div>

            <!-- Summary & Actions -->
            <div class="space-y-6">
                <!-- Summary Month -->
                <div
                    class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl shadow-blue-500/20 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-blue-100 text-xs font-black uppercase tracking-widest mb-1">Peforma Bulan Ini</p>
                        <h4 class="text-4xl font-black mb-4">{{ $stats['completed_month'] }} <span
                                class="text-lg font-normal text-blue-200">Surat Terbit</span></h4>
                        <div
                            class="flex items-center gap-2 text-sm text-blue-100 bg-white/10 w-fit px-3 py-1 rounded-full backdrop-blur-md">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $stats['completed_today'] }} Selesai Hari Ini</span>
                        </div>
                    </div>
                    <svg class="absolute -bottom-10 -right-10 w-48 h-48 text-white/5" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                    </svg>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider mb-4 px-2">Aksi
                        Cepat</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.cms.informasi.create') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all border border-transparent hover:border-blue-200 group">
                            <div
                                class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-2 group-hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400 text-center">TULIS
                                BERITA</span>
                        </a>
                        <a href="{{ route('admin.master.penduduk.index') }}"
                            class="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all border border-transparent hover:border-blue-200 group">
                            <div
                                class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm mb-2 group-hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-[10px] font-bold text-gray-600 dark:text-gray-400 text-center">WARGA
                                BARU</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div
                class="p-6 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/50">
                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">Aktivitas
                    Terakhir</h3>
                <a href="{{ route('admin.pengajuan.index') }}"
                    class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline hover:scale-105 transition-transform">LIHAT
                    SEMUA &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="text-[10px] text-gray-400 uppercase tracking-widest border-b border-gray-50 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4 font-bold">Waktu</th>
                            <th class="px-6 py-4 font-bold">Pemohon</th>
                            <th class="px-6 py-4 font-bold">Jenis Surat</th>
                            <th class="px-6 py-4 font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @foreach ($recentSubmissions as $sub)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors">
                                <td class="px-6 py-4 text-xs text-gray-500">{{ $sub->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white text-sm">
                                    {{ $sub->biodata->nama_lengkap ?? $sub->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full text-[10px] font-black uppercase border border-blue-100 dark:border-blue-800">
                                        {{ $sub->jenisSurat->kode }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = [
                                            'submitted' => 'bg-amber-100 text-amber-700',
                                            'validated' => 'bg-blue-100 text-blue-700',
                                            'approved' => 'bg-emerald-100 text-emerald-700',
                                            'ready' => 'bg-emerald-100 text-emerald-700',
                                            'completed' => 'bg-indigo-100 text-indigo-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $statusColor[$sub->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('submissionTrendChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($days) !!},
                    datasets: [{
                        label: 'Surat Selesai',
                        data: {!! json_encode($chartData) !!},
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 6,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
