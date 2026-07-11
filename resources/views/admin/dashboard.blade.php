@extends('layouts.admin')

@section('title', 'Beranda Utama')
@section('page_heading', 'Dashboard Overview')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small fw-bold text-uppercase">Total Pengguna</span>
                <div class="bg-gold-light text-gold rounded-3 p-2"><i class="fa-solid fa-users fs-5"></i></div>
            </div>
            <h2 class="fw-bold text-dark mb-1">{{ \App\Models\User::count() }}</h2>
            <small class="text-success fw-semibold"><i class="fa-solid fa-arrow-trend-up me-1"></i> Aktif terdaftar</small>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small fw-bold text-uppercase">Kategori</span>
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2"><i class="fa-solid fa-tags fs-5"></i></div>
            </div>
            <h2 class="fw-bold text-dark mb-1">{{ \App\Models\Category::count() }}</h2>
            <small class="text-muted">Kategori operasional</small>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted small fw-bold text-uppercase">Plafon Budget</span>
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-2"><i class="fa-solid fa-wallet fs-5"></i></div>
            </div>
            <h2 class="fw-bold text-dark mb-1">{{ \App\Models\Budget::count() }}</h2>
            <small class="text-muted">Alokasi divisi</small>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card card-custom p-4 text-white border-0" style="background: linear-gradient(135deg, #111 0%, #2b2514 100%);">
            <div class="d-flex flex-column h-100 justify-content-between">
                <div>
                    <h6 class="fw-bold text-gold mb-1">Pusat Data Master</h6>
                    <p class="small text-white-50 mb-3">Kelola akun, alokasi dana, dan parameter operasional travel.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light text-dark fw-bold rounded-2 w-100">
                    Buka Pengelolaan <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold mb-3">Analitik Pengajuan Transaksi</h5>
            <div class="alert bg-light border rounded-3 d-flex align-items-center p-4">
                <div class="fs-1 text-gold me-4"><i class="fa-solid fa-circle-info"></i></div>
                <div>
                    <h6 class="fw-bold text-dark">Sistem Siap Digunakan</h6>
                    <p class="small text-muted mb-0">Semua modul pengelolaan data master (User, Kategori, dan Plafon Budget) telah terintegrasi dengan arsitektur hak akses terproteksi (RBAC Middleware). Silakan gunakan panel kontrol samping untuk melakukan penyesuaian parameter.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold mb-3">Ringkasan Sistem</h5>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                    <span class="text-muted">Framework Dasar</span>
                    <span class="badge bg-dark rounded-pill">Laravel 12</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                    <span class="text-muted">UI CSS Kit</span>
                    <span class="badge bg-primary rounded-pill">Bootstrap 5.3</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 bg-transparent">
                    <span class="text-muted">Tema Vibe</span>
                    <span class="badge bg-gold-light text-gold rounded-pill fw-bold">Lavanaya Premium</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection