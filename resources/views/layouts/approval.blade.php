<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pusat Persetujuan') - Lavanaya Travel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css'])

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Premium: Hitam & Aksen Emas Mewah */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111111;
            color: #ffffff;
            z-index: 100;
            border-right: 1px solid rgba(197, 168, 90, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 0;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.65);
            padding: 0.8rem 1.2rem;
            font-weight: 500;
            border-radius: 10px;
            margin: 0.2rem 1rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(197, 168, 90, 0.12) !important;
            color: #c5a85a !important;
        }

        /* Wrapper Utama Konten */
        .main-wrapper {
            margin-left: 260px;
            padding: 2.5rem;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Kustomisasi Card Elegan */
        .card-custom {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01);
        }

        .text-gold {
            color: #c5a85a !important;
        }

        .bg-gold-light {
            background-color: rgba(197, 168, 90, 0.1) !important;
        }

        /* Batasan Interaksi Fokus Form Catatan SPV */
        .form-control-notes:focus {
            border-color: #c5a85a !important;
            box-shadow: 0 0 0 0.15rem rgba(197, 168, 90, 0.2) !important;
        }

        /* Kustomisasi Pagination Menjadi Bertema Emas Lavanaya */
        .pagination .page-item.active .page-link {
            background-color: #c5a85a !important;
            border-color: #c5a85a !important;
            color: #ffffff !important;
        }

        .pagination .page-link {
            color: #c5a85a !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: rgba(197, 168, 90, 0.1) !important;
            color: #c5a85a !important;
            border-color: #c5a85a !important;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d !important;
            background-color: #f8f9fa !important;
            border-color: rgba(0, 0, 0, 0.05) !important;
        }

        /* Kustomisasi Efek Shadow Ringan pada Tombol Angka */
        .pagination .page-link:focus {
            box-shadow: 0 0 0 0.2rem rgba(197, 168, 90, 0.25) !important;
        }

        /* Penyesuaian Responsif Layar */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div>
            <div class="px-4 mb-4 d-flex align-items-center gap-2">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" class="text-gold">
                    <path
                        d="M19,4H5A2,2 0 0,0 3,6V18A2,2 0 0,0 5,20H19A2,2 0 0,0 21,18V6A2,2 0 0,0 19,4M19,7.5L12,13L5,7.5V6L12,11.5L19,6V7.5Z" />
                </svg>
                <span class="fw-bold tracking-widest text-white fs-5" style="letter-spacing: 1.5px;">LAVANAYA</span>
            </div>

            <small class="text-uppercase text-muted px-4 fw-bold mb-2 d-block"
                style="font-size: 0.65rem; letter-spacing: 1px; opacity: 0.6;">Otorisasi Berjenjang</small>

            <nav class="nav flex-column">
                <a class="nav-link {{ Request::is('*/dashboard') ? 'active' : '' }}"
                    href="{{ route(strtolower(Auth::user()->role->name) . '.dashboard') }}">
                    <i class="fa-solid fa-stamp"></i>
                    <span>Antrean Approval</span>
                </a>
                <a class="nav-link {{ Request::is('*/history') ? 'active' : '' }}"
                    href="{{ route(strtolower(Auth::user()->role->name) . '.history') }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat Pembukuan</span>
                </a>
                @if (strtolower(Auth::user()->role->name) === 'finance')
                    <a class="nav-link {{ Request::routeIs('finance.history') ? 'active' : '' }}"
                        href="{{ route('finance.history') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Riwayat Pembukuan</span>
                    </a>
                @endif
            </nav>
        </div>

        <div class="px-3">
            <div
                class="p-3 bg-secondary bg-opacity-10 rounded-3 mb-3 d-flex align-items-center gap-2 border border-secondary border-opacity-10">
                <div class="bg-gold-light text-gold rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                    style="width: 38px; height: 38px; min-width: 38px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="overflow-hidden" style="font-size: 0.8rem;">
                    <h6 class="text-white mb-0 text-truncate fw-semibold">{{ Auth::user()->name }}</h6>

                    <small class="text-gold fw-semibold text-uppercase" style="font-size: 0.65rem;">
                        {{ Auth::user()->role->name }}
                    </small>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="d-grid">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-2 py-2 text-start ps-3">
                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="main-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">@yield('page_heading', 'Pusat Approval')</h3>
                <small class="text-muted">Lavanaya Madinah Travel Verification Desk</small>
            </div>

            <div class="bg-white px-3 py-2 rounded-3 border d-none d-sm-block shadow-sm text-secondary"
                style="font-size: 0.85rem;">
                <i class="fa-regular fa-calendar-days me-2 text-gold"></i>
                <span class="fw-semibold">{{ date('d M Y') }}</span>
            </div>
        </div>

        <main>
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
