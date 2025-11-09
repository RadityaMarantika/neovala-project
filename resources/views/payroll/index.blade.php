@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-lg text-gray-800">Data Payroll Karyawan</h2>
    </x-slot>

    <div class="p-6">
        <div class="flex justify-end mb-3">
            <a href="{{ route('payroll.create') }}" class="bg-blue-600 text-white px-3 py-2 rounded">+ Tambah Payroll</a>
        </div>

        <table class="table-auto w-full border text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">Nama</th>
                    <th class="border px-2 py-1">Gaji Pokok</th>
                    <th class="border px-2 py-1">Total Earnings</th>
                    <th class="border px-2 py-1">Total Deductions</th>
                    <th class="border px-2 py-1">Take Home Pay</th>
                    <th class="border px-2 py-1">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $p)
                    <tr>
                        <td class="border px-2 py-1">{{ $p->karyawan->nama_lengkap ?? '-' }}</td>
                        <td class="border px-2 py-1">Rp{{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                        <td class="border px-2 py-1">Rp{{ number_format($p->total_earnings, 0, ',', '.') }}</td>
                        <td class="border px-2 py-1">Rp{{ number_format($p->total_deductions, 0, ',', '.') }}</td>
                        <td class="border px-2 py-1 font-semibold text-green-700">Rp{{ number_format($p->take_home_pay, 0, ',', '.') }}</td>
                        <td class="border px-2 py-1">
                            <a href="{{ route('payroll.edit', $p->id) }}" class="text-blue-600">Edit</a> |
                            <form action="{{ route('payroll.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-600" onclick="return confirm('Yakin hapus payroll ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection
