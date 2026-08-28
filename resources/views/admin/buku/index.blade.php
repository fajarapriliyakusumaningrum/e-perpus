@extends('layouts.admin')

@section('title', 'Data Buku')
@section('page_heading', 'Manajemen Data Buku')

@section('content')
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-medium flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- TOP ACTIONS: SEARCH & BUTTON TAMBAH -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <form action="{{ route('admin.buku.index') }}" method="GET" class="w-full sm:w-72 relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul/penulis..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
        </form>
        <button onclick="openModal('modalTambah')" class="w-full sm:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold flex items-center justify-center gap-2 transition-colors shadow-sm shadow-blue-200">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Buku
        </button>
    </div>

    <!-- TABLE DATA BUKU -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-400 text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Cover</th>
                        <th class="py-4 px-6">Judul Buku & ISBN</th>
                        <th class="py-4 px-6">Penulis / Penerbit</th>
                        <th class="py-4 px-6">Kategori</th>
                        <th class="py-4 px-6 text-center">Stok</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($buku as $index => $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 text-slate-500 font-medium">{{ $buku->firstItem() + $index }}</td>
                            <td class="py-4 px-6">
                                @if($item->cover)
                                    <img src="{{ asset('storage/' . $item->cover) }}" alt="Cover" class="w-12 h-16 object-cover rounded-lg shadow-sm border border-slate-200">
                                @else
                                    <div class="w-12 h-16 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 text-xs">No Cover</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-800">{{ $item->judul }}</div>
                                <div class="text-xs text-slate-400">ISBN: {{ $item->isbn ?? '-' }} ({{ $item->tahun_terbit ?? '-' }})</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-slate-700 font-medium">{{ $item->penulis }}</div>
                                <div class="text-xs text-slate-400">{{ $item->penerbit }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold">
                                    {{ $item->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center font-bold text-slate-800">{{ $item->stok }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <button onclick="openEditModal({{ json_encode($item) }})" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 flex items-center justify-center transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('admin.buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');">
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
                            <td colspan="7" class="py-8 text-center text-slate-400 text-sm">Belum ada data buku ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-slate-200">
            {{ $buku->links() }}
        </div>
    </div>

    <!-- MODAL TAMBAH BUKU -->
    <div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Tambah Buku Baru</h3>
            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Judul Buku</label>
                        <input type="text" name="judul" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penulis</label>
                            <input type="text" name="penulis" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penerbit</label>
                            <input type="text" name="penerbit" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ISBN</label>
                            <input type="text" name="isbn" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" placeholder="Cth: 2023" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kategori</label>
                            <select name="category_id" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 bg-white">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Stok</label>
                            <input type="number" name="stok" min="0" value="0" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Cover Buku</label>
                        <input type="file" name="cover" accept="image/*" class="w-full px-4 py-1.5 border border-slate-200 rounded-xl text-sm text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT BUKU -->
    <div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <h3 class="font-bold text-lg text-slate-800 mb-4">Edit Data Buku</h3>
            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Judul Buku</label>
                        <input type="text" id="edit_judul" name="judul" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penulis</label>
                            <input type="text" id="edit_penulis" name="penulis" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Penerbit</label>
                            <input type="text" id="edit_penerbit" name="penerbit" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">ISBN</label>
                            <input type="text" id="edit_isbn" name="isbn" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Tahun Terbit</label>
                            <input type="number" id="edit_tahun_terbit" name="tahun_terbit" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Kategori</label>
                            <select id="edit_category_id" name="category_id" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 bg-white">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Stok</label>
                            <input type="number" id="edit_stok" name="stok" min="0" required class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Ganti Cover Buku (Opsional)</label>
                        <input type="file" name="cover" accept="image/*" class="w-full px-4 py-1.5 border border-slate-200 rounded-xl text-sm text-slate-500 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                        <span class="text-[11px] text-slate-400 mt-1 block">Biarkan kosong jika tidak ingin mengubah cover.</span>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        function openEditModal(buku) {
            document.getElementById('formEdit').action = '/admin/buku/' + buku.id;
            document.getElementById('edit_judul').value = buku.judul || '';
            document.getElementById('edit_penulis').value = buku.penulis || '';
            document.getElementById('edit_penerbit').value = buku.penerbit || '';
            document.getElementById('edit_isbn').value = buku.isbn || '';
            document.getElementById('edit_tahun_terbit').value = buku.tahun_terbit || '';
            document.getElementById('edit_category_id').value = buku.category_id || '';
            document.getElementById('edit_stok').value = buku.stok || '';
            openModal('modalEdit');
        }
    </script>
@endsection