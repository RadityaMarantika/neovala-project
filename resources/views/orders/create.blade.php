@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">
                Work Orders / Create
            </h2>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-sm rounded-md text-white px-3 py-2 hover:bg-blue-700">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md border border border-gray-200">
            
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border border-red-400 text-red-700 rounded">
                    <strong>Oops! Ada kesalahan:</strong>
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <!-- Tanggal Order -->
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Order</label>
                        <input type="date" name="tanggal_wo" class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('tanggal_wo') }}">
                    </div>

                    <!-- Kode WO -->
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Kode WO</label>
                        <input type="text" name="kode_wo" class="w-full p-3 border border-gray-500 rounded-lg bg-gray-100" value="{{ old('kode_wo', $kode_wo) }}" readonly>
                    </div>
                </div>
                <hr>

                <!-- Customer -->
                <div class="grid grid-cols-0 gap-4 mt-4">
                     <!-- Input untuk Filter Nama Customer -->
                     <div>
                        <label class="block text-gray-700 font-semibold mb-2">Customer</label>
                        <input type="text" id="customer-search" placeholder="Ketik nama customer..." class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    
                    <!-- Dropdown Pilih Customer -->
                    <div class="relative">
                        <ul id="customer-dropdown" class="absolute w-full bg-white border border-gray-500 rounded-lg shadow-lg hidden z-10 max-h-48 overflow-y-auto">
                            @foreach($customers as $customer)
                                <li class="p-3 hover:bg-gray-100 cursor-pointer" data-id="{{ $customer->id }}" data-name="{{ $customer->company_name }}">
                                    {{ $customer->company_name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Hidden Input untuk Menyimpan Customer Terpilih -->
                    <input type="hidden" name="customer_id" id="selected-customer-id">
                </div>

                <!-- Muatan -->
                <div class="grid grid-cols-2 gap-4 mt-4">
                   
                    <!-- Pilih Muatan -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Muatan</label>
                        <input type="text" id="muatan-search" placeholder="Pilih Muatan..." class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    
                    <!-- Serial Number -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2">S/N</label>
                        <input type="text" placeholder="Ketik S/N..." name="serial_number" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('serial_number') }}">
                    </div>
                    
                    <!-- Dropdown Pilih Muatan -->
                    <div class="relative">
                        <ul id="muatan-dropdown" class="absolute w-full bg-white border border-gray-500 rounded-lg shadow-lg hidden z-10 max-h-48 overflow-y-auto">
                            @foreach($muatans as $muatan)
                                <li class="p-3 hover:bg-gray-100 cursor-pointer" data-id="{{ $muatan->id }}" data-name="{{ $muatan->model_muatan }} ({{ $muatan->jenis_muatan }})">
                                    {{ $muatan->model_muatan }} ({{ $muatan->jenis_muatan }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Hidden Input untuk Menyimpan Customer Terpilih -->
                    <input type="hidden" name="muatan_id" id="selected-muatan-id">
                </div>
                <br>
                <hr>
                <br>

                <div class="bg-gray-200 p-4 rounded-lg">
                    <label class="block text-gray-700 font-semibold mb-2 text-center">Nilai Pembayaran</label>
                    <hr>
                    <div class="grid grid-cols-2 gap-4 mt-4">

                        <div class="mb-3">
                            <label for="nilai_tagihan" class="block text-gray-700 font-semibold mb-2">Nilai Tagihan</label>
                            <input type="text" placeholder="0" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="nilai_tagihan" name="nilai_tagihan"  >
                        </div>

                        <!-- Pilih Kode PPN -->
                        <div class="mb-3">
                            <label for="kode_ppn" class="block text-gray-700 font-semibold mb-2">Kode PPN</label>
                            <select class="form-select w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="kode_ppn" name="kode_ppn"  >
                                <option value="NON">NON</option>
                                <option value="080">080</option>
                                <option value="050">050</option>
                                <option value="040">040</option>
                                <option value="010">010</option>
                                
                            </select>
                        </div>

                        <!-- Output PPN -->
                        <div class="mb-3">
                            <label for="ppn" class="block text-gray-700 font-semibold mb-2">PPN</label>
                            <input type="text" placeholder="0" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="ppn" name="ppn" readonly>
                        </div>

                        <!-- Output Total Tagihan -->
                        <div class="mb-3">
                            <label for="total_tagihan" class="block text-gray-700 font-semibold mb-2">Total Tagihan</label>
                            <input type="text" placeholder="0" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="total_tagihan" name="total_tagihan" readonly>
                        </div>

                        <!-- Output PPh23 -->
                        <div class="mb-3">
                            <label for="pph23" class="block text-gray-700 font-semibold mb-2">PPh 23</label>
                            <input type="text" placeholder="0" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="pph23" name="pph23" readonly>
                        </div>

                        <!-- Output Nilai Pembayaran -->
                        <div class="mb-3">
                            <label for="nilai_pembayaran" class="block text-gray-700 font-semibold mb-2">Nilai Pembayaran</label>
                            <input type="text" placeholder="0" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" id="nilai_pembayaran" name="nilai_pembayaran" readonly>
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
                            <input type="text" name="nilai_unit" id="nilai_unit" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('nilai_unit') }}">
                        </div>
                        <div class="mb-3">
                            <label for="rate_asuransi">Rate Asuransi (%)</label>
                            <input type="text" name="rate_asuransi" id="rate_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('rate_asuransi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="adm_asuransi">Biaya Administrasi</label>
                            <input type="text" name="adm_asuransi" id="adm_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('adm_asuransi') }}">
                        </div>
                        <div class="mb-3">
                            <label for="tagihan_asuransi">Tagihan Asuransi (Rp)</label>
                            <input type="text" name="tagihan_asuransi" id="tagihan_asuransi" class="w-full p-3  border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('tagihan_asuransi') }}" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <hr>


                <div class="grid grid-cols-2 gap-4 mt-4">

                    <!-- Lokasi Muat -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2">Lokasi Muat</label>
                        <input type="text" placeholder="Ketik Lokasi Muat..." name="lokasi_muat" class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('lokasi_muat') }}">
                    </div>

                    <!-- Lokasi Bongkar -->
                    <div class="">
                        <label class="block text-gray-700 font-semibold mb-2">Lokasi Bongkar</label>
                        <input type="text" placeholder="Ketik Lokasi Bongkar..." name="lokasi_bongkar" class="w-full p-3 border border-gray-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" value="{{ old('lokasi_bongkar') }}">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <!-- Status WO -->
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Status WO</label>
                        <select name="status_wo" class="w-full p-3 border border-gray-500 rounded-lg">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Postpone">Postpone</option>
                            <option value="Accident">Accident</option>
                            <option value="Delay">Delay</option>
                            <option value="Terkirim">Terkirim</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Close">Close</option>
                            <option value="None">-none-</option>
                        </select>
                    </div>

                    <!-- Status Dokumen -->
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Status Dokumen</label>
                        <select name="status_dokumen" class="w-full p-3 border border-gray-500 rounded-lg">
                            <option value="Dokumen Belum Kembali">Dokumen Belum Kembali</option>
                            <option value="Dokumen Hilang">Dokumen Hilang</option>
                            <option value="Kurang PO">Kurang PO</option>
                            <option value="Kurang Polis Asuransi">Kurang Polis Asuransi</option>
                            <option value="Kurang Surat Jalan">Kurang Surat Jalan</option>
                            <option value="Kurang Tanda Tangan Penerima">Kurang Tanda Tangan Penerima</option>
                            <option value="Close">Close</option>
                            <option value="None">-none-</option>
                        </select>
                    </div>
                </div>
                <hr>

                <div class="grid grid-cols-0 gap-4 mt-4">
                    <!-- Note -->
                    <div class="form-group">
                        <label for="note" class="block text-gray-700 font-semibold mb-2">Keterangan / Note</label>
                        <textarea name="note" placeholder="Catatan..." id="note" class="form-control" style="height: 120px;">{{ old('note') }}</textarea>
                    </div>
                </div>
                <br>
                <hr>
                <br>

                <!-- Tombol Aksi -->
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>

<!----------------------------------------- Source Code Script ------------------------------------------------>
<!-- Select2 Initialization -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let searchInput = document.getElementById("customer-search");
        let dropdown = document.getElementById("customer-dropdown");
        let customerItems = dropdown.getElementsByTagName("li");
        let selectedCustomerInput = document.getElementById("selected-customer-id");
    
        // Tampilkan dropdown berdasarkan pencarian
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
    
        // Tampilkan dropdown berdasarkan pencarian
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
        let pembayaran = total - pph + hitungAsuransi;

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
