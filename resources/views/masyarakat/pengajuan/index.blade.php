<x-public-layout>
    @section('title', 'Layanan Surat & Riwayat')

    <div class="py-12 bg-white dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Welcome Header --}}
            <div class="mb-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        @php
                            $displayName = Auth::user()->biodata->nama_lengkap ?? Auth::user()->name;
                            $firstName = explode(' ', $displayName)[0];
                        @endphp
                        <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Halo,
                            {{ $firstName }}! 👋</h1>
                        <p class="mt-2 text-gray-500 dark:text-gray-400 font-medium">Selamat datang di portal layanan
                            mandiri Desa Kami.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="px-4 py-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl">
                            <span
                                class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest block leading-none mb-1">Status
                                Identitas</span>
                            <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                @if (Auth::user()->biodata && Auth::user()->biodata->verification_status === 'verified')
                                    Terverifikasi ✅
                                @else
                                    Belum Verifikasi ⚠️
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Section: Services & Stats --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">

                {{-- Left: Available services --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2
                            class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-l-4 border-blue-600 pl-4">
                            Layanan Pengajuan Surat</h2>
                        <span class="text-xs font-bold text-gray-400">{{ $layanan->count() }} Pilihan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($layanan as $item)
                            <a href="{{ route('masyarakat.pengajuan.create', $item->kode) }}"
                                class="group p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 flex flex-col justify-between overflow-hidden relative">
                                <div
                                    class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-full blur-2xl group-hover:bg-blue-100 dark:group-hover:bg-blue-900/20 transition-colors">
                                </div>

                                <div>
                                    <div
                                        class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-4 shadow-lg shadow-blue-200 dark:shadow-none transition-transform group-hover:scale-110">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-black text-gray-900 dark:text-white mb-2">
                                        {{ $item->nama }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                        {{ $item->deskripsi ?? 'Ajukan surat ' . strtolower($item->nama) . ' secara digital.' }}
                                    </p>
                                </div>

                                <div class="mt-6 flex items-center justify-between">
                                    <span
                                        class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded-md">Estimasi
                                        {{ $item->sla_hari }} Hari</span>
                                    <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Quick Stats & Active --}}
                <div class="space-y-6">
                    <h2
                        class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight border-l-4 border-amber-500 pl-4">
                        Status Aktif</h2>

                    @if ($activeSubmissions->count() > 0)
                        <div class="space-y-3">
                            @foreach ($activeSubmissions as $sub)
                                <div
                                    class="p-4 bg-amber-50/50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30 rounded-2xl group transition-all hover:bg-amber-50 dark:hover:bg-amber-900/20">
                                    <div class="flex justify-between items-start mb-2">
                                        <span
                                            class="text-[9px] font-black text-amber-600 dark:text-amber-500 uppercase tracking-widest">{{ $sub->kode_pengajuan }}</span>
                                        @php
                                            $subColor = 'bg-amber-100 text-amber-700';
                                            if ($sub->status === 'in_process') {
                                                $subColor = 'bg-blue-100 text-blue-700';
                                            }
                                            if ($sub->status === 'need_revision') {
                                                $subColor = 'bg-red-100 text-red-700';
                                            }
                                            if ($sub->status === 'validated') {
                                                $subColor = 'bg-sky-100 text-sky-700';
                                            }
                                            if ($sub->status === 'approved') {
                                                $subColor = 'bg-green-100 text-green-700';
                                            }
                                        @endphp
                                        <span
                                            class="px-2 py-0.5 {{ $subColor }} rounded-md text-[9px] font-black uppercase tracking-wider">
                                            {{ str_replace('_', ' ', $sub->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        {{ $sub->jenisSurat->nama }}</p>
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Diupdate
                                        {{ $sub->updated_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="p-10 bg-gray-50 dark:bg-gray-900 border border-dashed border-gray-200 dark:border-gray-800 rounded-3xl text-center">
                            <div
                                class="w-12 h-12 bg-white dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-gray-400 italic">Belum ada pengajuan aktif</p>
                        </div>
                    @endif

                    {{-- Quick Action --}}
                    <div
                        class="p-6 bg-gradient-to-br from-indigo-600 to-blue-700 rounded-3xl text-white shadow-xl shadow-blue-500/20">
                        <h4 class="text-sm font-black uppercase tracking-wider mb-2">Butuh Bantuan?</h4>
                        <p class="text-xs text-blue-100 leading-relaxed mb-4">Jika Anda mengalami kendala saat melakukan
                            pengajuan, hubungi Admin melalui WhatsApp.</p>
                        <a href="#"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl text-xs font-bold transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                            CS Portal
                        </a>
                    </div>
                </div>
            </div>

            {{-- History Section --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Riwayat
                        Pengajuan Surat</h2>
                    <div
                        class="flex items-center gap-2 px-3 py-1 bg-gray-100 dark:bg-gray-800 rounded-lg text-gray-500 text-xs font-bold">
                        Total {{ $submissions->total() }} Data
                    </div>
                </div>

                <div class="overflow-x-auto shadow-sm rounded-3xl border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-5">Kode / Tanggal</th>
                                <th class="px-6 py-5">Jenis Surat</th>
                                <th class="px-6 py-5">Skor / Rank</th>
                                <th class="px-6 py-5">Status</th>
                                <th class="px-6 py-5">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($submissions as $s)
                                <tr
                                    class="bg-white dark:bg-gray-900 group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="text-blue-600 dark:text-blue-400 font-black tracking-tight mb-1">
                                            {{ $s->kode_pengajuan }}</div>
                                        <div class="text-[10px] text-gray-400 font-bold uppercase">
                                            {{ $s->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $s->jenisSurat->nama }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium truncate max-w-[200px]">
                                            {{ $s->keperluan }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-lg text-xs font-black">
                                            {{ number_format($s->priority_score, 1) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        @php
                                            $statuses = [
                                                'submitted' => ['bg-amber-100/50 text-amber-700', 'Menunggu Antrian'],
                                                'queued' => ['bg-blue-100/50 text-blue-700', 'Dalam Antrian'],
                                                'in_process' => ['bg-indigo-100/50 text-indigo-700', 'Sedang Diproses'],
                                                'need_revision' => ['bg-red-100/50 text-red-700', 'Perlu Revisi'],
                                                'validated' => ['bg-sky-100/50 text-sky-700', 'Menunggu TTD Kades'],
                                                'approved' => ['bg-green-100/50 text-green-700', 'Disetujui Kades'],
                                                'ready' => ['bg-teal-100/50 text-teal-700', 'Surat Siap Diunduh'],
                                                'rejected' => ['bg-gray-700 text-white', 'Ditolak'],
                                            ];
                                            $currentStatus = $statuses[$s->status] ?? [
                                                'bg-gray-100 text-gray-600',
                                                $s->status,
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex px-3 py-1 {{ $currentStatus[0] }} rounded-full text-[10px] font-black uppercase tracking-wider">
                                            {{ $currentStatus[1] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            @if ($s->status === 'need_revision')
                                                <a href="{{ route('masyarakat.pengajuan.edit', $s->kode_pengajuan) }}"
                                                    class="inline-flex items-center justify-center p-2 bg-amber-100 dark:bg-amber-900/40 hover:bg-amber-500 hover:text-white text-amber-600 dark:text-amber-400 rounded-xl transition-all"
                                                    title="Revisi Pengajuan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('masyarakat.pengajuan.show', $s->kode_pengajuan) }}"
                                                class="inline-flex items-center justify-center p-2 bg-gray-100 dark:bg-gray-800 hover:bg-blue-600 hover:text-white text-gray-500 dark:text-gray-400 rounded-xl transition-all"
                                                title="Detail Pengajuan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="max-w-xs mx-auto">
                                            <div
                                                class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-4 text-gray-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h3
                                                class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                                Belum Ada Riwayat</h3>
                                            <p class="text-[10px] text-gray-500 font-medium mt-1 leading-relaxed">Anda
                                                belum pernah melakukan pengajuan surat. Silakan pilih layanan di atas
                                                untuk memulai.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $submissions->links() }}
                </div>
            </div>

        </div>
    </div>
</x-public-layout>
