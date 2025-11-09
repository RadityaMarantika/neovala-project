@extends('layouts.base')

@section('content')
    <div class="container-fluid py-4">


        {{-- HERO CARD --}}
        <div class="card border-0 shadow-sm mb-5 hero-card text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-semibold mb-1">
                        <i class="fas fa-briefcase me-2"></i>HR Dashboard
                    </h5>
                    <p class="mb-0 small opacity-75">
                        Manage your daily activities with ease and efficiency
                    </p>
                </div>
                <i class="fas fa-chart-line fa-2x text-white-50"></i>
            </div>
        </div>

        {{-- FEATURE SECTIONS --}}
        <div class="feature-sections">

            {{-- ABSENT & SHIFT --}}
            <div class="section-card mb-5">
                <div class="section-header">
                    <i class="fas fa-clock me-2"></i>Absent & Shift
                </div>
                <div class="section-body row g-3 px-3 pb-3 pt-2">

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('shifts.index') }}">
                            <div class="icon bg-1"><i class="fas fa-business-time"></i></div>
                            <p class="title">Employee Shift</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('shifts.generateForm') }}">
                            <div class="icon bg-2"><i class="fas fa-cogs"></i></div>
                            <p class="title">Generate Shifts</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('absensi.index', ['Shiftt' => 1]) }}">
                            <div class="icon bg-3"><i class="fas fa-user-check"></i></div>
                            <p class="title">Check Shift Absen</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('pengajuan-shift.index') }}">
                            <div class="icon bg-4"><i class="fas fa-clipboard-check"></i></div>
                            <p class="title">Approval Request Shift</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('karyawan.reporting') }}">
                            <div class="icon bg-5"><i class="fas fa-chart-bar"></i></div>
                            <p class="title">Report Absension</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WARNING LETTER --}}
            <div class="section-card mb-5">
                <div class="section-header">
                    <i class="fas fa-exclamation-triangle me-2"></i>Warning Letter
                </div>
                <div class="section-body row g-3 px-3 pb-3 pt-2">

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('pelanggaran.index') }}">
                            <div class="icon bg-6"><i class="fas fa-list-alt"></i></div>
                            <p class="title">Warning Letter List</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('pelanggaran.create') }}">
                            <div class="icon bg-7"><i class="fas fa-edit"></i></div>
                            <p class="title">Warning Letter Form</p>
                        </div>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('pelanggaran.summary') }}">
                            <div class="icon bg-8"><i class="fas fa-file-alt"></i></div>
                            <p class="title">Report Warning Letter</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- OVERTIME --}}
            <div class="section-card mb-5">
                <div class="section-header">
                    <i class="fas fa-hourglass-half me-2"></i>Overtime
                </div>
                <div class="section-body row g-3 px-3 pb-3 pt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('lembur.index') }}">
                            <div class="icon bg-9"><i class="fas fa-stopwatch"></i></div>
                            <p class="title">Approval Work Overtime</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- STYLE --}}
        <style>
            /* === HERO === */
            .hero-card {
                background: linear-gradient(135deg, #4c6ef5, #6a11cb);
                border-radius: 20px;
            }

            /* === SECTION WRAPPER === */
            .section-card {
                background: #fff;
                border-radius: 16px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
                overflow: hidden;
                transition: 0.3s ease;
            }

            .section-card:hover {
                box-shadow: 0 10px 28px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }

            .section-header {
                background: linear-gradient(90deg, #4c6ef5 0%, #6a11cb 100%);
                color: #fff;
                font-weight: 600;
                padding: 10px 20px;
                font-size: 0.95rem;
                display: flex;
                align-items: center;
                letter-spacing: 0.3px;
            }

            /* === FEATURE CARD === */
            .feature-card {
                background: #fff;
                border-radius: 14px;
                padding: 14px 10px;
                box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                transition: all 0.25s ease;
                cursor: pointer;
                height: 100%;
            }

            .feature-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 10px 26px rgba(0, 0, 0, 0.12);
            }

            .feature-card .icon {
                width: 60px;
                height: 60px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1.4rem;
                margin-bottom: 8px;
            }

            .feature-card .title {
                font-size: 0.85rem;
                font-weight: 600;
                color: #444;
                margin-bottom: 0;
            }

            /* === COLOR THEMES === */
            .bg-1 {
                background: linear-gradient(135deg, #00b09b, #96c93d);
            }

            .bg-2 {
                background: linear-gradient(135deg, #f857a6, #ff5858);
            }

            .bg-3 {
                background: linear-gradient(135deg, #36d1dc, #5b86e5);
            }

            .bg-4 {
                background: linear-gradient(135deg, #ff9966, #ff5e62);
            }

            .bg-5 {
                background: linear-gradient(135deg, #00c6ff, #0072ff);
            }

            .bg-6 {
                background: linear-gradient(135deg, #43cea2, #185a9d);
            }

            .bg-7 {
                background: linear-gradient(135deg, #f7971e, #ffd200);
            }

            .bg-8 {
                background: linear-gradient(135deg, #7b42f6, #b01eff);
            }

            .bg-9 {
                background: linear-gradient(135deg, #ff8a65, #ffb74d);
            }

            @media (max-width: 768px) {
                .feature-card .icon {
                    width: 52px;
                    height: 52px;
                    font-size: 1.2rem;
                }

                .feature-card .title {
                    font-size: 0.75rem;
                }

                .section-header {
                    font-size: 0.9rem;
                    padding: 8px 16px;
                }
            }
        </style>

        {{-- SCRIPT --}}
        <script>
            document.querySelectorAll('.feature-card').forEach(card => {
                card.addEventListener('click', () => {
                    const href = card.dataset.href;
                    if (href) window.location.href = href;
                });
            });
        </script>
    @endsection
