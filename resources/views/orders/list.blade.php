@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800">
                Work Orders / List
            </h2>
           
            <a href="{{ route('orders.create') }}" class="bg-blue-500 text-sm rounded-md text-white px-3 py-2 hover:bg-blue-700">
                <i class="fas fa-plus"></i> Add order
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6 space-y-6">

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Search -->
                <div class="mb-4 flex gap-4">
                    <p class="border-hidden px-1 py-1 rounded-md w-1/6">
                        Filter Table :
                    </p>
                    <input type="text" id="searchKodeWO" placeholder="- Kode WO -" class="border border-gray-800 px-4 py-2 rounded-md w-1/4" onkeyup="filterByKodeWO()">
                    <input type="date" id="searchTanggalWO" class="border border-gray-800 px-4 py-2 rounded-md w-1/4" onchange="filterByTanggalWO()">
                    <select id="searchStatusWO" class="border border-gray-800 px-4 py-2 rounded-md w-1/4" onchange="filterByStatusWO()">
                        <option value="">- Status WO -</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Postpone">Postpone</option>
                        <option value="Accident">Accident</option>
                        <option value="Delay">Delay</option>
                        <option value="Terkirim">Terkirim</option>
                        <option value="Close">Close</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <select id="searchStatusDokumen" class="border border-gray-800 px-4 py-2 rounded-md w-1/4" onchange="filterByStatusDokumen()">
                        <option value="">- Status Doc -</option>
                        <option value="Dokumen Belum Kembali">Dokumen Belum Kembali</option>
                        <option value="Dokumen Hilang">Dokumen Hilang</option>
                        <option value="Kurang PO">Kurang PO</option>
                        <option value="Kurang Polis Asuransi">Kurang Polis Asuransi</option>
                        <option value="Kurang Surat Jalan">Kurang Surat Jalan</option>
                        <option value="Kurang Tanda Tangan Penerima">Kurang Tanda Tangan Penerima</option>
                        <option value="Close">Close</option>
                    </select>

                    <a href="{{ route('export.csv') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-file-csv"></i> Excel
                    </a>
                </div>

                <!-- Wrapper untuk Scroll Horizontal -->
                <div class="overflow-x-auto">
                    <div class="table-wrapper border border-gray-300 rounded-lg overflow-y-auto" style="max-height: 550px;">
                        <table class="table-auto border-collapse border border-gray-300 w-full text-sm" id="ordersTable">
                            <thead class="bg-gray-200 sticky top-0">
                                <tr>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Tanggal</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Kode</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Customer</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Muatan</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">S/N</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Muat</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Bongkar</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Status WO</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Status Dokumen</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Note</th>
                                    <th class="border px-4 py-2 whitespace-nowrap text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $orders)
                                <tr class="{{ $orders->status_wo === 'Cancelled' ? 'bg-red-200' : 
                                             ($orders->status_wo === 'Close' ? 'bg-green-200' : '') }}">
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">{{ \Carbon\Carbon::parse($orders->tanggal_wo)->translatedFormat('d-m-Y')}}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap text-center">{{ $orders->kode_wo }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap text-center">{{ $orders->customer->company_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2 whitespace-nowrap text-center">{{ $orders->muatan->model_muatan }} ({{ $orders->muatan->jenis_muatan }})</td>
                                    
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">{{ $orders->serial_number }}</td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">{{ $orders->lokasi_muat }}</td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">{{ $orders->lokasi_bongkar }}</td>
                                    

                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            {{ in_array($orders->status_wo, ['Ongoing', 'Postpone', 'Accident', 'Delay', 'Terkirim']) ? 'bg-yellow-200 text-yellow-800 border border-yellow-500' : 'text-gray-1000' }}">
                                            {{ $orders->status_wo }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">
                                        @php
                                            $statusDokumen = $orders->status_dokumen;
                                            $highlightedStatuses = [
                                                'Dokumen Belum Kembali', 
                                                'Dokumen Hilang', 
                                                'Kurang PO', 
                                                'Kurang Polis Asuransi', 
                                                'Kurang Surat Jalan', 
                                                'Kurang Tanda Tangan Penerima', 
                                            ];
                                            $badgeClass = in_array($statusDokumen, $highlightedStatuses) 
                                                ? 'bg-yellow-200 border border-2 text-yellow-800' 
                                                : 'text-gray-1000';
                                        @endphp
                                    
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold whitespace-nowrap {{ $badgeClass }}">
                                            {{ $statusDokumen }}
                                        </span>
                                    </td>
                                  
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap text-center">{{ $orders->note }}</td>
                                    
                                    <td class="border border-gray-300 px-6 py-3 whitespace-nowrap text-center">
                                        <a href="{{ route('orders.show', $orders->id) }}" class="text-blue-500">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('orders.edit', $orders->id) }}" class="text-yellow-500">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($orders->status_wo !== 'Cancelled')
                                            <a href="javascript:void(0);" onclick="cancelOrder({{ $orders->id }})" class="text-red-500">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                    
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center border border-gray-300 px-4 py-2">No units found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <x-slot name="script">
        <script type="text/javascript">
            function cancelOrder(id){
                if (confirm("Are you sure want to cancel this order?")){
                    $.ajax({
                        url     : '{{ route("orders.cancel") }}',
                        type    : 'POST',
                        data    : { id: id },
                        dataType: 'json',
                        headers : { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                        success : function(response){
                            if(response.status) {
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            }

            function filterByKodeWO() {
                let input = document.getElementById("searchKodeWO").value.toUpperCase();
                let table = document.getElementById("ordersTable");
                
                // Pastikan tabel ada sebelum menjalankan filter
                if (!table) {
                    console.error("Tabel ordersTable tidak ditemukan.");
                    return;
                }

                let tbody = table.getElementsByTagName("tbody")[0];
                
                // Pastikan tbody ada
                if (!tbody) {
                    console.error("Tbody tidak ditemukan dalam tabel.");
                    return;
                }

                let rows = tbody.getElementsByTagName("tr");

                for (let i = 0; i < rows.length; i++) {
                    let kodeTd = rows[i].getElementsByTagName("td")[1]; // Pastikan kolom kode berada di posisi ke-2

                    if (kodeTd) {
                        let kodeTxt = kodeTd.textContent.trim() || kodeTd.innerText.trim();

                        // Cek apakah kode WO mengandung inputan filter
                        if (kodeTxt.toUpperCase().indexOf(input) > -1) {
                            rows[i].style.display = ""; // Tampilkan baris jika cocok
                        } else {
                            rows[i].style.display = "none"; // Sembunyikan jika tidak cocok
                        }
                    }
                }
            }


            
            function filterByTanggalWO() {
                let tanggalFilter = document.getElementById("searchTanggalWO").value;
                let table = document.getElementById("ordersTable");
                let tbody = table.getElementsByTagName("tbody")[0];
                let tr = tbody.getElementsByTagName("tr");

                for (let i = 0; i < tr.length; i++) {
                    let tanggalTd = tr[i].getElementsByTagName("td")[0];
                    if (tanggalTd) {
                        let tanggalTxt = tanggalTd.textContent || tanggalTd.innerText;
                        let tanggalParts = tanggalTxt.split("-");
                        let formattedTanggal = `${tanggalParts[2]}-${tanggalParts[1]}-${tanggalParts[0]}`; // Format YYYY-MM-DD

                        tr[i].style.display = (formattedTanggal === tanggalFilter || tanggalFilter === "") ? "" : "none";
                    }
                }
            }

            function filterByStatusWO() {
                let statusFilter = document.getElementById("searchStatusWO").value.trim().toLowerCase();
                let table = document.getElementById("ordersTable");
                let tbody = table.getElementsByTagName("tbody")[0];
                let tr = tbody.getElementsByTagName("tr");

                console.log(`Filter Status WO: ${statusFilter}`); // Debug

                for (let i = 0; i < tr.length; i++) {
                    let statusTd = tr[i].getElementsByTagName("td")[7]; // GANTI INDEX SESUAI DEBUGGING
                    if (statusTd) {
                        let statusTxt = statusTd.textContent.trim().toLowerCase();
                        console.log(`Row ${i} - Status WO: ${statusTxt}`); // Debug

                        tr[i].style.display = (statusTxt === statusFilter || statusFilter === "") ? "" : "none";
                    }
                }
            }

            function filterByStatusDokumen() {
                let statusDokumenFilter = document.getElementById("searchStatusDokumen").value.trim().toLowerCase();
                let table = document.getElementById("ordersTable");
                let tbody = table.getElementsByTagName("tbody")[0];
                let tr = tbody.getElementsByTagName("tr");

                console.log(`Filter Status Dokumen: ${statusDokumenFilter}`); // Debug

                for (let i = 0; i < tr.length; i++) {
                    let statusDokumenTd = tr[i].getElementsByTagName("td")[8]; // GANTI INDEX SESUAI DEBUGGING
                    if (statusDokumenTd) {
                        let statusDokumenTxt = statusDokumenTd.textContent.trim().toLowerCase();
                        console.log(`Row ${i} - Status Dokumen: ${statusDokumenTxt}`); // Debug

                        tr[i].style.display = (statusDokumenTxt === statusDokumenFilter || statusDokumenFilter === "") ? "" : "none";
                    }
                }
            }

                        

        </script>
    </x-slot>
</x-app-layout>
 
@endsection
