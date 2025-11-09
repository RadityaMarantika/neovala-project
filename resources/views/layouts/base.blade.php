<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ asset('/assets/img/psm_tpj.png') }}" rel="icon">
    <title>Lavanna Deva Perkasa - System Management </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts & Tailwind -->
    <link href="{{ asset('/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,400,600,700,800,900" rel="stylesheet">


    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- SB-Admin-2 CSS -->
    <link href="{{ asset('/assets/css/sb-admin-2.css') }}" rel="stylesheet">

    @php
        $isProduction = app()->environment('production');
        $manifestPath = $isProduction ? '../public_html/build/manifest.json' : public_path('build/manifest.json');
    @endphp

    @if ($isProduction && file_exists($manifestPath))
        @php $manifest = json_decode(file_get_contents($manifestPath), true); @endphp
        <link rel="stylesheet" href="{{ config('app.url') }}/build/{{ $manifest['resources/css/app.css']['file'] }}">
        <script type="module" src="{{ config('app.url') }}/build/{{ $manifest['resources/js/app.js']['file'] }}"></script>
    @else
        @viteReactRefresh
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @endif
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-orange" id="accordionSidebar">
            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
                <div class="sidebar-brand-text mx-3">LDP Works<sup> app</sup></div>
            </a>

            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <!-- ====================== EMPLOYEE SECTION ====================== -->
            <div class="sidebar-heading">
                For Employee Work
            </div>

            <!-- Employee -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layout-menus.karyawan') }}">
                    <i class="zmdi zmdi-folder"></i>
                    <span>Employee</span>
                </a>
            </li>

            <!-- Human Resource -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layout-menus.hr') }}">
                    <i class="zmdi zmdi-folder"></i>
                    <span>Human Resource</span>
                </a>
            </li>

            <!-- Finance -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layout-menus.finance') }}">
                    <i class="zmdi zmdi-folder"></i>
                    <span>Finance</span>
                </a>
            </li>

            <!-- Inventori -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layout-menus.inventori') }}">
                    <i class="zmdi zmdi-folder"></i>
                    <span>Inventory</span>
                </a>
            </li>

            <!-- Inventori -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('layout-menus.rental') }}">
                    <i class="zmdi zmdi-folder"></i>
                    <span>Rental Unit</span>
                </a>
            </li>

            <!-- ====================== PRESENT SECTION ====================== -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePresent"
                    aria-expanded="false" aria-controls="collapsePresent">
                    <i class="fas fa-user-check"></i>
                    <span>Present</span>
                </a>

                <div id="collapsePresent" class="collapse" aria-labelledby="headingPresent"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <!-- Attending Entry -->
                        <a class="collapse-item" href="{{ route('absensi.masuk.create') }}">
                            <i class="fas fa-user-check fa-sm fa-fw mr-2 text-success"></i>
                            Attending Entry
                        </a>

                        <!-- Attending Home -->
                        <a class="collapse-item" href="{{ route('absensi.pulang.create') }}">
                            <i class="fas fa-door-open fa-sm fa-fw mr-2 text-danger"></i>
                            Attending Home
                        </a>

                        <!-- Schedule -->
                        <a class="collapse-item" href="{{ route('karyawan.jadwal') }}">
                            <i class="fas fa-calendar-day fa-sm fa-fw mr-2 text-warning"></i>
                            Schedule
                        </a>

                        <!-- Change Schedule -->
                        <a class="collapse-item" href="{{ route('tukar-shift.index') }}">
                            <i class="fas fa-envelope-open-text fa-sm fa-fw mr-2 text-primary"></i>
                            Change Schedule
                        </a>

                        <!-- Attending Form -->
                        <a class="collapse-item" href="{{ route('pengajuan-shift.create') }}">
                            <i class="fas fa-envelope-open-text fa-sm fa-fw mr-2 text-primary"></i>
                            Attending Form
                        </a>
                    </div>
                </div>
            </li>


            <!-- ================= ABSENT PERMISSIONS ================= -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAP">
                    <i class="fas fa-user-slash"></i> {{-- icon utama Absent Permissions --}}
                    <span>My Work Overtime</span>
                </a>
                <div id="collapseAP" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">

                        {{-- Work Overtime Form --}}
                        <a class="collapse-item" href="{{ route('lembur.create') }}">
                            <i class="fas fa-business-time fa-sm fa-fw mr-2 text-warning"></i>
                            Work Overtime Form
                        </a>
                        <a class="collapse-item" href="{{ route('lembur.my') }}">
                            <i class="fas fa-search fa-sm fa-fw mr-2 text-yellow-500"></i>
                            Work Overtime Check
                        </a>
                    </div>
                </div>
            </li>

            <!-- ================= MY COOPERATIVE ================= -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMC">
                    <i class="fas fa-handshake"></i> {{-- icon utama My Cooperative --}}
                    <span>My Cooperative</span>
                </a>
                <div id="collapseMC" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">

                        {{-- My Saving --}}
                        <a class="collapse-item" href="{{ route('koperasi.tabungan.index') }}">
                            <i class="fas fa-piggy-bank fa-sm fa-fw mr-2 text-success"></i>
                            My Saving
                        </a>

                        {{-- My Loan --}}
                        <a class="collapse-item" href="{{ route('koperasi.pinjaman.index') }}">
                            <i class="fas fa-hand-holding-usd fa-sm fa-fw mr-2 text-info"></i>
                            My Loan
                        </a>
                    </div>
                </div>
            </li>





            {{--
        <!-- Petty Cash -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePettyCash" aria-expanded="false">
                <i class="fas fa-wallet"></i>
                <span>Petty Cash</span>
            </a>
            <div id="collapsePettyCash" class="collapse" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('petty_cash.index') }}">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Daftar Transaksi
                    </a>
                    <a class="collapse-item" href="{{ route('petty_cash.create') }}">
                        <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                        Tambah Transaksi
                    </a>
                </div>
            </div>
        </li>
        --}}



            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Employee Management
            </div>

            <!-- Shifting -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShiftt"
                    aria-expanded="true" aria-controls="collapseShiftt">
                    <i class="fas fa-sync-alt"></i>
                    <span>Absent & Shift</span>
                </a>
                <div id="collapseShiftt" class="collapse" aria-labelledby="headingShiftt"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        <a class="collapse-item" href="{{ route('shifts.index') }}">
                            <i class="fas fa-clock fa-sm fa-fw mr-2 text-blue-500"></i> Shifts
                        </a>
                        <a class="collapse-item" href="{{ route('shifts.generateForm') }}">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-indigo-500"></i> Generate Shifts
                        </a>
                        <a class="collapse-item" href="{{ route('absensi.index', ['Shiftt' => 1]) }}">
                            <i class="fas fa-clipboard-check fa-sm fa-fw mr-2 text-yellow-500"></i> Check Absent Shift
                        </a>
                        <a class="collapse-item" href="{{ route('pengajuan-shift.index') }}">
                            <i class="fas fa-file-signature fa-sm fa-fw mr-2 text-red-500"></i> Permission Approval
                        </a>
                        <a class="collapse-item" href="{{ route('karyawan.reporting') }}">
                            <i class="fas fa-chart-line fa-sm fa-fw mr-2 text-green-500"></i> Reporting
                        </a>
                    </div>
                </div>
            </li>

            <!-- Work Overtime -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWO">
                    <i class="fas fa-business-time"></i>
                    <span>Work Overtime</span>
                </a>
                <div id="collapseWO" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        <a class="collapse-item" href="{{ route('lembur.index') }}">
                            <i class="fas fa-check-circle fa-sm fa-fw mr-2 text-green-500"></i> Approval List
                        </a>
                    </div>
                </div>
            </li>

            <!-- Warning Letter -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWR">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Warning Letter</span>
                </a>
                <div id="collapseWR" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        <a class="collapse-item" href="{{ route('pelanggaran.create') }}">
                            <i class="fas fa-plus-circle fa-sm fa-fw mr-2 text-blue-500"></i> Warning Letter Form
                        </a>
                        <a class="collapse-item" href="{{ route('pelanggaran.index') }}">
                            <i class="fas fa-folder-open fa-sm fa-fw mr-2 text-purple-500"></i> Warning Letter List
                        </a>
                        <a class="collapse-item" href="{{ route('pelanggaran.summary') }}">
                            <i class="fas fa-chart-pie fa-sm fa-fw mr-2 text-green-500"></i> Reporting
                        </a>
                    </div>
                </div>
            </li>


            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Finance Management
            </div>

            <!-- Petty Cash -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePettyCash"
                    aria-expanded="false">
                    <i class="fas fa-wallet"></i>
                    <span>Petty Cash</span>
                </a>
                <div id="collapsePettyCash" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        <a class="collapse-item" href="{{ route('master-pettycash.index') }}">
                            <i class="fas fa-clipboard-list fa-sm fa-fw mr-2 text-blue-500"></i>
                            Petty Cash List
                        </a>
                        <a class="collapse-item" href="{{ route('transaksi-pettycash.index') }}">
                            <i class="fas fa-exchange-alt fa-sm fa-fw mr-2 text-green-500"></i>
                            Transactions
                        </a>
                        <a class="collapse-item" href="{{ route('transaksi_saldo_pettycash.index') }}">
                            <i class="fas fa-exchange-alt fa-sm fa-fw mr-2 text-green-500"></i>
                            Top Up
                        </a>
                        <a class="collapse-item" href="{{ route('report-pettycash.index') }}">
                            <i class="fas fa-exchange-alt fa-sm fa-fw mr-2 text-green-500"></i>
                            Reporting
                        </a>
                    </div>
                </div>
            </li>

            <!-- Cooperative -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKoperasi"
                    aria-expanded="false" aria-controls="collapseKoperasi">
                    <i class="fas fa-piggy-bank"></i>
                    <span>Cooperative</span>
                </a>
                <div id="collapseKoperasi" class="collapse" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        <a class="collapse-item" href="{{ route('koperasi.account.index') }}">
                            <i class="fas fa-users-cog fa-sm fa-fw mr-2 text-indigo-500"></i>
                            Cooperative Account
                        </a>
                        <a class="collapse-item" href="{{ route('koperasi.tabungan.hr.index') }}">
                            <i class="fas fa-hand-holding-heart fa-sm fa-fw mr-2 text-purple-500"></i>
                            Approval Saving
                        </a>
                        <a class="collapse-item" href="{{ route('koperasi.pinjaman.hr.index') }}">
                            <i class="fas fa-hand-holding-usd fa-sm fa-fw mr-2 text-yellow-500"></i>
                            Approval Loan
                        </a>
                    </div>
                </div>
            </li>

            <!-- Payroll -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayroll"
                    aria-expanded="false" aria-controls="collapsePayroll">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Payroll</span>
                </a>
                <div id="collapsePayroll" class="collapse" aria-labelledby="headingPayroll"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                        {{--
                    <h6 class="collapse-header text-primary font-weight-bold">Menu Payroll:</h6>
                    --}}
                        <a class="collapse-item" href="{{ route('master-payroll.index') }}">
                            <i class="fas fa-user-tie fa-sm fa-fw mr-2 text-blue-500"></i>
                            Employee Payroll
                        </a>

                        <a class="collapse-item" href="{{ route('pembayaran-payroll.index') }}">
                            <i class="fas fa-credit-card fa-sm fa-fw mr-2 text-green-500"></i>
                            Transactions Payroll
                        </a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Inventory Management
            </div>

            <!-- Data Inventori -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventory"
                    aria-expanded="false" aria-controls="collapseInventory">
                    <i class="fas fa-boxes"></i>
                    <span>Inventory Fitur</span>
                </a>
                <div id="collapseInventory" class="collapse" aria-labelledby="headingInventory"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu Inventory:</h6>

                        <a class="collapse-item" href="{{ route('master_gudang.index') }}">
                            <i class="fas fa-warehouse fa-sm fa-fw mr-2 text-gray-400"></i>
                            Warehouse
                        </a>

                        <a class="collapse-item" href="{{ route('master_inventori.index') }}">
                            <i class="fas fa-box fa-sm fa-fw mr-2 text-gray-400"></i>
                            Inventory
                        </a>

                        <a class="collapse-item" href="{{ route('master_inventori_gudang.index') }}">
                            <i class="fas fa-dolly fa-sm fa-fw mr-2 text-gray-400"></i>
                            Item Warehouse
                        </a>

                        <a class="collapse-item" href="{{ route('gudang_transfer.index') }}">
                            <i class="fas fa-dolly fa-sm fa-fw mr-2 text-gray-400"></i>
                            Item Transactions
                        </a>

                        <a class="collapse-item" href="{{ route('purchase-orders.index') }}">
                            <i class="fas fa-dolly fa-sm fa-fw mr-2 text-gray-400"></i>
                            PO
                        </a>

                        <a class="collapse-item" href="{{ route('gudang-ambils.index') }}">
                            <i class="fas fa-dolly fa-sm fa-fw mr-2 text-gray-400"></i>
                            Take Item
                        </a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Rental Management
            </div>

            <!-- Data Inventori -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRUU"
                    aria-expanded="false" aria-controls="collapseRUU">
                    <i class="fas fa-boxes"></i>
                    <span>Rent Unit</span>
                </a>
                <div id="collapseRUU" class="collapse" aria-labelledby="headingRUU" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="{{ route('master_regions.index') }}">
                            <i class="fas fa-warehouse fa-sm fa-fw mr-2 text-gray-400"></i>
                            Region
                        </a>

                        <a class="collapse-item" href="{{ route('master_units.index') }}">
                            <i class="fas fa-warehouse fa-sm fa-fw mr-2 text-gray-400"></i>
                            Data Unit
                        </a>

                        <a class="collapse-item" href="{{ route('master_unit_sewas.index') }}">
                            <i class="fas fa-box fa-sm fa-fw mr-2 text-gray-400"></i>
                            Data Sewa
                        </a>

                        <a class="collapse-item" href="{{ route('master_unit_hutangs.index') }}">
                            <i class="fas fa-dolly fa-sm fa-fw mr-2 text-gray-400"></i>
                            Data Hutang
                        </a>

                    </div>
                </div>
            </li>


            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                User Access & Data Master
            </div>

            <!-- Utilities Access -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseUtilities">
                    <i class="fas fa-fw fa-tools"></i>
                    <span>Utilities Access</span>
                </a>
                <div id="collapseUtilities" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('users.index') }}">Users</a>
                        <a class="collapse-item" href="{{ route('role.index') }}">Roles</a>
                        <a class="collapse-item" href="{{ route('permission.index') }}">Permissions</a>
                        <a href="{{ route('register') }}"class="collapse-item">Register</a>


                    </div>
                </div>
            </li>

            <!-- Data Master -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#collapseDataMaster">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Data Master</span>
                </a>
                <div id="collapseDataMaster" class="collapse">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#"><i
                                class="fas fa-circle fa-sm fa-fw mr-2 text-gray-400"></i>Master Unit</a>
                        <a class="collapse-item" href="#"><i
                                class="fas fa-circle fa-sm fa-fw mr-2 text-gray-400"></i>Master Rental</a>
                        <a class="collapse-item" href="#"><i
                                class="fas fa-circle fa-sm fa-fw mr-2 text-gray-400"></i>Master Customer</a>
                        <a class="collapse-item" href="{{ route('master_karyawan.index') }}"><i
                                class="fas fa-circle fa-sm fa-fw mr-2 text-gray-400"></i>Master Karyawan</a>
                        <a class="collapse-item" href="{{ route('master_shifts.index') }}"><i
                                class="fas fa-circle fa-sm fa-fw mr-2 text-gray-400"></i>Master Shift</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="manualSidebarToggle"></button>
            </div>
        </ul>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm border-bottom">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Center Section: Date & Clock -->
                    <div class="mx-auto text-right d-none d-md-block">
                        <span class="text-gray-700 small font-weight-semibold">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            | <span id="clock" class="text-dark font-weight-bold"></span>
                        </span>
                    </div>

                    <!-- Right Section: User Info -->
                    <ul class="navbar-nav ml-auto align-items-center">

                        <!-- Divider -->
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- User Information Dropdown -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="text-right mr-2">
                                    <span class="text-gray-800 small font-weight-bold d-block">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="text-muted small">Account</span>
                                </div>
                                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center"
                                    style="width: 35px; height: 35px;">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                            </a>

                            <!-- Dropdown Menu -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <x-dropdown-link :href="route('profile.edit')">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                                </x-dropdown-link>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Log Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Script: Live Clock -->
                <script>
                    function updateClock() {
                        const now = new Date();
                        const h = String(now.getHours()).padStart(2, '0');
                        const m = String(now.getMinutes()).padStart(2, '0');
                        const s = String(now.getSeconds()).padStart(2, '0');
                        document.getElementById('clock').textContent = `${h}:${m}:${s}`;
                    }
                    setInterval(updateClock, 1000);
                    updateClock();
                </script>




                <!-- Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center">
                        <span>Copyright &copy; LDP WORKS 2025</span><br>
                        <span>Fullstack Developer | ToeDev.id</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('/assets/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    {{-- Tambahkan style kecil agar tampilan lebih enak --}}
    <style>
        .select2-container .select2-selection--single {
            height: 45px !important;
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #ced4da;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("accordionSidebar");
            const sidebarOverlay = document.getElementById("sidebarOverlay");
            const sidebarToggleTop = document.getElementById("sidebarToggleTop"); // Mobile toggle button
            const manualToggle = document.getElementById("manualSidebarToggle"); // Desktop toggle

            // Desktop toggle
            if (manualToggle) {
                manualToggle.addEventListener("click", function() {
                    sidebar.classList.toggle("toggled");
                    sidebar.classList.remove("mobile-show");
                    sidebarOverlay.classList.add("hidden");
                });
            }

            // Mobile toggle
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener("click", function() {
                    sidebar.classList.toggle("mobile-show");
                    sidebarOverlay.classList.toggle("hidden");
                    sidebar.classList.remove("toggled");
                });
            }

            // Klik overlay untuk tutup (mobile only)
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener("click", function() {
                    sidebar.classList.remove("mobile-show");
                    sidebarOverlay.classList.add("hidden");
                });
            }

            // Scroll auto-close (mobile only)
            window.addEventListener("scroll", function() {
                if (window.innerWidth <= 768 && sidebar.classList.contains("mobile-show")) {
                    sidebar.classList.remove("mobile-show");
                    sidebarOverlay.classList.add("hidden");
                }
            });
        });
    </script>




    <style>
        /* === Samakan tampilan sidebar mobile dengan desktop === */
        @media (max-width: 768px) {
            #accordionSidebar .nav-item .nav-link {
                flex-direction: row !important;
                align-items: center !important;
                justify-content: flex-start !important;
                padding: 0.75rem 1rem;
                text-align: left;
                gap: 10px;
            }

            #accordionSidebar .nav-item .nav-link i {
                font-size: 1rem;
                margin-bottom: 0 !important;
            }

            #accordionSidebar .nav-item .nav-link span {
                font-size: 0.85rem;
                display: inline !important;
            }

            #accordionSidebar .sidebar-brand {
                flex-direction: row !important;
                justify-content: center;
            }

            #accordionSidebar .sidebar-brand-text {
                display: block !important;
                font-size: 1rem;
                color: white;
                margin-left: 0.5rem;
            }
        }

        /* --- SIDEBAR MOBILE --- */
        @media (max-width: 768px) {
            #accordionSidebar {
                position: fixed;
                z-index: 60;
                /* kasih lebih tinggi dari overlay */
                width: 250px;
                height: 100%;
                left: -260px;
                top: 0;
                transition: left 0.3s ease-in-out;
                background-color: #4e73df;
            }

            #accordionSidebar.mobile-show {
                left: 0;
            }

            #content-wrapper {
                margin-left: 0 !important;
            }

            #sidebarOverlay {
                z-index: 50;
                /* lebih rendah dari sidebar */
                background: rgba(0, 0, 0, 0.3);
                /* lebih tipis biar konten masih kelihatan */
                transition: background 0.3s ease;
            }

            /* Samakan tampilan icon dan teks seperti desktop */
            #accordionSidebar .nav-item .nav-link {
                flex-direction: row !important;
                align-items: center !important;
                justify-content: flex-start !important;
                padding: 0.75rem 1rem;
                text-align: left;
                gap: 10px;
            }

            #accordionSidebar .nav-item .nav-link i {
                font-size: 1rem;
                margin-bottom: 0 !important;
            }

            #accordionSidebar .nav-item .nav-link span {
                font-size: 0.85rem;
                display: inline !important;
            }

            #accordionSidebar .sidebar-brand {
                flex-direction: row !important;
                justify-content: center;
            }

            #accordionSidebar .sidebar-brand-text {
                display: block !important;
                font-size: 1rem;
                color: white;
                margin-left: 0.5rem;
            }
        }

        /* Custom tebalin garis pemisah sidebar */
        .sidebar-divider {
            border-top: 2pt solid rgba(255, 255, 255, 0.3) !important;
            /* warna putih semi transparan */
            margin: 0.75rem 1rem;
            /* biar ada spasi kiri kanan */
        }

        /* === Custom Sidebar Gradient Orange === */
        .bg-gradient-orange {
            background: linear-gradient(135deg, #4c6ef5, #6a11cb);
        }

        /* Pastikan teks tetap putih dan kontras */
        .bg-gradient-orange .nav-link,
        .bg-gradient-orange .sidebar-brand-text {
            color: #fff !important;
        }

        /* Hover effect lebih elegan */
        .bg-gradient-orange .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15) !important;
            border-radius: 6px;
        }

        /* --- SIDEBAR DESKTOP MINIMIZED --- */
        .sidebar.toggled {
            width: 80px !important;
        }

        .sidebar.toggled .nav-item .nav-link span {
            display: none;
        }

        .sidebar.toggled .sidebar-brand-text {
            display: block !important;
            font-size: 0.7rem;
            color: white;
            text-align: center;
            padding: 0 4px;
            white-space: nowrap;
            overflow: hidden;
        }

        /* PSM-TPJ tetap tampil */
        .sidebar .sidebar-brand-text {
            display: block;
            font-weight: bold;
            font-size: 1rem;
            color: white;
            text-align: center;
        }

        /* Brand tetap tampil di semua mode */
        .sidebar .sidebar-brand {
            display: flex !important;
            align-items: center;
            justify-content: center;
            height: 60px;
        }

        .sidebar .sidebar-brand-text {
            display: block !important;
            font-weight: bold;
            font-size: 1rem;
            color: white;
            white-space: nowrap;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #09172B;
            /* abu abu gelap */
        }

        /* Sidebar item tetap sejajar icon + teks (mode mobile juga) */
        #accordionSidebar .nav-item .nav-link {
            display: flex;
            flex-direction: row !important;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            color: white;
            text-align: left;
            white-space: nowrap;
        }

        /* Icon */
        #accordionSidebar .nav-item .nav-link i {
            font-size: 1rem;
            margin-bottom: 0 !important;
        }

        /* Text */
        #accordionSidebar .nav-item .nav-link span {
            font-size: 0.85rem;
            display: inline !important;
        }

        /* Hover effect */
        #accordionSidebar .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        /* Mobile juga ikut tampilan horizontal */
        @media (max-width: 768px) {
            #accordionSidebar .nav-item .nav-link {
                justify-content: flex-start;
            }

            #accordionSidebar .sidebar-brand {
                justify-content: center;
            }

            #accordionSidebar .sidebar-brand-text {
                display: block !important;
                font-size: 1rem;
                color: white;
                margin-left: 0.5rem;
            }
        }

        /* Biar icon arrow submenu tetap di kanan */
        #accordionSidebar .nav-item .nav-link .collapse-arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        /* Saat submenu terbuka, arahkan panah ke bawah */
        #accordionSidebar .nav-item .nav-link[aria-expanded="true"] .collapse-arrow {
            transform: rotate(180deg);
        }

        /* Perbaiki ukuran panah kalau pakai FontAwesome */
        #accordionSidebar .nav-item .nav-link i.fa-angle-down,
        #accordionSidebar .nav-item .nav-link i.fa-chevron-down {
            margin-left: auto;
            font-size: 0.8rem;
            color: #fff;
        }
    </style>


    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

</body>

</html>
