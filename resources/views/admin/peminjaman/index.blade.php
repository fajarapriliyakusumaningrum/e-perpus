@extends('layouts.admin')

@section('title', 'Data Peminjaman')
@section('page_heading', 'Manajemen Peminjaman Buku')

@section('content')
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- SEARCH -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="w-full sm:w-72 relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam/judul buku..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
        </form>
    </div>

    <!-- TABLE PEMINJAMAN -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Nama Peminjam</th>
                        <th class="py-4 px-6">Judul Buku</th>
                        <th class="py-4 px-6">Tgl Pinjam / Kembali</th>
                        <th class="py-4 px-6 text-center">Status</th>
                        <th class="py-4 px-6 text-center">Aksi / Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($peminjaman as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-slate-500 font-medium">{{ $peminjaman->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $item->user->name ?? 'User Dihapus' }}</td>
                            <td class="py-4 px-6 text-slate-700 font-medium">{{ $item->book->judul ?? 'Buku Dihapus' }}</td>
                            <td class="py-4 px-6 text-xs text-slate-500">
                                <div>Pinjam: {{ $item->tanggal_pinjam }}</div>
                                <div class="text-red-500">Kembali: {{ $item->tanggal_kembali }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @php
                                    $badgeColor = match($item->status) {
                                        'Pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                        'Dipinjam' => 'bg-blue-50 text-blue-600 border-blue-200',
                                        'Dikembalikan' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                        'Ditolak' => 'bg-red-50 text-red-600 border-red-200',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="px-3 py-1 border rounded-lg text-xs font-semibold {{ $badgeColor }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Form Ubah Status -->
                                    <form action="{{ route('admin.peminjaman.status', $item->id) }}" method="POST" class="flex items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border border-slate-200 rounded-lg px-2 py-1 bg-slate-50 focus:outline-none focus:border-blue-500">
                                            <option value="" disabled selected>Ubah Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Dipinjam">Dipinjam</option>
                                            <option value="Dikembalikan">Dikembalikan</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </form>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-base">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-sm">Belum ada data peminjaman buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200">
            {{ $peminjaman->links() }}
        </div>
    </div>
@endsection