<x-app-layout>
    <x-slot name="header">
        Data Teknisi
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <x-card>
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <form action="{{ route('admin.teknisi.index') }}" method="GET" class="w-full md:w-1/3">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, email..." 
                           class="w-full pl-10 pr-4 py-2 border border-border rounded-xl focus:ring-primary focus:border-primary">
                    <div class="absolute left-3 top-2.5 text-text-muted">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>
            </form>
            
            <a href="{{ route('admin.teknisi.create') }}" class="w-full md:w-auto">
                <x-button variant="primary" class="w-full">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Teknisi
                </x-button>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-border">
            <table class="w-full text-left text-sm text-text-main">
                <thead class="bg-bg-light text-text-muted uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4 border-b border-border w-16">No</th>
                        <th class="px-6 py-4 border-b border-border">Nama Teknisi</th>
                        <th class="px-6 py-4 border-b border-border">Username</th>
                        <th class="px-6 py-4 border-b border-border">Email</th>
                        <th class="px-6 py-4 border-b border-border text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @forelse ($teknisis as $index => $teknisi)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $teknisis->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-primary">{{ $teknisi->name }}</td>
                            <td class="px-6 py-4">{{ $teknisi->username }}</td>
                            <td class="px-6 py-4">{{ $teknisi->email }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.teknisi.edit', $teknisi->id) }}" class="text-accent hover:text-accent-hover mr-3" title="Edit">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </a>
                                <form action="{{ route('admin.teknisi.destroy', $teknisi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun teknisi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:text-red-700" title="Hapus">
                                        <i class="fa-solid fa-trash text-lg"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-text-muted">
                                Tidak ada data teknisi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $teknisis->links() }}
        </div>
    </x-card>
</x-app-layout>
