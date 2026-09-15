<x-app-layout>
    <x-slot name="header">
        Riwayat Diagnosa
    </x-slot>

    <x-card>
        <div class="flex justify-between items-center mb-6 print:hidden">
            <p class="text-sm text-text-muted">Daftar riwayat diagnosa yang pernah Anda lakukan.</p>
            <button onclick="window.print()" class="px-4 py-2 bg-white border border-border hover:bg-gray-50 text-text-main rounded-xl font-bold transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
            </button>
        </div>

        <!-- Header Khusus Print -->
        <div class="hidden print:block text-center mb-8 border-b-2 border-black pb-4">
            <h1 class="text-2xl font-bold uppercase">Laporan Riwayat Diagnosa</h1>
            <p class="text-sm">Dicetak pada: {{ now()->format('d M Y, H:i') }} | Oleh: {{ auth()->user()->name }}</p>
        </div>

        <div class="overflow-x-auto rounded-xl border border-border">
            <table class="w-full text-left text-sm text-text-main">
                <thead class="bg-bg-light text-text-muted uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-border w-16 text-center">No</th>
                        <th class="px-6 py-4 border-b border-border">Waktu Diagnosa</th>
                        <th class="px-6 py-4 border-b border-border">Hasil Kerusakan Terdeteksi</th>
                        <th class="px-6 py-4 border-b border-border text-center print:hidden">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($diagnosas as $index => $diagnosa)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $diagnosas->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium">{{ $diagnosa->tanggal_diagnosa->format('d M Y') }}</span><br>
                                <span class="text-xs text-text-muted">{{ $diagnosa->tanggal_diagnosa->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold">
                                @if($diagnosa->kerusakan)
                                    <span class="text-danger">{{ $diagnosa->kerusakan->kode_kerusakan }} - {{ $diagnosa->kerusakan->nama_kerusakan }}</span>
                                @else
                                    <span class="text-text-muted">Kerusakan Tidak Ditemukan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap print:hidden">
                                <a href="{{ route('teknisi.riwayat.show', $diagnosa->id) }}">
                                    <x-button variant="outline" class="!py-2 !px-3 !text-xs">
                                        <i class="fa-solid fa-eye mr-2"></i> Detail
                                    </x-button>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-text-muted">
                                Belum ada riwayat diagnosa yang tersimpan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 print:hidden">
            {{ $diagnosas->links() }}
        </div>
    </x-card>

    <!-- Print Styles -->
    <style>
        @media print {
            @page { margin: 1cm; }
            body { background-color: white !important; color: black !important; }
            header, aside, .mobile-menu-overlay, nav { display: none !important; }
            .print\:hidden { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .shadow-sm, .shadow-md { shadow: none !important; }
            .bg-card-bg, .bg-white { background-color: white !important; }
            table { border-collapse: collapse !important; width: 100% !important; }
            th, td { border: 1px solid #000 !important; padding: 8px !important; }
            .text-danger { color: #dc2626 !important; }
        }
    </style>
</x-app-layout>
