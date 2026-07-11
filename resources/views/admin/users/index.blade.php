@extends('layouts.admin')

@section('title', 'Pengelolaan Data Master')
@section('page_heading', 'Manajemen Data Kontrol')

@section('content')
<div class="card card-custom">
    <div class="card-header bg-white pt-3 border-0">
        <ul class="nav nav-tabs card-header-tabs" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold text-secondary" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                    <i class="fa-solid fa-user-gear me-1"></i> Kelola Karyawan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold text-secondary" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">
                    <i class="fa-solid fa-tags me-1"></i> Kelola Kategori
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold text-secondary" id="budgets-tab" data-bs-toggle="tab" data-bs-target="#budgets" type="button" role="tab">
                    <i class="fa-solid fa-wallet me-1"></i> Plafon Anggaran (Budget)
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content" id="adminTabsContent">
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <p class="text-muted small">Fitur kelola akun karyawan aktif.</p>
            </div>

            <div class="tab-pane fade" id="categories" role="tabpanel">
                <p class="text-muted small">Fitur parameter kategori pengajuan transaksi.</p>
            </div>

            <div class="tab-pane fade" id="budgets" role="tabpanel">
                <p class="text-muted small">Fitur parameter plafon anggaran divisi.</p>
            </div>
        </div>
    </div>
</div>
@endsection