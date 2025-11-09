@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-base text-gray-800">Buat Jadwal Shift</h2>
            <a href="{{ route('master_shifts.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('master_shifts.store') }}" method="POST">
                    @csrf
                    <div>
                        <label>Kode Shift</label>
                        <input type="text" name="buat_kode_shift" value="{{ old('buat_kode_shift') }}" required>
                    </div>

                    <div>
                        <label>Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" required>
                    </div>

                    <div>
                        <label>Jam Pulang</label>
                        <input type="time" name="jam_pulang" value="{{ old('jam_pulang') }}" required>
                    </div>

                    <button type="submit">Simpan</button>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            const select = document.getElementById('master_shift_select');
            select.addEventListener('change', function() {
                const option = select.selectedOptions[0];
                if(option){
                    document.getElementById('jam_masuk_kerja').value = option.dataset.jamMasuk;
                    document.getElementById('jam_pulang_kerja').value = option.dataset.jamPulang;
                    document.getElementById('jenis_shift').value = option.dataset.jenis;
                } else {
                    document.getElementById('jam_masuk_kerja').value = '';
                    document.getElementById('jam_pulang_kerja').value = '';
                    document.getElementById('jenis_shift').value = '';
                }
            });
        </script>
    </x-slot>
</x-app-layout>
@endsection
