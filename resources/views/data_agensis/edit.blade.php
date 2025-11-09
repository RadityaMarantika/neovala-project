@extends('layouts.base')

@section('content')

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-base text-gray-800">Edit Data Agensi</h2>
            <a href="{{ route('data-agensis.index') }}" class="bg-blue-500 text-sm rounded-md text-white px-3 py-2 hover:bg-blue-700">
                ←Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4">
            <div class="bg-white shadow rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-semibold">
                        Terjadi kesalahan:
                        <ul class="list-disc list-inside text-sm text-red-500 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('data-agensis.update', $data_agensi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h3 class="text-base font-semibold mb-4 border-b pb-1">A. Identitas Agensi</h3>

                   
                    {{-- ID Agensi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Agensi</label>
                        <input type="text" name="id_agensi" id="id_agensi"
                            value="{{ old('id_agensi', $data_agensi->id_agensi) }}"
                            class="w-full bg-gray-100 border-gray-300 rounded-md shadow-sm" readonly>
                    </div>

                    {{-- Hidden input untuk JS validasi NIP --}}
                    <input type="hidden" id="id_agensi" value="{{ old('id_agensi', $data_agensi->id_agensi) }}">

                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Operasional</label>
                        <select id="status_operasional" name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih --</option>
                            @foreach(['Aktif', 'Non-Aktif', 'Stop Paksa Beroperasi'] as $value)
                                <option value="{{ $value }}" {{ $data_agensi->status == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Modal PIN -->
                    <div id="pinModal" class="fixed z-50 inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
                            <h2 class="text-lg font-semibold mb-4">Konfirmasi PIN</h2>
                            <p class="text-sm mb-3">Masukkan PIN untuk memilih <strong>Stop Paksa Beroperasi</strong>.</p>
                            <input type="password" id="pinInput" placeholder="Masukkan PIN" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 mb-4">
                            <div class="flex justify-end space-x-2">
                                <button id="cancelPin" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Batal</button>
                                <button id="confirmPin" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Konfirmasi</button>
                            </div>
                            <p id="pinError" class="text-red-600 text-sm mt-2 hidden">PIN salah. Silakan coba lagi.</p>
                        </div>
                    </div>


                    {{-- Nama Agensi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Agensi</label>
                        <input type="text" name="nama_agensi" value="{{ old('nama_agensi', $data_agensi->nama_agensi) }}" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Nama Pemilik --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" id="nama_pemilik" value="{{ old('nama_pemilik', $data_agensi->nama_pemilik) }}" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p id="error_nama_pemilik" class="text-red-500 text-sm mt-1 hidden">Nama pemilik hanya boleh huruf dan spasi.</p>
                    </div>

                    {{-- NIP --}}
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                        <input type="text" id="nip" name="nip"
                            value="{{ old('nip', $data_agensi->nip) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            placeholder="Contoh: 7501xxxxxx">
                        <p class="text-red-600 text-sm mt-1 field-error"></p>
                    </div>

                    {{-- No KTP --}}
                    <div class="mb-4" id="ktp-group">
                        <label class="block text-sm font-medium text-gray-700 mb-1">No. KTP</label>
                        <input type="text" name="no_ktp" id="no_ktp" value="{{ $data_agensi->no_ktp }}" required
                            class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <div class="text-sm text-red-600 mt-1 hidden" id="error-ktp">
                            Nomor KTP harus tepat 16 digit angka.
                        </div>
                    </div>

                    {{-- Alamat Agensi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Kantor</label>
                        <textarea name="alamat_agensi" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $data_agensi->alamat_agensi }}</textarea>
                    </div>

                    {{-- Telp Agensi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telp Agensi</label>
                        <input type="text" name="telp_agensi" value="{{ $data_agensi->telp_agensi }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Email Agensi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Agensi</label>
                        <input type="text" name="email_agensi" value="{{ $data_agensi->email_agensi }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Badan Usaha --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Badan Usaha</label>
                        <select name="badan_usaha" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih --</option>
                            @foreach(['PT', 'CV', 'UD', 'Perorangan'] as $value)
                                <option value="{{ $value }}" {{ $data_agensi->badan_usaha == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Dokumen Legasitas --}}
                    <div class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen Legasitas</label>
                        <select name="dokumen_legasitas" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih --</option>
                            @foreach(['Terlampir', 'Tidak Terlampir'] as $value)
                                <option value="{{ $value }}" {{ $data_agensi->dokumen_legasitas == $value ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Upload Dokumen Legalitas --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Dokumen Legalitas (PDF)</label>
                        <input type="file" name="kontrak_psm" accept="application/pdf" class="w-full border-gray-300 rounded-md shadow-sm">
                        @if ($data_agensi->kontrak_psm)
                            <p class="text-sm mt-1 text-gray-600">File sebelumnya:
                                <a href="{{ route('agensi.preview', $data_agensi->id) }}" target="_blank" class="text-blue-600 underline hover:text-blue-800">Preview Kontrak PSM</a>
                            </p>
                        @endif
                    </div>

                    <h3 class="text-base font-semibold mb-4 border-b pb-1">B. Penanggung Jawab</h3>

                    {{-- Nama PIC Utama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC Utama</label>
                        <input type="text" name="nama_pic_utama" value="{{ $data_agensi->nama_pic_utama }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Telp PIC Utama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telp PIC Utama</label>
                        <input type="text" name="telp_pic_utama" value="{{ $data_agensi->telp_pic_utama }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Nama Wakil PIC --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Wakil PIC</label>
                        <input type="text" name="nama_wakil_pic" value="{{ $data_agensi->nama_wakil_pic }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Telp Wakil PIC --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telp Wakil PIC</label>
                        <input type="text" name="telp_wakil_pic" value="{{ $data_agensi->telp_wakil_pic }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <input type="hidden" name="modify_by" value="{{ auth()->user()->id }}">

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const fieldsToCheck = ['nip', 'nama_agensi', 'nama_pemilik', 'no_ktp', 'email_agensi', 'telp_agensi', 'nama_pic_utama', 'telp_pic_utama', 'nama_wakil_pic', 'telp_wakil_pic'];

    const idAgensi = document.getElementById('id_agensi').value; // pastikan ada hidden input id_agensi

    fieldsToCheck.forEach(fieldName => {
        const field = document.querySelector(`[name="${fieldName}"]`);
        if (!field) return;

        const container = field.closest('.mb-4') ?? field.parentElement;

        // Buat tempat error message jika belum ada
        let errorDiv = container.querySelector('.field-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.classList.add('text-sm', 'text-red-600', 'mt-1', 'field-error');
            container.appendChild(errorDiv);
        }

        field.addEventListener('blur', () => {
            const value = field.value.trim();
            if (!value) {
                errorDiv.textContent = '';
                return;
            }

            let localError = '';

            // 🔍 Validasi NIP
            if (fieldName === 'nip') {
                if (!/^\d+$/.test(value)) {
                    localError = "NIP hanya boleh angka.";
                } else if (!value.startsWith('7501')) {
                    localError = "NIP harus diawali dengan 7501.";
                } else if (value.length < 10 || value.length > 12) {
                    localError = "NIP minimal 10 digit dan maksimal 12 digit.";
                } else {
                    const agensiPart = idAgensi.substring(4); // digit ke-5 dst dari id_agensi
                    const after6th = value.substring(6); // digit ke-7 dst dari NIP
                    if (!after6th.startsWith(agensiPart)) {
                        localError = `NIP harus menyisipkan ID Agensi (${agensiPart}) setelah digit ke-6.`;
                    }
                }
            }

            if (localError) {
                errorDiv.textContent = localError;
                return;
            } else {
                errorDiv.textContent = '';
            }

            // ✅ Jika lolos validasi lokal, cek ke server (AJAX) untuk memastikan unik
            fetch(`/check-nip?nip=${value}`)
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        errorDiv.textContent = "NIP sudah ada.";
                    } else {
                        errorDiv.textContent = '';
                    }
                })
                .catch(err => {
                    console.error(err);
                    errorDiv.textContent = "Terjadi kesalahan server.";
                });


            // Nama Pemilik, PIC Utama, Wakil PIC: hanya huruf dan spasi
            if (['nama_pemilik', 'nama_pic_utama', 'nama_wakil_pic'].includes(fieldName)) {
                if (!/^[A-Za-z\s]+$/.test(value)) {
                    localError = "Hanya boleh huruf dan spasi, tanpa angka atau simbol.";
                }
            }

            // Email Agensi: harus mengandung @
            if (fieldName === 'email_agensi') {
                if (!value.includes('@')) {
                    localError = "Email harus mengandung @ dan domain. Contoh : contoh@gmail.com";
                }
            }

            if (localError) {
                errorDiv.textContent = localError;
                field.classList.add('border-red-500');
                return;
            }

            // Jika lolos validasi lokal, lakukan check duplicate AJAX
            fetch(`{{ route('check-field-duplicate') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ field: fieldName, value: value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.exists) {
                    errorDiv.textContent = `${fieldName.replace('_', ' ')} sudah terdaftar.`;
                    field.classList.add('border-red-500');
                } else {
                    errorDiv.textContent = '';
                    field.classList.remove('border-red-500');
                }
            })
            .catch(error => {
                console.error(error);
                errorDiv.textContent = "Terjadi kesalahan saat pengecekan.";
                field.classList.add('border-red-500');
            });
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const telpFields = [
        'telp_pic_utama',
        'telp_wakil_pic',
        'telp_agensi'
    ];

    telpFields.forEach(name => {
        const input = document.querySelector(`input[name="${name}"]`);

        if (input) {
            input.addEventListener('blur', () => {
                let value = input.value;

                // Hapus semua karakter selain angka
                value = value.replace(/\D/g, '');

                // Ganti 62 di awal jadi 0
                if (value.startsWith('62')) {
                    value = '0' + value.slice(2);
                }

                input.value = value;
            });
        }
    });

    // === Validasi No. KTP ===
    const ktpInput = document.getElementById('no_ktp');
    const errorKTP = document.getElementById('error-ktp');

    if (ktpInput) {
        ktpInput.addEventListener('blur', () => {
            let value = ktpInput.value.replace(/\D/g, ''); // hanya angka
            if (value.length !== 16) {
                errorKTP.classList.remove('hidden');
                ktpInput.classList.add('border-red-500');
            } else {
                errorKTP.classList.add('hidden');
                ktpInput.classList.remove('border-red-500');
                ktpInput.value = value; // pastikan sudah bersih dari strip/spasi
            }
        });
    }
});
</script>
  
  
<script>
function validateNameInput(inputId, errorId) {
    const inputElement = document.getElementById(inputId);
    const errorElement = document.getElementById(errorId);

    inputElement.addEventListener('blur', function() {
        const value = this.value;
        const regex = /^[A-Za-z\s]+$/;

        if (!regex.test(value)) {
            errorElement.classList.remove('hidden');
        } else {
            errorElement.classList.add('hidden');
        }
    });
}

validateNameInput('nama_pemilik', 'error_nama_pemilik');
validateNameInput('nama_pic_utama', 'error_nama_pic_utama');
validateNameInput('nama_wakil_pic', 'error_nama_wakil_pic');
</script>

<script>
document.getElementById('email_agensi').addEventListener('blur', function() {
    const value = this.value;
    const errorElement = document.getElementById('error_email_agensi');

    if (!value.includes('@')) {
        errorElement.classList.remove('hidden');
    } else {
        errorElement.classList.add('hidden');
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const badanUsahaSelect = document.getElementById('badan_usaha');
    const dokumenSelect = document.getElementById('dokumen_legasitas');
    const uploadDiv = document.getElementById('upload_dokumen_div');
    const uploadInput = document.getElementById('kontrak_psm');

    badanUsahaSelect.addEventListener('change', function() {
        const badanUsaha = this.value;

        if (badanUsaha === 'Perorangan') {
            dokumenSelect.value = 'Tidak Terlampir';
            dokumenSelect.setAttribute('readonly', true);
            dokumenSelect.setAttribute('disabled', true);

            // Sembunyikan upload file dan hapus required
            uploadDiv.classList.add('hidden');
            uploadInput.removeAttribute('required');
        } else if (badanUsaha === 'CV' || badanUsaha === 'PT' || badanUsaha === 'UD') {
            dokumenSelect.value = 'Terlampir';
            dokumenSelect.removeAttribute('readonly');
            dokumenSelect.removeAttribute('disabled');

            // Tampilkan upload file dan set required
            uploadDiv.classList.remove('hidden');
            uploadInput.setAttribute('required', true);
        } else {
            // Jika badan usaha kosong atau lainnya
            dokumenSelect.value = '';
            dokumenSelect.removeAttribute('readonly');
            dokumenSelect.removeAttribute('disabled');
            uploadDiv.classList.add('hidden');
            uploadInput.removeAttribute('required');
        }
    });
});
</script>


@endsection
