@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-base text-gray-800">Edit Master Shift</h2>
            <a href="{{ route('master_shifts.index') }}" class="bg-gray-500 text-white text-xs px-3 py-2 rounded">Kembali</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $e) 
                                <li>{{ $e }}</li> 
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('master_shifts.update', $masterShift->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700">Kode Shift</label>
                        <input type="text" name="buat_kode_shift" value="{{ old('buat_kode_shift', $masterShift->buat_kode_shift) }}" class="w-full border-gray-300 rounded mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jam Masuk</label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk', $masterShift->jam_masuk) }}" class="w-full border-gray-300 rounded mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Jam Pulang</label>
                        <input type="time" name="jam_pulang" value="{{ old('jam_pulang', $masterShift->jam_pulang) }}" class="w-full border-gray-300 rounded mt-1" required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white text-xs">Update Shift</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
@endsection
