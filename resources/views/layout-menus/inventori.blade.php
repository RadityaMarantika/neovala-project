@extends('layouts.base')

@section('content')
    <div class="container-fluid py-4">

        {{-- HERO CARD --}}
        <div class="card border-0 shadow-sm mb-5 hero-card text-white">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-semibold mb-1">
                        <i class="fas fa-boxes me-2"></i>Inventory Dashboard
                    </h5>
                    <p class="mb-0 small opacity-75">
                        Manage your inventory and warehouse operations efficiently
                    </p>
                </div>
                <i class="fas fa-chart-line fa-2x text-white-50"></i>
            </div>
        </div>

        {{-- FEATURE SECTIONS --}}
        <div class="feature-sections">

            {{-- WAREHOUSE & INVENTORY --}}
            <div class="section-card mb-5">
                <div class="section-header">
                    <i class="fas fa-warehouse me-2"></i>Warehouse & Inventory
                </div>
                <div class="section-body row g-3 px-3 pb-3 pt-2">

                    {{-- Warehouse List --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('master-pettycash.index') }}">
                            <div class="icon bg-1"><i class="fas fa-warehouse"></i></div>
                            <p class="title">Warehouse</p>
                        </div>
                    </div>

                    {{-- Inventory Items --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('master_inventori.index') }}">
                            <div class="icon bg-2"><i class="fas fa-boxes"></i></div>
                            <p class="title">Inventory Item</p>
                        </div>
                    </div>

                    {{-- Warehouse Items --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('master_inventori_gudang.index') }}">
                            <div class="icon bg-3"><i class="fas fa-cubes"></i></div>
                            <p class="title">Warehouse Item</p>
                        </div>
                    </div>

                    {{-- Warehouse Item Mutation --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('gudang_transfer.index') }}">
                            <div class="icon bg-4"><i class="fas fa-exchange-alt"></i></div>
                            <p class="title">Warehouse Item Mutation</p>
                        </div>
                    </div>

                    {{-- Purchase Order --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('purchase-orders.index') }}">
                            <div class="icon bg-6"><i class="fas fa-file-invoice"></i></div>
                            <p class="title">Purchase Order</p>
                        </div>
                    </div>

                    {{-- Take Item From Warehouse --}}
                    <div class="col-6 col-md-3">
                        <div class="feature-card" data-href="{{ route('gudang-ambils.index') }}">
                            <div class="icon bg-7"><i class="fas fa-dolly"></i></div>
                            <p class="title">Take Item From Warehouse</p>
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

            .bg-6 {
                background: linear-gradient(135deg, #43cea2, #185a9d);
            }

            .bg-7 {
                background: linear-gradient(135deg, #f7971e, #ffd200);
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
    </div>
@endsection
