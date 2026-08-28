@extends('layouts.admin')

@section('title', 'Kategori Buku')
@section('page_heading', 'Manajemen Kategori Buku')

@section('content')
    <!-- Notifikasi Sukses / Error -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-medium flex items-center justify-between">
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- TOP ACTIONS: SEARCH & BUTTON TAMBAH -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.kategori.index') }}" method="GET" class="w-full sm:w-72 relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
        </form>
        <button onclick="openModal('modalTambah')" class="w-full sm:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow-sm shadow-blue-200">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Kategori
        </button>
    </div>

    <!-- TABLE DATA KATEGORI -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6 w-20">No</th>
                        <th class="py-4 px-6">Nama Kategori</th>
                        <th class="py-4 px-6">Slug</th>
                        <th class="py-4 px-6 text-center">Jumlah Buku</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($categories as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-slate-500 font-medium">{{ $categories->firstItem() + $index }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $item->name }}</td>
                            <td class="py-4 px-6 text-slate-400 text-xs font-mono">{{ $item->slug }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                    {{ $item->books_count ?? 0 }} Buku
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditModal({{ json_encode($item) }})" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    
                                    <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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
                            <td colspan="5" class="py-8 text-center text-slate-400 text-sm">Belum ada data kategori ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-200">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH KATEGORI -->
    <div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Kategori</label>
                        <input type="text" name="name" required placeholder="Contoh: Teknologi, Fiksi" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT KATEGORI -->
    <div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Edit Kategori</h3>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama Kategori</label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        function openEditModal(category) {
            document.getElementById('formEdit').action = '/admin/kategori/' + category.id;
            document.getElementById('edit_name').value = category.name || '';
            openModal('modalEdit');
        }
    </script>
@endsection