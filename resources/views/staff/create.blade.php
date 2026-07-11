@extends('layouts.staff')

@section('title', 'Buat Pengajuan Baru')
@section('page_heading', 'Formulir Pengajuan Dana')

@section('content')
<div class="mb-3">
    <a href="{{ route('staff.dashboard') }}" class="text-decoration-none small fw-semibold text-secondary link-lavanaya-bootstrap">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
    </a>
</div>

<div class="row">
    <div class="col-lg-9 col-xl-8">
        <div class="card card-custom border-0 shadow-sm">
            <div class="card-header bg-white pt-4 pb-2 border-bottom-0 px-4">
                <h5 class="fw-bold text-dark mb-1">Pengajuan Transaksi Pengeluaran</h5>
                <p class="small text-muted mb-0">Isi parameter di bawah ini secara lengkap untuk divalidasi oleh berjenjang.</p>
            </div>
            
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 small py-2 mb-4" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close py-2.5" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="category_id" class="form-label small fw-bold text-secondary">Kategori Pengajuan <span class="text-danger">*</span></label>
                        <select class="form-select form-control-lavanaya rounded-3" id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label small fw-bold text-secondary">Nilai Pengajuan (Rupiah) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-secondary bg-opacity-10 text-secondary border-end-0 rounded-start-3 fw-semibold">Rp</span>
                            <input type="number" class="form-control form-control-lavanaya border-start-0 rounded-end-3" 
                                   id="amount" name="amount" value="{{ old('amount') }}" placeholder="Contoh: 7500000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold text-secondary">Deskripsi / Rincian Keperluan <span class="text-danger">*</span></label>
                        <textarea class="form-control form-control-lavanaya rounded-3" id="description" name="description" 
                                  rows="4" placeholder="Tuliskan alasan operasional travel atau rincian keperluan pengeluaran dana..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="attachment_file" class="form-label small fw-bold text-secondary">Lampiran Dokumen Pendukung <span class="text-danger">*</span></label>
                        <input class="form-control form-control-lavanaya rounded-3 mb-1" type="file" id="attachment_file" name="attachment_file" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="form-text text-muted" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-circle-info me-1"></i> Format berkas wajib: <strong>PDF, JPG, JPEG, PNG</strong>. Maksimal ukuran: 5 MB.
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25 my-4">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-dark rounded-3 px-4 py-2 fw-semibold shadow-sm btn-lavanaya-bootstrap" style="background-color: #111;">
                            <i class="fa-regular fa-paper-plane me-1"></i> Kirim Pengajuan Dana
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection