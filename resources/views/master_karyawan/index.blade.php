@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-base text-gray-800">Data Master Karyawan</h2>
            <a href="{{ route('master_karyawan.create') }}" 
               class="bg-gray-500 text-base rounded-md text-white px-3 py-2 hover:bg-gray-700">
                + New
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

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

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <div class="border border-gray-300 rounded-lg overflow-y-auto" style="max-height: 550px;">
                        <table class="table-auto border-collapse border border-gray-300 w-full text-sm">
                            <thead class="bg-gray-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 py-2 whitespace-nowrap">#</th>
                                    <th class="px-4 py-2 whitespace-nowrap">Nama Lengkap</th>
                                    <th class="px-4 py-2 whitespace-nowrap">Region</th>
                                    <th class="px-4 py-2 whitespace-nowrap">Jabatan</th>
                                    <th class="px-4 py-2 whitespace-nowrap">Status</th>
                                    <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs"> 
                                @forelse($master_karyawans as $master_karyawan)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $master_karyawan->nama_lengkap }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $master_karyawan->penempatan }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $master_karyawan->jabatan }}</td>
                                       <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded text-xs 
                                                {{ $master_karyawan->status_karyawan === 'Aktif' 
                                                    ? 'bg-green-200 text-green-800' 
                                                    : 'bg-red-200 text-red-800' }}">
                                                {{ $master_karyawan->status_karyawan }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                                            <a href="{{ route('master_karyawan.edit', $master_karyawan->id) }}" 
                                               class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs">
                                                Edit
                                            </a>
                                            <a href="{{ route('master_karyawan.show', $master_karyawan->id) }}" 
                                               class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                                View
                                            </a>
                                            <form action="{{ route('master_karyawan.destroy', $master_karyawan->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                                            Belum ada data karyawan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
@endsection
