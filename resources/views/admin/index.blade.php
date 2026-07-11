@extends('layouts.admin')

@section('title', 'Master Data Perusahaan')
@section('page_heading', 'Pengelolaan Data Master')

@section('content')
<div class="card card-custom border-0 shadow-sm">
    <div class="card-header bg-white pt-3 border-bottom">
        <!-- Nav Tabs Menu Pengelolaan Bergaya Modern -->
        <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="adminTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold text-secondary" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                    <i class="fa-solid fa-users me-1"></i> Kelola Akun Karyawan
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold text-secondary" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">
                    <i class="fa-solid fa-tags me-1"></i> Kelola Kategori Pengajuan
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
        <!-- Notifikasi Toast / Alert Sukses & Error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content" id="adminTabContent">
            
            <!-- ==========================================
                 TAB 1: USER MANAGEMENT
                 ========================================== -->
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card p-3 border rounded-3 bg-light bg-opacity-50">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-plus me-1 text-gold"></i> Tambah Akun Karyawan</h6>
                            <form action="{{ route('admin.users.store') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="small fw-semibold text-secondary">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-sm rounded-2" placeholder="Nama staf" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-semibold text-secondary">Email Perusahaan</label>
                                    <input type="email" name="email" class="form-control form-control-sm rounded-2" placeholder="contoh@lavanaya.com" required>
                                </div>
                                <div class="mb-2">
                                    <label class="small fw-semibold text-secondary">Kata Sandi Default</label>
                                    <input type="password" name="password" class="form-control form-control-sm rounded-2" placeholder="••••••••" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-semibold text-secondary">Jabatan / Hak Akses</label>
                                    <select name="role_id" class="form-select form-select-sm rounded-2" required>
                                        @foreach($roles as $role) 
                                            <option value="{{ $role->id }}">{{ strtoupper($role->name) }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark w-100 rounded-2 fw-semibold" style="background-color: #111;">
                                    Simpan Akun
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive rounded-3 border">
                            <table class="table bg-white align-middle mb-0 table-hover">
                                <thead class="table-light text-secondary small">
                                    <tr>
                                        <th class="py-3">Nama</th>
                                        <th class="py-3">Email</th>
                                        <th class="py-3">Jabatan</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @foreach($users as $u)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-gold-light text-gold rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.75rem;">
                                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                                </div>
                                                <strong class="text-dark">{{ $u->name }}</strong>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ $u->email }}</td>
                                        <td>
                                            <span class="badge bg-gold-light text-gold rounded-pill px-2.5 py-1.5 fw-bold" style="font-size: 0.7rem;">
                                                {{ strtoupper($u->role->name) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Hapus user?')">
                                                @csrf @method('DELETE') 
                                                <button class="btn btn-link link-danger p-0 border-0 shadow-none small">
                                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 2: CATEGORY MANAGEMENT
                 ========================================== -->
            <div class="tab-pane fade" id="categories" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card p-3 border rounded-3 bg-light bg-opacity-50">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-folder-plus me-1 text-gold"></i> Buat Kategori Baru</h6>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="small fw-semibold text-secondary">Nama Kategori</label>
                                    <input type="text" name="name" class="form-control form-control-sm rounded-2" placeholder="Contoh: Tiket Pesawat, Visa, ATK" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark w-100 rounded-2 fw-semibold" style="background-color: #111;">
                                    Simpan Kategori
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive rounded-3 border">
                            <table class="table bg-white align-middle mb-0 table-hover">
                                <thead class="table-light text-secondary small">
                                    <tr>
                                        <th class="py-3">ID Kategori</th>
                                        <th class="py-3">Nama Kategori Operasional</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @foreach($categories as $c)
                                    <tr>
                                        <td class="text-muted">#CAT-{{ sprintf('%03d', $c->id) }}</td>
                                        <td><strong class="text-dark">{{ $c->name }}</strong></td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.categories.delete', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori?')">
                                                @csrf @method('DELETE') 
                                                <button class="btn btn-link link-danger p-0 border-0 shadow-none small">
                                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==========================================
                 TAB 3: BUDGET MANAGEMENT
                 ========================================== -->
            <div class="tab-pane fade" id="budgets" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card p-3 border rounded-3 bg-light bg-opacity-50">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-wallet me-1 text-gold"></i> Alokasikan Anggaran (Tahun {{ now()->format('Y') }})</h6>
                            <form action="{{ route('admin.budgets.store') }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="small fw-semibold text-secondary">Pilih Kategori</label>
                                    <select name="category_id" class="form-select form-select-sm rounded-2" required>
                                        @foreach($categories as $c) 
                                            <option value="{{ $c->id }}">{{ $c->name }}</option> 
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-semibold text-secondary">Nilai Plafon Anggaran (Rp)</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-secondary bg-opacity-10 text-secondary border-end-0">Rp</span>
                                        <input type="number" name="amount" class="form-control border-start-0 rounded-end-2" placeholder="0" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark w-100 rounded-2 fw-semibold" style="background-color: #111;">
                                    Aktifkan Anggaran
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="table-responsive rounded-3 border">
                            <table class="table bg-white align-middle mb-0 table-hover">
                                <thead class="table-light text-secondary small">
                                    <tr>
                                        <th class="py-3">Kategori</th>
                                        <th class="py-3">Plafon Tersedia</th>
                                        <th class="py-3">Tahun Fiskal</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    @foreach($budgets as $b)
                                    <tr>
                                        <td><strong class="text-dark">{{ $b->category->name }}</strong></td>
                                        <td class="text-success fw-bold">Rp {{ number_format($b->amount, 0, ',', '.') }}</td>
                                        <td class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $b->fiscal_year }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.budgets.delete', $b->id) }}" method="POST" onsubmit="return confirm('Hapus anggaran?')">
                                                @csrf @method('DELETE') 
                                                <button class="btn btn-link link-danger p-0 border-0 shadow-none small">
                                                    <i class="fa-regular fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection