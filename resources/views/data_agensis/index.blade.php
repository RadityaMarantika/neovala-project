@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-base text-gray-800">Data Master Agensi</h2>
            <a href="{{ route('data-agensis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-md shadow">
                +New
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">

                {{-- Flash Success --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Error Handling --}}
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Filter Input --}}
                <div class="mb-4">
                    <input type="text" id="filterInput" placeholder="Cari ID Agensi / Nama Agensi / Nama Pemilik"
                        class="w-full sm:w-1/3 px-4 py-2 border border-gray-300 rounded-md text-sm focus:ring focus:ring-blue-100">
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-200 divide-y divide-gray-200" id="agensiTable">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-semibold text-gray-700 text-left">
                                <th class="px-4 py-3 whitespace-nowrap text-center">No</th>
                                <th class="px-4 py-3 whitespace-nowrap">ID Agensi</th>
                                <th class="px-4 py-3 whitespace-nowrap">NIP</th>
                                <th class="px-4 py-3 whitespace-nowrap">Nama Agensi</th>
                                <th class="px-4 py-3 whitespace-nowrap">Nama Pemilik</th>
                                <th class="px-4 py-3 whitespace-nowrap">Telepon</th>
                                <th class="px-4 py-3 whitespace-nowrap">Email</th>
                                <th class="px-4 py-3 whitespace-nowrap">Jumlah Unit</th>
                                <th class="px-4 py-3 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                            @forelse($dataAgensis as $agensi)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-center">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->id_agensis }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->nip }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->nama_agensi }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->nama_pemilik }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->telp_agensi }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->email_agensi }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $agensi->units_count }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('data-agensis.edit', $agensi->id) }}"
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs font-medium">
                                                Edit
                                            </a>
                                            <form action="{{ route('data-agensis.destroy', $agensi->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus agensi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center px-4 py-4 text-gray-500">
                                        Belum ada data agensi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('filterInput');
    const rows = Array.from(document.querySelectorAll('#agensiTable tbody tr'));

    const agensiData = rows.map(row => {
        return {
            row,
            id_agensi: row.cells[1]?.textContent.trim(),
            nip: row.cells[2]?.textContent.trim(),
            nama_agensi: row.cells[3]?.textContent.trim(),
            nama_pemilik: row.cells[4]?.textContent.trim(),
        };
    });

    const fuse = new Fuse(agensiData, {
        keys: ['id_agensi', 'nip', 'nama_agensi', 'nama_pemilik'],
        threshold: 0.4,
    });

    input.addEventListener('input', function () {
        const keyword = this.value.trim();

        if (!keyword) {
            rows.forEach(row => row.style.display = '');
            return;
        }

        const results = fuse.search(keyword);
        const matched = new Set(results.map(res => res.item.row));

        rows.forEach(row => {
            row.style.display = matched.has(row) ? '' : 'none';
        });
    });
});
</script>

</x-app-layout>
@endsection
