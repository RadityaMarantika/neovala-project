@extends('layouts.base')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-base text-gray-800">Tambah Petty Cash</h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form action="{{ route('petty_cash.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm">Tanggal</label>
                            <input type="date" name="tanggal" class="w-full border rounded p-2" required>
                        </div>

                        <div>
                            <label class="block text-sm">Jenis</label>
                            <select name="jenis" class="w-full border rounded p-2" required>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm">Kategori</label>
                            <input type="text" name="kategori" class="w-full border rounded p-2" placeholder="Contoh: Operasional" required>
                        </div>

                        <div>
                            <label class="block text-sm">Sub Kategori</label>
                            <input type="text" name="subkategori" class="w-full border rounded p-2" placeholder="Contoh: Biaya Laundry" required>
                        </div>

                        <div>
                            <label class="block text-sm">Jumlah</label>
                            <input type="text" id="jumlah" name="jumlah" 
                                class="w-full border rounded p-2 text-right" required>
                        </div>


                        <div>
                            <label class="block text-sm">Diambil Oleh</label>
                            <select name="diambil_oleh" class="w-full border rounded p-2">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($karyawans as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="w-full border rounded p-2"></textarea>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-gray-700">Upload Bukti</label>
                            <input type="file" name="upload_bukti" class="w-full border-gray-300 rounded">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const jumlahInput = document.getElementById('jumlah');

    jumlahInput.addEventListener('input', function (e) {
        let value = this.value.replace(/\./g, ''); // hapus titik lama
        if (!isNaN(value) && value !== '') {
            this.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            this.value = '';
        }
    });

    // sebelum submit, ubah kembali ke angka murni
    jumlahInput.form.addEventListener('submit', function () {
        jumlahInput.value = jumlahInput.value.replace(/\./g, '');
    });
</script>

@endsection
