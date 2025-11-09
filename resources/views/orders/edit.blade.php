<!-- edit.blade.php -->
@extends('layouts.base')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">
                Work Orders / Edit
            </h2>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-sm rounded-md text-white px-3 py-2 hover:bg-blue-700">
                ← Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md border border border-gray-200">
    
        @if($errors->any())
            <div class="bg-red-200 text-red-700 p-3 mb-4 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Tanggal Order -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Tanggal Order</label>
                    <input type="date" name="tanggal_wo" class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           value="{{ old('tanggal_wo', $order->tanggal_wo) }}">
                </div>
        
                <!-- Kode WO -->
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Kode WO</label>
                    <input type="text" name="kode_wo" class="w-full p-3 border border-gray-500 rounded-lg bg-gray-100" value="{{ old('kode_wo', $order->kode_wo) }}" readonly>
                </div>
            </div>
            <hr>
        
            <!-- Customer -->
            <div class="grid grid-cols-0 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Customer</label>
                    <input type="text" id="customer-search" value="{{ old('customer_name', $order->customer->company_name ?? '') }}" placeholder="Ketik nama customer..." class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="relative">
                    <ul id="customer-dropdown" class="absolute w-full bg-white border border-gray-500 rounded-lg shadow-lg hidden z-10 max-h-48 overflow-y-auto">
                        @foreach($customers as $customer)
                            <li class="p-3 hover:bg-gray-100 cursor-pointer" data-id="{{ $customer->id }}" data-name="{{ $customer->company_name }}">
                                {{ $customer->company_name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <input type="hidden" name="customer_id" id="selected-customer-id" value="{{ old('customer_id', $order->customer_id) }}">
            </div>
        
            <!-- Muatan -->
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Muatan</label>
                    <input type="text" id="muatan-search" value="{{ old('muatan_name', $order->muatan->model_muatan . ' (' . $order->muatan->jenis_muatan . ')' ?? '') }}" placeholder="Pilih Muatan..." class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
        
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">S/N</label>
                    <input type="text" name="serial_number" class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           value="{{ old('serial_number', $order->serial_number) }}">
                </div>
        
                <div class="relative">
                    <ul id="muatan-dropdown" class="absolute w-full bg-white border border-gray-500 rounded-lg shadow-lg hidden z-10 max-h-48 overflow-y-auto">
                        @foreach($muatans as $muatan)
                            <li class="p-3 hover:bg-gray-100 cursor-pointer"
                                data-id="{{ $muatan->id }}"
                                data-name="{{ $muatan->model_muatan }} ({{ $muatan->jenis_muatan }})">
                                {{ $muatan->model_muatan }} ({{ $muatan->jenis_muatan }})
                            </li>
                        @endforeach
                    </ul>
                </div>
                <input type="hidden" name="muatan_id" id="selected-muatan-id" value="{{ old('muatan_id', $order->muatan_id) }}">
            </div>
            <br><hr><br>
        
            <div class="bg-gray-200 p-4 rounded-lg">
                <label class="block text-gray-700 font-semibold mb-2 text-center">Nilai Pembayaran</label>
                <hr>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="mb-3">
                        <label for="nilai_tagihan" class="block text-gray-700 font-semibold mb-2">Nilai Tagihan</label>
                        <input type="text" id="nilai_tagihan" name="nilai_tagihan" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('nilai_tagihan', $order->nilai_tagihan) }}"   >
                    </div>
        
                    <div class="mb-3">
                        <label for="kode_ppn" class="block text-gray-700 font-semibold mb-2">Kode PPN</label>
                        <select id="kode_ppn" name="kode_ppn" class="w-full p-3 border border-gray-500 rounded-lg"   >
                            <option value="">-- Pilih Kode PPN --</option>
                            @foreach(['080', '050', '040', '010', 'NON'] as $kode)
                                <option value="{{ $kode }}" {{ old('kode_ppn', $order->kode_ppn) == $kode ? 'selected' : '' }}>{{ $kode }}</option>
                            @endforeach
                        </select>
                    </div>
        
                    <div class="mb-3">
                        <label for="ppn" class="block text-gray-700 font-semibold mb-2">PPN</label>
                        <input type="text" id="ppn" name="ppn" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('ppn', $order->ppn) }}" readonly>
                    </div>
        
                    <div class="mb-3">
                        <label for="total_tagihan" class="block text-gray-700 font-semibold mb-2">Total Tagihan</label>
                        <input type="text" id="total_tagihan" name="total_tagihan" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('total_tagihan', $order->total_tagihan) }}" readonly>
                    </div>
        
                    <div class="mb-3">
                        <label for="pph23" class="block text-gray-700 font-semibold mb-2">PPh 23</label>
                        <input type="text" id="pph23" name="pph23" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('pph23', $order->pph23) }}" readonly>
                    </div>
        
                    <div class="mb-3">
                        <label for="nilai_pembayaran" class="block text-gray-700 font-semibold mb-2">Nilai Pembayaran</label>
                        <input type="text" id="nilai_pembayaran" name="nilai_pembayaran" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('nilai_pembayaran', $order->nilai_pembayaran) }}" readonly>
                    </div>
                </div>
            </div>
            <br>
            <div class="bg-gray-200 p-4 rounded-lg">
                <label class="block text-gray-700 font-semibold mb-2 text-center">Nilai Asuransi</label>
                <hr>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="mb-3">
                        <label for="nilai_unit">Nilai Unit</label>
                        <input type="text" name="nilai_unit" id="nilai_unit" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('nilai_unit', $order->nilai_unit) }}">
                    </div>
                    <div class="mb-3">
                        <label for="rate_asuransi">Rate Asuransi (%)</label>
                        <input type="text" name="rate_asuransi" id="rate_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('rate_asuransi', $order->rate_asuransi) }}">
                    </div>
                    <div class="mb-3">
                        <label for="adm_asuransi">Biaya Administrasi</label>
                        <input type="text" name="adm_asuransi" id="adm_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('adm_asuransi', $order->adm_asuransi) }}">
                    </div>
                    <div class="mb-3">
                        <label for="tagihan_asuransi">Tagihan Asuransi (Rp)</label>
                        <input type="text" name="tagihan_asuransi" id="tagihan_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('tagihan_asuransi', $order->tagihan_asuransi) }}" readonly>
                    </div>
                </div>
            </div>
        
            <br><hr><br>
        
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Lokasi Muat</label>
                    <input type="text" name="lokasi_muat" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('lokasi_muat', $order->lokasi_muat) }}">
                </div>
        
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Lokasi Bongkar</label>
                    <input type="text" name="lokasi_bongkar" class="w-full p-3 border border-gray-500 rounded-lg" value="{{ old('lokasi_bongkar', $order->lokasi_bongkar) }}">
                </div>
            </div>
        
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Status WO</label>
                    <select name="status_wo" class="w-full p-3 border border-gray-500 rounded-lg">
                        @foreach(['Ongoing', 'Postpone', 'Accident', 'Delay', 'Terkirim', 'Cancelled', 'Close', 'None'] as $status)
                            <option value="{{ $status }}" {{ old('status_wo', $order->status_wo) == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold mb-2">Status Dokumen</label>
                    <select name="status_dokumen" class="w-full p-3 border border-gray-500 rounded-lg">
                        @foreach([
                            'Dokumen Belum Kembali',
                            'Dokumen Hilang',
                            'Kurang PO',
                            'Kurang Polis Asuransi',
                            'Kurang Surat Jalan',
                            'Kurang Tanda Tangan Penerima',
                            'Close',
                            'None'
                        ] as $dok)
                            <option value="{{ $dok }}" {{ old('status_dokumen', $order->status_dokumen) == $dok ? 'selected' : '' }}>{{ $dok }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <hr>
        
            <div class="grid grid-cols-0 gap-4 mt-4">
                <div class="form-group">
                    <label class="block text-gray-700 font-semibold mb-2">Keterangan / Note</label>
                    <input type="text" name="note" id="note" class="form-control w-full border border-gray-500 p-3 rounded-lg" style="height: 120px;" value="{{ old('note', $order->note) }}">
                </div>
            </div>
        
            <br><hr><br>
        
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.getElementById("customer-search");
        let dropdown = document.getElementById("customer-dropdown");
        let customerItems = dropdown.getElementsByTagName("li");
        let selectedCustomerInput = document.getElementById("selected-customer-id");
    
        // Jika ada nilai saat edit, pastikan dropdown tetap berfungsi
        let initialCustomerName = searchInput.value.trim();
        if (initialCustomerName) {
            let found = false;
            Array.from(customerItems).forEach(function (item) {
                if (item.getAttribute("data-name") === initialCustomerName) {
                    selectedCustomerInput.value = item.getAttribute("data-id");
                    found = true;
                }
            });
    
            // Jika customer tidak ditemukan di daftar, kosongkan hidden input
            if (!found) {
                selectedCustomerInput.value = "";
            }
        }
    
        // Tampilkan dropdown berdasarkan input pencarian
        searchInput.addEventListener("input", function () {
            let filter = this.value.toLowerCase();
            let hasResults = false;
    
            Array.from(customerItems).forEach(function (item) {
                let name = item.getAttribute("data-name").toLowerCase();
                if (name.includes(filter)) {
                    item.style.display = "block";
                    hasResults = true;
                } else {
                    item.style.display = "none";
                }
            });
    
            dropdown.style.display = hasResults ? "block" : "none";
        });
    
        // Pilih customer dari dropdown
        Array.from(customerItems).forEach(function (item) {
            item.addEventListener("click", function () {
                searchInput.value = this.getAttribute("data-name");
                selectedCustomerInput.value = this.getAttribute("data-id");
                dropdown.style.display = "none";
            });
        });
    
        // Sembunyikan dropdown jika klik di luar
        document.addEventListener("click", function (event) {
            if (!dropdown.contains(event.target) && event.target !== searchInput) {
                dropdown.style.display = "none";
            }
        });
    });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.getElementById("muatan-search");
        let dropdown = document.getElementById("muatan-dropdown");
        let customerItems = dropdown.getElementsByTagName("li");
        let selectedCustomerInput = document.getElementById("selected-muatan-id");
    
        // Jika ada nilai saat edit, pastikan dropdown tetap berfungsi
        let initialCustomerName = searchInput.value.trim();
        if (initialCustomerName) {
            let found = false;
            Array.from(customerItems).forEach(function (item) {
                if (item.getAttribute("data-name") === initialCustomerName) {
                    selectedCustomerInput.value = item.getAttribute("data-id");
                    found = true;
                }
            });
    
            // Jika customer tidak ditemukan di daftar, kosongkan hidden input
            if (!found) {
                selectedCustomerInput.value = "";
            }
        }
    
        // Tampilkan dropdown berdasarkan input pencarian
        searchInput.addEventListener("input", function () {
            let filter = this.value.toLowerCase();
            let hasResults = false;
    
            Array.from(customerItems).forEach(function (item) {
                let name = item.getAttribute("data-name").toLowerCase();
                if (name.includes(filter)) {
                    item.style.display = "block";
                    hasResults = true;
                } else {
                    item.style.display = "none";
                }
            });
    
            dropdown.style.display = hasResults ? "block" : "none";
        });
    
        // Pilih customer dari dropdown
        Array.from(customerItems).forEach(function (item) {
            item.addEventListener("click", function () {
                searchInput.value = this.getAttribute("data-name");
                selectedCustomerInput.value = this.getAttribute("data-id");
                dropdown.style.display = "none";
            });
        });
    
        // Sembunyikan dropdown jika klik di luar
        document.addEventListener("click", function (event) {
            if (!dropdown.contains(event.target) && event.target !== searchInput) {
                dropdown.style.display = "none";
            }
        });
    });
    </script>
    
    <script>
        // Format ke Rupiah
        function formatRupiah(angka, prefix = '') {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
    
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
    
            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }
    
        // Get element
        const nilaiTagihan      = document.getElementById('nilai_tagihan');
        const nilaiUnit         = document.getElementById('nilai_unit');
        const rateAsuransi      = document.getElementById('rate_asuransi');
        const admAsuransi       = document.getElementById('adm_asuransi');
        const tagihanAsuransi   = document.getElementById('tagihan_asuransi');
        const kodePpn           = document.getElementById('kode_ppn');
        const ppn               = document.getElementById('ppn');
        const totalTagihan      = document.getElementById('total_tagihan');
        const pph23             = document.getElementById('pph23');
        const nilaiPembayaran   = document.getElementById('nilai_pembayaran');
    
        // Auto-format angka saat diketik
        [nilaiTagihan, nilaiUnit, admAsuransi].forEach(field => {
            field.addEventListener('keyup', function(e) {
                let raw = this.value.replace(/[^\d]/g, '');
                this.value = formatRupiah(raw);
                hitungSemua(); 
            });
        });
    
        [rateAsuransi, kodePpn].forEach(field => {
            field.addEventListener('change', function(e) {
                hitungSemua();
            });
        });
    
        function hitungSemua() {
            // Clean all inputs
            const clean = (val) => parseFloat(val.replace(/[^\d]/g, '') || 0);
    
            const nilaiTagihanRaw    = clean(nilaiTagihan.value);
            const nilaiUnitRaw       = clean(nilaiUnit.value);
            const rateRaw            = parseFloat(rateAsuransi.value || 0);
            const admRaw             = clean(admAsuransi.value);
    
            // Hitung tagihan asuransi
            const hitungAsuransi = (nilaiUnitRaw * (rateRaw / 100)) + admRaw;
            tagihanAsuransi.value = formatRupiah(hitungAsuransi.toFixed(0));
    
            // Hitung pajak dan pembayaran
            const persenPPN = {
                '080': 0,
                '050': 0.011,
                '040': 0.11,
                '010': 0.12,
                'NON': 0
            };
    
            let ppnVal = nilaiTagihanRaw * (persenPPN[kodePpn.value] || 0);
            let total = nilaiTagihanRaw + ppnVal;
            let pph = kodePpn.value === 'NON' ? 0 : nilaiTagihanRaw * 0.02;
            let pembayaran = total - pph;
    
            // Update hasil ke input
            ppn.value = formatRupiah(ppnVal.toFixed(0));
            totalTagihan.value = formatRupiah(total.toFixed(0));
            pph23.value = formatRupiah(pph.toFixed(0));
            nilaiPembayaran.value = formatRupiah(pembayaran.toFixed(0));
        }
    
        // Trigger awal saat page load
        window.addEventListener('load', function() {
            hitungSemua();
        });
    </script>

</x-app-layout>
@endsection
