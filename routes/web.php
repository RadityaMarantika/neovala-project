<?php

// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterKaryawanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\MasterShiftController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\PengajuanShiftController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\KoperasiController;
use App\Http\Controllers\KoperasiKaryawanController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\MasterPayrollController;
use App\Http\Controllers\PembayaranPayrollController;
use App\Http\Controllers\MasterPettycashController;
use App\Http\Controllers\TransaksiPettycashController;
use App\Http\Controllers\TransaksiSaldoPettycashController;
use App\Http\Controllers\MasterGudangController;
use App\Http\Controllers\MasterInventoriController;
use App\Http\Controllers\MasterInventoriGudangController;
use App\Http\Controllers\GudangTransferController;
use App\Http\Controllers\TukarShiftController;
use App\Http\Controllers\PettycashReportController;
use App\Http\Controllers\KategoriPettycashController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GudangAmbilController;

use App\Http\Controllers\MasterRegionController;
use App\Http\Controllers\MasterUnitController;
use App\Http\Controllers\MasterUnitSewaController;
use App\Http\Controllers\MasterUnitHutangController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Spatie\Permission\Contracts\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    
    Route::get('/karyawan-fitur', function () {return view('layout-menus.karyawan');})->name('layout-menus.karyawan');
    Route::get('/humanresource-fitur', function () {return view('layout-menus.hr');})->name('layout-menus.hr');
    Route::get('/finance-fitur', function () {return view('layout-menus.finance');})->name('layout-menus.finance');
    Route::get('/inventori-fitur', function () {return view('layout-menus.inventori');})->name('layout-menus.inventori');
    Route::get('/rental-fitur', function () {return view('layout-menus.rental');})->name('layout-menus.rental');

    //User Account Routes (Login, Register, Logout)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');

    ///Permission Routes
    Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission', [PermissionController::class, 'delete'])->name('permission.delete');

    
    ///Role Routes
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role', [RoleController::class, 'delete'])->name('role.delete');


    
    ///Karyawan Routes
    Route::resource('master_karyawan', MasterKaryawanController::class);

    ///Absensi & Shift Routes
    Route::middleware(['auth'])->group(function () {

        // Shifts
        Route::resource('shifts', ShiftController::class)->except(['show']);
        Route::get('shifts/generate', [ShiftController::class, 'generateForm'])->name('shifts.generateForm');
        Route::post('shifts/generate', [ShiftController::class, 'storeGenerate'])->name('shifts.storeGenerate');


        // Absensi Masuk
        Route::get('/absensi/masuk', [AbsensiController::class, 'createMasuk'])->name('absensi.masuk.create');
        Route::post('/absensi/masuk', [AbsensiController::class, 'storeMasuk'])->name('absensi.masuk.store');

        // Absensi Pulang
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/pulang', [AbsensiController::class, 'createPulang'])->name('absensi.pulang.create');
        Route::post('/absensi/pulang', [AbsensiController::class, 'storePulang'])->name('absensi.pulang.store');

        // Detail
        Route::get('/absensi/{absensi}', [AbsensiController::class, 'show'])->name('absensi.show');

        // Admin override status
        Route::post('/absensi/{absensi}/admin-update-masuk', [AbsensiController::class, 'adminUpdateMasuk'])->name('absensi.admin.update.masuk');
        Route::post('/absensi/{absensi}/admin-update-pulang', [AbsensiController::class, 'adminUpdatePulang'])->name('absensi.admin.update.pulang');
    });

    Route::middleware(['auth'])->group(function(){
        Route::resource('master_shifts', MasterShiftController::class);
    });

    Route::get('/karyawan/jadwal', [KaryawanController::class, 'jadwalShifts'])->name('karyawan.jadwal');
    Route::prefix('karyawan/reporting')->group(function () {
        Route::get('/', [KaryawanController::class, 'reporting'])->name('karyawan.reporting');
        Route::get('/export-excel', [KaryawanController::class, 'exportExcel'])->name('karyawan.reporting.excel');
        Route::get('/export-pdf', [KaryawanController::class, 'exportPdf'])->name('karyawan.reporting.pdf');
    });
    Route::post('/karyawan/update-status', [KaryawanController::class, 'updateStatus'])->name('karyawan.updateStatus');



    /// Pelanggaran Routes
    Route::get('pelanggaran/{id}/file', [PelanggaranController::class, 'viewFile'])->name('pelanggaran.viewFile');
    Route::get('pelanggaran/summary', [PelanggaranController::class, 'summary'])->name('pelanggaran.summary');
    Route::resource('pelanggaran', PelanggaranController::class);


    /// Lembur Routes
    Route::middleware(['auth'])->group(function () {
        Route::resource('lembur', LemburController::class);

        Route::post('lembur/{id}/accept', [LemburController::class, 'accept'])->name('lembur.accept');
        Route::post('lembur/{id}/reject', [LemburController::class, 'reject'])->name('lembur.reject');
        Route::post('lembur/{id}/start', [LemburController::class, 'start'])->name('lembur.start');
        Route::post('lembur/{id}/done', [LemburController::class, 'done'])->name('lembur.done');

        
        // khusus karyawan login untuk data lemburan
        Route::get('my-lembur', [LemburController::class, 'myLembur'])->name('lembur.my');



    });


    // Pengajuan Shift ( izin, sakit )
        Route::prefix('pengajuan-shift')->middleware('auth')->group(function () {
        Route::get('/', [PengajuanShiftController::class, 'index'])->name('pengajuan-shift.index');
        Route::get('/create', [PengajuanShiftController::class, 'create'])->name('pengajuan-shift.create');
        Route::post('/', [PengajuanShiftController::class, 'store'])->name('pengajuan-shift.store');
        Route::post('/{pengajuan}/approve', [PengajuanShiftController::class, 'approve'])->name('pengajuan-shift.approve');
        Route::post('/{pengajuan}/reject', [PengajuanShiftController::class, 'reject'])->name('pengajuan-shift.reject');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/tukar-shift', [TukarShiftController::class, 'index'])->name('tukar-shift.index');
    Route::post('/tukar-shift', [TukarShiftController::class, 'tukar'])->name('tukar-shift.store');
});


    // Petty Cash
    Route::resource('petty_cash', PettyCashController::class);



    // Koperasi Simpan Pinjam
    Route::prefix('koperasi')->middleware('auth')->group(function () {
        // Tabungan Saya
        Route::get('/tabungan', [KoperasiKaryawanController::class, 'indexTabungan'])
            ->name('koperasi.tabungan.index');
        Route::get('/tabungan/create/{accountId}', [KoperasiKaryawanController::class, 'createTabungan'])
            ->name('koperasi.tabungan.create');
        Route::post('/tabungan/{accountId}/store', [KoperasiKaryawanController::class, 'storeTabungan'])
            ->name('koperasi.tabungan.store');

        // Pinjaman Saya
        Route::get('/pinjaman', [KoperasiKaryawanController::class, 'indexPinjaman'])
            ->name('koperasi.pinjaman.index');
        Route::get('/pinjaman/create/{accountId}', [KoperasiKaryawanController::class, 'createPinjaman'])
            ->name('koperasi.pinjaman.create');
        Route::post('/pinjaman/{accountId}/store', [KoperasiKaryawanController::class, 'storePinjaman'])
            ->name('koperasi.pinjaman.store');
        Route::get('available-karyawan/{jenis}', [KoperasiController::class, 'getAvailableKaryawan'])
            ->name('koperasi.available-karyawan');


    });

    // =========================
    // HR
    // =========================
    Route::prefix('koperasi/hr')->middleware('auth')->group(function () {
        // Kelola Akun
        Route::get('/accounts', [KoperasiController::class, 'indexAccounts'])
            ->name('koperasi.account.index');
        Route::post('/account/create', [KoperasiController::class, 'createAccount'])
            ->name('koperasi.account.create');

        // Approve Tabungan
        Route::get('/tabungan', [KoperasiController::class, 'indexTabungan'])
            ->name('koperasi.tabungan.hr.index');
        Route::post('/tabungan/{id}/approve', [KoperasiController::class, 'approveTabungan'])
            ->name('koperasi.tabungan.approve');

        // Approve Pinjaman
        Route::get('/pinjaman', [KoperasiController::class, 'indexPinjaman'])
            ->name('koperasi.pinjaman.hr.index');
        Route::post('/pinjaman/{id}/approve', [KoperasiController::class, 'approvePinjaman'])
            ->name('koperasi.pinjaman.approve');
    });


    Route::resource('payroll', PayrollController::class);

        // Master payroll
    Route::resource('master-payroll', MasterPayrollController::class);
    // Pembayaran payroll
    Route::resource('pembayaran-payroll', PembayaranPayrollController::class);
    Route::get('/master-payroll/fetch-data/{karyawan_id}', [MasterPayrollController::class, 'fetchData'])->name('master-payroll.fetchData');
    Route::get('/pembayaran-payrolls/get-penalties/{karyawan_id}/{bulan}', [PembayaranPayrollController::class, 'getPenalties'])->name('pembayaran-payrolls.getPenalties');

    // web.php
    Route::get('/pembayaran-payrolls/get-loan-data/{karyawan_id}', [PembayaranPayrollController::class, 'getLoanData']);
    Route::post('/pembayaran-payrolls/{id}/approve', [PembayaranPayrollController::class, 'approve'])->name('pembayaran-payroll.approve');
    // Transfer Payroll
    Route::post('/pembayaran-payrolls/transfer/{id}', [PembayaranPayrollController::class, 'transfer'])
        ->name('pembayaran-payrolls.transfer');

    Route::resource('transaksi_saldo_pettycash', TransaksiSaldoPettycashController::class);


    Route::middleware(['auth'])->group(function () {
        Route::resource('master-pettycash', MasterPettycashController::class);
        Route::resource('transaksi-pettycash', TransaksiPettycashController::class);
    });
    // ========================= REPORT PETTY CASH =========================
    Route::prefix('report-pettycash')->name('report-pettycash.')->group(function () {
        Route::get('/', [PettycashReportController::class, 'index'])->name('index'); // halaman filter/report
        Route::get('/detail/{id}', [PettycashReportController::class, 'detail'])->name('detail'); // detail per petty cash
        Route::get('/export-pdf/{id}', [PettycashReportController::class, 'exportPdf'])->name('export-pdf'); // export pdf laporan

    });

Route::get('/reports/pettycash/export', [PettycashReportController::class, 'exportPdf'])->name('pettycash.export.pdf');
Route::resource('kategori_pettycash', KategoriPettycashController::class);
Route::get('/api/subkategori/{kategori}', [KategoriPettycashController::class, 'getSubkategori']);


    Route::resource('master_gudang', MasterGudangController::class);
    Route::resource('master_inventori', MasterInventoriController::class);
    Route::resource('master_inventori_gudang', MasterInventoriGudangController::class);
    Route::get('/get-barang-belum-dimiliki', [MasterInventoriGudangController::class, 'getBarangBelumDimiliki'])
    ->name('get.barang.belumdimiliki');
    Route::get('master_inventori_gudang/{id}/edit', [MasterInventoriGudangController::class, 'edit'])->name('master_inventori_gudang.edit');



Route::resource('gudang_transfer', GudangTransferController::class);

Route::prefix('purchase-orders')->name('purchase-orders.')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create');
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('store');
    Route::post('/{id}/approve', [PurchaseOrderController::class, 'approve'])->name('approve');
    Route::post('/{id}/pembelian', [PurchaseOrderController::class, 'pembelian'])->name('pembelian');
    Route::post('/{id}/terima', [PurchaseOrderController::class, 'terimaBarang'])->name('terima');
});

Route::resource('gudang-ambils', GudangAmbilController::class);


Route::resource('master_regions', MasterRegionController::class);

// UNIT
Route::resource('master_units', MasterUnitController::class);


// UNIT SEWA
Route::resource('master_unit_sewas', MasterUnitSewaController::class);


// UNIT HUTANG
Route::resource('master_unit_hutangs', MasterUnitHutangController::class);





});

require __DIR__.'/auth.php';
